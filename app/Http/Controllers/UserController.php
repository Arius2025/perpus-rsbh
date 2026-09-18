<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Memastikan hanya Akun Utama (Superadmin) yang dapat mengakses dan mengelola akun.
     */
    protected function authorizeAdminUtama(): void
    {
        if (!auth()->check() || !auth()->user()->isAdminUtama()) {
            abort(403, 'Akses ditolak. Hanya Akun Utama yang berhak mengelola dan mengedit akun.');
        }
    }

    public function index()
    {
        $this->authorizeAdminUtama();

        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdminUtama();

        // Normalisasi email ke huruf kecil tanpa spasi
        $email = strtolower(trim((string)$request->input('email')));
        $request->merge(['email' => $email]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', Password::defaults()],
            'role' => 'nullable|string|in:petugas,admin_utama',
        ], [
            'email.unique' => 'Email ini sudah digunakan oleh akun lain. Tidak boleh ada email yang sama.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format penulisan email tidak valid.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'petugas',
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Akun berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeAdminUtama();

        // Normalisasi email ke huruf kecil tanpa spasi
        $email = strtolower(trim((string)$request->input('email')));
        $request->merge(['email' => $email]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', Password::defaults()],
            'role' => 'nullable|string|in:petugas,admin_utama',
        ], [
            'email.unique' => 'Email ini sudah digunakan oleh akun lain. Tidak boleh ada email yang sama.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format penulisan email tidak valid.',
            'name.required' => 'Nama lengkap wajib diisi.',
        ]);

        $user->name = $validated['name'];

        // Lindungi akun utama sistem agar tidak terubah emailnya
        if ($user->email !== 'rsbaladhikahusada@gmail.com') {
            $user->email = $validated['email'];
        }

        if (!empty($validated['role']) && $user->email !== 'rsbaladhikahusada@gmail.com') {
            $user->role = $validated['role'];
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Data akun berhasil diperbarui.');
    }

    public function toggleStatus(User $user)
    {
        $this->authorizeAdminUtama();

        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak bisa menonaktifkan akun sendiri.');
        }

        if ($user->isAdminUtama() || $user->email === 'rsbaladhikahusada@gmail.com') {
            return redirect()->back()->with('error', 'Akun Utama tidak dapat dinonaktifkan.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Akun user berhasil {$status}.");
    }

    public function destroy(User $user)
    {
        $this->authorizeAdminUtama();

        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri yang sedang aktif.');
        }

        if ($user->isAdminUtama() || $user->email === 'rsbaladhikahusada@gmail.com') {
            return redirect()->back()->with('error', 'Akun Utama sistem tidak dapat dihapus.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->back()->with('success', "Akun '{$userName}' berhasil dihapus.");
    }
}

