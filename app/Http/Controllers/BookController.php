<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    // --- Public Methods (View Only) ---
    public function index(Request $request)
    {
        $query = Book::where('is_active', true)->with('category_ref');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->input('category') !== 'All' && $request->input('category') !== 'Semua Koleksi') {
            $query->whereHas('category_ref', function($q) use ($request) {
                $q->where('name', $request->input('category'));
            });
        }

        $sort = $request->input('sort', 'default');
        if ($sort === 'az') {
            $query->orderBy('title', 'asc');
        } elseif ($sort === 'author') {
            $query->orderBy('author', 'asc');
        } else {
            $query->latest();
        }

        $books = $query->paginate(12)->withQueryString();
        $totalBooks = Book::where('is_active', true)->count();
        $categories = Category::where('is_active', true)
            ->withCount(['books' => fn($q) => $q->where('is_active', true)])
            ->get();

        return view('home', compact('books', 'categories', 'totalBooks', 'sort'));
    }

    public function show(Book $book)
    {
        if (!$book->is_active && !auth()->check()) {
            abort(404);
        }
        $book->load(['category_ref', 'uploader']);
        return view('show', compact('book'));
    }

    public function viewPdf(Book $book)
    {
        if (!$book->is_active && !auth()->check()) {
            abort(404);
        }
        
        if ($book->external_link) {
            return redirect($book->external_link);
        }

        $book->increment('download_count');
        
        $filePath = public_path('uploads/books/' . $book->pdf_file);
        if ($book->pdf_file && file_exists($filePath)) {
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $book->pdf_file . '"'
            ]);
        }
        
        return abort(404, 'File not found');
    }

    public function download(Book $book)
    {
        if (!$book->is_active && !auth()->check()) {
            abort(404);
        }
        
        if ($book->external_link) {
            return redirect($book->external_link);
        }

        $book->increment('download_count');
        
        $filePath = public_path('uploads/books/' . $book->pdf_file);
        if ($book->pdf_file && file_exists($filePath)) {
            return response()->download($filePath);
        }
        
        return abort(404, 'File not found');
    }

    // --- Admin CRUD Methods ---
    public function dashboard()
    {
        $books = Book::with(['category_ref', 'uploader'])->latest()->paginate(20);
        return view('admin.dashboard', compact('books'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'pdf_file' => 'required_without:external_link|nullable|mimes:pdf|max:10240',
            'external_link' => 'required_without:pdf_file|nullable|url',
        ]);

        $uploadPath = public_path('uploads/books');
        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true, true);
        }

        if ($request->hasFile('cover_image')) {
            $coverImage = time() . '_cover.' . $request->file('cover_image')->extension();
            $request->file('cover_image')->move($uploadPath, $coverImage);
            $validated['cover_image'] = $coverImage;
        }

        if ($request->hasFile('pdf_file')) {
            $pdfFile = time() . '_book.' . $request->file('pdf_file')->extension();
            $request->file('pdf_file')->move($uploadPath, $pdfFile);
            $validated['pdf_file'] = $pdfFile;
        }

        // Record the uploader
        $validated['user_id'] = auth()->id();

        Book::create($validated);
        return redirect()->route('admin.dashboard')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        if (!auth()->user()->canManageBook($book)) {
            abort(403, 'Akses ditolak. Anda hanya dapat mengedit buku yang Anda unggah sendiri kecuali Admin Utama.');
        }

        $categories = Category::where('is_active', true)->get();
        return view('admin.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        if (!auth()->user()->canManageBook($book)) {
            abort(403, 'Akses ditolak. Anda hanya dapat mengubah buku yang Anda unggah sendiri kecuali Admin Utama.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:10240',
            'external_link' => 'nullable|url',
        ]);

        $uploadPath = public_path('uploads/books');

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image && File::exists($uploadPath . '/' . $book->cover_image)) {
                File::delete($uploadPath . '/' . $book->cover_image);
            }
            $coverImage = time() . '_cover.' . $request->file('cover_image')->extension();
            $request->file('cover_image')->move($uploadPath, $coverImage);
            $validated['cover_image'] = $coverImage;
        }

        if ($request->hasFile('pdf_file')) {
            if ($book->pdf_file && File::exists($uploadPath . '/' . $book->pdf_file)) {
                File::delete($uploadPath . '/' . $book->pdf_file);
            }
            $pdfFile = time() . '_book.' . $request->file('pdf_file')->extension();
            $request->file('pdf_file')->move($uploadPath, $pdfFile);
            $validated['pdf_file'] = $pdfFile;
        }

        $book->update($validated);
        return redirect()->route('admin.dashboard')->with('success', 'Buku berhasil diperbarui.');
    }

    public function toggleVisibility(Book $book)
    {
        if (!auth()->user()->canManageBook($book)) {
            abort(403, 'Akses ditolak. Anda hanya dapat mengubah status buku yang Anda unggah sendiri kecuali Admin Utama.');
        }

        $book->update(['is_active' => !$book->is_active]);
        $status = $book->is_active ? 'ditampilkan' : 'disembunyikan';
        return redirect()->back()->with('success', "Buku berhasil {$status}.");
    }

    public function destroy(Book $book)
    {
        if (!auth()->user()->canManageBook($book)) {
            abort(403, 'Akses ditolak. Anda hanya dapat menghapus buku yang Anda unggah sendiri kecuali Admin Utama.');
        }

        $uploadPath = public_path('uploads/books');
        if ($book->cover_image && File::exists($uploadPath . '/' . $book->cover_image)) {
            File::delete($uploadPath . '/' . $book->cover_image);
        }
        if ($book->pdf_file && File::exists($uploadPath . '/' . $book->pdf_file)) {
            File::delete($uploadPath . '/' . $book->pdf_file);
        }

        $book->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Buku berhasil dihapus secara permanen.');
    }
}
