@extends('layout')

@section('title', 'Manajemen Akun - PustakaDigital RS Baladhika Husada')

@section('styles')
<style>
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }
    .status-badge.active {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .status-badge.inactive {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    :root[data-theme="dark"] .status-badge.active {
        background: #064e3b;
        color: #6ee7b7;
        border-color: #047857;
    }
    :root[data-theme="dark"] .status-badge.inactive {
        background: #7f1d1d;
        color: #fca5a5;
        border-color: #991b1b;
    }
    .role-pill {
        display: inline-flex;
        align-items: center;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }
    .role-pill.primary {
        background: var(--accent);
        color: #ffffff;
    }
    .role-pill.secondary {
        background: var(--soft);
        color: var(--text);
        border: 1px solid var(--line);
    }
</style>
@endsection

@section('content')
<div class="wrap admin-wrap py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--text); letter-spacing: -0.5px;">Manajemen Akun Pengguna</h2>
            <p class="text-muted mb-0" style="font-size: 14px;">
                <i class="bi bi-shield-lock-fill me-1" style="color: var(--accent);"></i>
                Khusus Akun Utama. Kelola akses admin perpustakaan. Sistem menjamin tidak boleh ada email yang sama.
            </p>
        </div>
        <button class="primary" style="min-height: 44px; padding: 10px 20px;" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-person-plus-fill me-2"></i> Tambah Akun Baru
        </button>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: var(--radius); border-left: 4px solid #ef4444;">
            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Perhatian:</div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Desktop Table View -->
    <div class="card border shadow-sm d-none d-lg-block mb-4" style="border-radius: var(--radius); background: var(--surface); border-color: var(--line) !important; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: var(--bg); border-bottom: 1px solid var(--line);">
                        <tr>
                            <th class="ps-4" width="6%">No</th>
                            <th width="32%">Nama & Email</th>
                            <th width="16%">Peran Akun</th>
                            <th class="text-center" width="12%">Status</th>
                            <th width="16%">Terdaftar</th>
                            <th class="text-center pe-4" width="18%">Aksi Pengelolaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr>
                            <td class="ps-4 text-muted">{{ $users->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold" style="color: var(--text);">{{ $user->name }}</div>
                                <div class="small text-muted">{{ $user->email }}</div>
                            </td>
                            <td>
                                @if($user->isAdminUtama() || $user->email === 'rsbaladhikahusada@gmail.com')
                                    <span class="role-pill primary">
                                        <i class="bi bi-star-fill me-1" style="font-size: 10px;"></i> Akun Utama
                                    </span>
                                @else
                                    <span class="role-pill secondary">Petugas</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($user->is_active)
                                    <span class="status-badge active">Aktif</span>
                                @else
                                    <span class="status-badge inactive">Nonaktif</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-outline-primary px-2" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}" title="Edit data akun">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </button>
                                    
                                    @if(auth()->id() !== $user->id && !$user->isAdminUtama() && $user->email !== 'rsbaladhikahusada@gmail.com')
                                        <form action="{{ route('admin.users.toggle', $user->id, false) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} px-2" style="border-radius: 6px;" title="{{ $user->is_active ? 'Nonaktifkan akun' : 'Aktifkan akun' }}">
                                                <i class="bi {{ $user->is_active ? 'bi-person-x' : 'bi-person-check' }}"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.users.destroy', $user->id, false) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $user->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger px-2" style="border-radius: 6px;" title="Hapus akun">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="d-lg-none">
        @foreach($users as $index => $user)
            <div class="card border shadow-sm mb-3 overflow-hidden" style="border-radius: var(--radius); background: var(--surface); border-color: var(--line) !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="fw-bold" style="color: var(--text); font-size: 15px;">{{ $user->name }}</div>
                            <div class="small text-muted mb-1">{{ $user->email }}</div>
                            <div class="d-flex gap-2 align-items-center">
                                @if($user->isAdminUtama() || $user->email === 'rsbaladhikahusada@gmail.com')
                                    <span class="role-pill primary" style="font-size: 10px;">Akun Utama</span>
                                @else
                                    <span class="role-pill secondary" style="font-size: 10px;">Petugas</span>
                                @endif
                                
                                @if($user->is_active)
                                    <span class="status-badge active" style="font-size: 10px; padding: 2px 6px;">Aktif</span>
                                @else
                                    <span class="status-badge inactive" style="font-size: 10px; padding: 2px 6px;">Nonaktif</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2 mt-3 pt-2" style="border-top: 1px solid var(--line);">
                        <button class="btn btn-sm btn-outline-primary flex-grow-1" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </button>
                        
                        @if(auth()->id() !== $user->id && !$user->isAdminUtama() && $user->email !== 'rsbaladhikahusada@gmail.com')
                            <form action="{{ route('admin.users.toggle', $user->id, false) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}" style="border-radius: 6px;">
                                    <i class="bi {{ $user->is_active ? 'bi-person-x' : 'bi-person-check' }}"></i>
                                </button>
                            </form>

                            <form action="{{ route('admin.users.destroy', $user->id, false) }}" method="POST" onsubmit="return confirm('Hapus akun {{ $user->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 6px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

@section('modals')
    @foreach($users as $index => $user)
        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: var(--radius); border: 1px solid var(--line); background: var(--surface);">
                    <div class="modal-header pb-0" style="border-bottom: 1px solid var(--line);">
                        <div>
                            <h5 class="modal-title fw-bold" style="color: var(--text);">Edit Akun: {{ $user->name }}</h5>
                            <p class="small text-muted mb-0">Hanya Akun Utama yang dapat memperbarui akun ini.</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.users.update', $user->id, false) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body p-4">
                            @if($user->email === 'rsbaladhikahusada@gmail.com')
                                <div class="alert alert-info py-2 px-3 small mb-3" style="border-radius: 6px;">
                                    <i class="bi bi-shield-check me-1"></i> Ini adalah Akun Utama institusi. Email terlindungi secara permanen.
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required style="border-radius: 8px;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted">Alamat Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required {{ $user->email === 'rsbaladhikahusada@gmail.com' ? 'readonly' : '' }} style="border-radius: 8px;">
                                <div class="form-text small text-danger mt-1">
                                    <i class="bi bi-info-circle me-1"></i>Email harus unik. Tidak boleh ada akun lain yang menggunakan email yang sama.
                                </div>
                            </div>

                            @if($user->email !== 'rsbaladhikahusada@gmail.com')
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Peran Akun</label>
                                    <select name="role" class="form-select" style="border-radius: 8px;">
                                        <option value="petugas" {{ $user->role === 'petugas' ? 'selected' : '' }}>Petugas</option>
                                        <option value="admin_utama" {{ $user->role === 'admin_utama' ? 'selected' : '' }}>Admin Utama</option>
                                    </select>
                                </div>
                            @endif

                            <div class="mb-0">
                                <label class="form-label small fw-bold text-uppercase text-muted">Password Baru (Opsional)</label>
                                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin diubah" style="border-radius: 8px;">
                            </div>
                        </div>
                        <div class="modal-footer pt-0 p-4" style="border-top: 1px solid var(--line);">
                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 6px;">Batal</button>
                            <button type="submit" class="btn btn-primary px-4" style="border-radius: 6px; background: var(--accent); border-color: var(--accent);">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: var(--radius); border: 1px solid var(--line); background: var(--surface);">
                <div class="modal-header pb-0" style="border-bottom: 1px solid var(--line);">
                    <div>
                        <h5 class="modal-title fw-bold" style="color: var(--text);">Tambah Akun Baru</h5>
                        <p class="small text-muted mb-0">Hanya Akun Utama yang berhak menambahkan akun.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.store', [], false) }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama pengguna" value="{{ old('name') }}" required style="border-radius: 8px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Alamat Email</label>
                            <input type="email" name="email" class="form-control" placeholder="contoh@rsbaladhikahusada.com" value="{{ old('email') }}" required style="border-radius: 8px;">
                            <div class="form-text small text-danger mt-1">
                                <i class="bi bi-info-circle me-1"></i>Email harus unik. Tidak boleh ada email yang sama yang didaftarkan ulang.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Peran Akun</label>
                            <select name="role" class="form-select" style="border-radius: 8px;">
                                <option value="petugas" selected>Petugas</option>
                                <option value="admin_utama">Admin Utama</option>
                            </select>
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold text-uppercase text-muted">Kata Sandi</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required style="border-radius: 8px;">
                        </div>
                    </div>
                    <div class="modal-footer pt-0 p-4" style="border-top: 1px solid var(--line);">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 6px;">Batal</button>
                        <button type="submit" class="btn btn-primary px-4" style="border-radius: 6px; background: var(--accent); border-color: var(--accent);">Tambah Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

