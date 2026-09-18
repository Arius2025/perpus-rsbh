@extends('layout')

@section('title', 'Manajemen Kategori - PustakaDigital')

@section('styles')
<style>
    .category-card {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 20px;
        border: 1px solid var(--line);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: border-color var(--motion) ease;
    }

    .category-card:hover {
        border-color: var(--accent);
    }

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

    .status-active {
        background-color: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .status-hidden {
        background-color: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    :root[data-theme="dark"] .status-active {
        background-color: #064e3b;
        color: #6ee7b7;
        border-color: #047857;
    }

    :root[data-theme="dark"] .status-hidden {
        background-color: #7f1d1d;
        color: #fca5a5;
        border-color: #991b1b;
    }
</style>
@endsection

@section('content')
<div class="wrap admin-wrap py-4">
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Manajemen Kategori</h2>
            <p class="text-muted mb-0">Tambah, edit, atau sembunyikan kategori buku.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <button class="primary" style="min-height: 44px; padding: 10px 20px;" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
            </button>
        </div>
    </div>

    <div class="row g-4">
        @forelse($categories as $category)
            <div class="col-md-4 col-sm-6">
                <div class="category-card">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold mb-0">{{ $category->name }}</h5>
                            <span class="status-badge {{ $category->is_active ? 'status-active' : 'status-hidden' }}">
                                {{ $category->is_active ? 'Aktif' : 'Tersembunyi' }}
                            </span>
                        </div>
                        <p class="small text-muted mb-0">{{ $category->books_count ?? $category->books()->count() }} Buku</p>
                    </div>
                    
                    <div class="d-flex gap-2 mt-4">
                        <button class="btn btn-sm btn-outline-secondary flex-grow-1" style="border-radius: 6px; min-height: 40px;" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </button>
                        <form action="{{ route('admin.categories.toggle', $category->id) }}" method="POST" class="flex-grow-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $category->is_active ? 'btn-outline-danger' : 'btn-outline-success' }} w-100" style="border-radius: 6px; min-height: 40px;">
                                <i class="bi {{ $category->is_active ? 'bi-eye-slash' : 'bi-eye' }} me-1"></i>
                                {{ $category->is_active ? 'Sembunyikan' : 'Tampilkan' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-tag fs-1 text-muted d-block mb-3"></i>
                <h5 class="text-muted">Belum ada kategori.</h5>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('modals')
    @foreach($categories as $category)
        <!-- Edit Category Modal -->
        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 20px;">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-bold">Edit Kategori</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Kategori</label>
                                <input type="text" name="name" class="form-control" value="{{ $category->name }}" required style="border-radius: 12px;">
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px;">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">Tambah Kategori Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Novel, Sejarah, ..." required style="border-radius: 12px;">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
