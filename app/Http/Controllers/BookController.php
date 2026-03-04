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

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->input('category') != 'All') {
            $query->whereHas('category_ref', function($q) use ($request) {
                $q->where('name', $request->input('category'));
            });
        }

        $books = $query->latest()->paginate(12);
        $categories = Category::where('is_active', true)->get();
        return view('home', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        if (!$book->is_active && !auth()->check()) {
            abort(404);
        }
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
        $books = Book::with('category_ref')->latest()->paginate(20);
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

        Book::create($validated);
        return redirect()->route('admin.dashboard')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
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
        $book->update(['is_active' => !$book->is_active]);
        $status = $book->is_active ? 'ditampilkan' : 'disembunyikan';
        return redirect()->back()->with('success', "Buku berhasil {$status}.");
    }
}
