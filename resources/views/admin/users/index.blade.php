@extends('layout')

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
</style>
@endsection

@section('content')
<div class="container-fluid pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-0">Manajemen Akun</h2>
            <p class="text-muted mb-0">Kelola akses admin dan pengaturan akun perpustakaan.</p>
        </div>
        <button class="primary" style="min-height: 44px; padding: 10px 20px;" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-person-plus-fill me-2"></i> Tambah Admin Baru
        </button>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px;">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Desktop Table View -->
    <div class="card border shadow-sm d-none d-lg-block mb-4" style="border-radius: var(--radius); background: var(--surface); border-color: var(--line) !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" width="5%">No</th>
                            <th width="30%">Nama & Email</th>
                            <th width="20%">Dibuat Pada</th>
                            <th class="text-center" width="15%">Status</th>
                            <th class="text-center pe-4" width="30%">Aksi (Edit / Status)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr>
                            <td class="ps-4">{{ $users->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold">{{ $user->name }}</div>
                                <div class="small text-muted">{{ $user->email }}</div>
                            </td>
                            <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                            <td class="text-center">
                                @if($user->is_active)
                                    <span class="status-badge active">Aktif</span>
                                @else
                                    <span class="status-badge inactive">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-outline-primary px-3" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </button>
                                    
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-outline-danger' : 'btn-outline-success' }} px-3" style="border-radius: 6px;">
                                                <i class="bi {{ $user->is_active ? 'bi-person-x-fill' : 'bi-person-check-fill' }} me-1"></i>
                                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
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
            <div class="card border-0 shadow-sm mb-3 overflow-hidden" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-circle me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person-fill fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-truncate" style="max-width: 150px;">{{ $user->name }}</h6>
                                <span class="small text-muted">{{ $user->email }}</span>
                            </div>
                        </div>
                        @if($user->is_active)
                            <span class="status-badge active">Aktif</span>
                        @else
                            <span class="status-badge inactive">Nonaktif</span>
                        @endif
                    </div>
                    
                    <div class="mb-3 small text-muted">
                        <i class="bi bi-calendar3 me-1"></i> Terdaftar: {{ $user->created_at->format('d M Y') }}
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary flex-grow-1" style="border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </button>
                        
                        @if(auth()->id() !== $user->id)
                            <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn {{ $user->is_active ? 'btn-outline-danger' : 'btn-outline-success' }} w-100" style="border-radius: 6px;">
                                    <i class="bi {{ $user->is_active ? 'bi-person-x-fill' : 'bi-person-check-fill' }} me-1"></i>
                                    {{ $user->is_active ? 'Matikan' : 'Aktifkan' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4 fade-in-up">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

@section('modals')
    @foreach($users as $index => $user)
        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 20px; border:none;">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">Edit Admin: {{ $user->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required style="border-radius: 10px;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required style="border-radius: 10px;">
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold text-uppercase text-muted">Password Baru (Kosongkan jika tidak ingin diubah)</label>
                                <input type="password" name="password" class="form-control" style="border-radius: 10px;">
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0 p-4">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border:none;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Tambah Admin Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama Admin" required style="border-radius: 10px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@pustaka.com" required style="border-radius: 10px;">
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold text-uppercase text-muted">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required style="border-radius: 10px;">
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 p-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Tambah Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
