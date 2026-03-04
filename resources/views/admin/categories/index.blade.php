@extends('layout')

@section('title', 'Manajemen Kategori - PustakaDigital')

@section('styles')
<style>
    .category-card {
        background: var(--card-bg-light);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    body.dark-mode .category-card {
        background: var(--card-bg-dark);
        border: 1px solid rgba(255,255,255,0.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-active {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }

    .status-hidden {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
</style>
@endsection

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-0">Manajemen Kategori</h2>
        <p class="text-muted mb-0">Tambah, edit, atau sembunyikan kategori buku.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="bi bi-plus-lg me-2"></i> Tambah Kategori
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
                    <button class="btn btn-sm btn-outline-secondary rounded-pill flex-grow-1" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </button>
                    <form action="{{ route('admin.categories.toggle', $category->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $category->is_active ? 'btn-outline-danger' : 'btn-outline-success' }} rounded-pill w-100">
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
