@extends('layout')

@section('title', 'Dashboard Admin - PustakaDigital')

@section('styles')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, var(--bs-primary) 0%, #115e59 100%);
        border-radius: 20px;
        padding: 2.5rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(15, 118, 110, 0.2);
    }
    
    .table-responsive {
        background: var(--card-bg-light);
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        border: 1px solid var(--card-border-light);
    }
    
    body.dark-mode .table-responsive {
        background: var(--card-bg-dark);
        border: 1px solid var(--card-border-dark);
    }
 
    .table {
        color: var(--text-color-light);
        margin-bottom: 0;
    }
    
    body.dark-mode .table {
        color: var(--text-color-dark);
        border-color: rgba(255,255,255,0.05);
    }
    
    .table th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        color: #64748b;
        border-bottom: 1px solid var(--card-border-light);
        padding: 1rem 0.5rem;
    }
    
    .table td {
        vertical-align: middle;
        padding: 1.25rem 0.5rem;
        border-bottom: 1px solid var(--card-border-light);
    }
    
    body.dark-mode .table th, body.dark-mode .table td {
        border-color: var(--card-border-dark);
    }
    
    .book-thumbnail {
        width: 45px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .thumbnail-placeholder {
        width: 45px;
        height: 60px;
        background: #f1f5f9;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }
    
    .action-btn {
        width: 38px;
        height: 38px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        margin: 0 2px;
        transition: var(--transition-smooth);
        border: 1px solid var(--card-border-light);
        background: white;
        color: #64748b;
    }
    
    .action-btn:hover {
        transform: translateY(-3px);
        background: var(--bs-primary);
        color: white;
        border-color: var(--bs-primary);
        box-shadow: 0 10px 20px rgba(15, 118, 110, 0.2);
    }
 
    .status-badge {
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12 fade-in-up">
        
        <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-1">Manajemen Koleksi Buku</h2>
                <p class="mb-0 text-muted">Akses cepat dan kelola seluruh koleksi perpustakaan.</p>
            </div>
            <a href="{{ route('admin.books.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Buku Baru</span>
            </a>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card p-4 h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #0f766e 0%, #115e59 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="p-3 bg-white bg-opacity-25 rounded-4 shadow-sm">
                            <i class="bi bi-collection-fill fs-3 text-white"></i>
                        </div>
                    </div>
                    <h6 class="text-white text-opacity-75 mb-1">Total Koleksi</h6>
                    <h2 class="fw-bold mb-0">{{ $books->total() }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4 h-100 border-0 shadow-sm">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="p-3 bg-primary bg-opacity-10 rounded-4 text-primary">
                            <i class="bi bi-cloud-download fs-3"></i>
                        </div>
                    </div>
                    <h6 class="text-muted mb-1">Total Unduhan</h6>
                    <h2 class="fw-bold mb-0 text-dark">{{ $books->sum('download_count') }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4 h-100 border-0 shadow-sm">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="p-3 bg-warning bg-opacity-10 rounded-4 text-warning">
                            <i class="bi bi-link-45deg fs-3"></i>
                        </div>
                    </div>
                    <h6 class="text-muted mb-1">Buku Tautan</h6>
                    <h2 class="fw-bold mb-0 text-dark">{{ $books->whereNotNull('external_link')->count() }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4 h-100 border-0 shadow-sm">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="p-3 bg-info bg-opacity-10 rounded-4 text-info">
                            <i class="bi bi-file-pdf fs-3"></i>
                        </div>
                    </div>
                    <h6 class="text-muted mb-1">Buku PDF</h6>
                    <h2 class="fw-bold mb-0 text-dark">{{ $books->whereNull('external_link')->count() }}</h2>
                </div>
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="table-responsive d-none d-lg-block fade-in-up" style="animation-delay: 0.1s;">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Cover</th>
                        <th width="25%">Judul & Penulis</th>
                        <th width="12%">Kategori</th>
                        <th width="8%" class="text-center">Tipe</th>
                        <th width="8%" class="text-center">Unduhan</th>
                        <th width="15%" class="text-center">Status</th>
                        <th width="20%" class="text-center">Aksi (Edit / Tampil)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $index => $book)
                        <tr>
                            <td>{{ $books->firstItem() + $index }}</td>
                            <td>
                                @if($book->cover_image)
                                    <img src="{{ asset('uploads/books/' . $book->cover_image) }}" alt="Cover" class="book-thumbnail">
                                @else
                                    <img src="{{ asset('images/buku.png') }}" alt="Default Cover" class="book-thumbnail" style="object-fit: contain; background: #f8fafc; padding: 2px;">
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-truncate" style="max-width: 250px;">{{ $book->title }}</div>
                                <div class="text-muted small"><i class="bi bi-pen"></i> {{ $book->author }}</div>
                            </td>
                             <td>
                                <span class="badge bg-light text-dark border">{{ $book->category_ref->name ?? 'Tanpa Kategori' }}</span>
                            </td>
                            <td class="text-center">
                                @if($book->external_link)
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2 py-1" style="font-size: 0.7rem;">
                                        <i class="bi bi-link-45deg"></i> Link
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2 py-1" style="font-size: 0.7rem;">
                                        <i class="bi bi-file-pdf"></i> PDF
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                                    <i class="bi bi-download me-1"></i> {{ $book->download_count }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($book->is_active)
                                    <span class="status-badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                        <i class="bi bi-eye-fill me-1"></i> Ditampilkan
                                    </span>
                                @else
                                    <span class="status-badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                                        <i class="bi bi-eye-slash-fill me-1"></i> Disembunyikan
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="tooltip" title="Edit Buku">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.books.toggle', $book->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm action-btn {{ $book->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}" data-bs-toggle="tooltip" title="{{ $book->is_active ? 'Sembunyikan Buku' : 'Tampilkan Buku' }}">
                                            <i class="bi {{ $book->is_active ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                                        </button>
                                    </form>
                                    
                                    <a href="{{ route('books.show', $book->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary action-btn" data-bs-toggle="tooltip" title="Lihat Halaman">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                <h5>Belum ada buku</h5>
                                <p>Silakan klik tombol "Tambah Buku Baru" untuk memulai.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="d-lg-none">
            @forelse($books as $index => $book)
                <div class="card mb-3 border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
                    <div class="card-body p-0">
                        <div class="d-flex p-3">
                            <div class="flex-shrink-0 me-3">
                                @if($book->cover_image)
                                    <img src="{{ asset('uploads/books/' . $book->cover_image) }}" alt="Cover" class="rounded-3 shadow-sm" style="width: 70px; height: 100px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/buku.png') }}" alt="Default Cover" class="rounded-3 shadow-sm" style="width: 70px; height: 100px; object-fit: contain; background: #f8fafc; padding: 5px;">
                                @endif
                            </div>
                            <div class="flex-grow-1 min-width-0">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 0.65rem;">{{ $book->category_ref->name ?? 'Tanpa Kategori' }}</span>
                                    @if($book->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success" style="font-size: 0.65rem;"><i class="bi bi-eye-fill"></i> Tampil</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 0.65rem;"><i class="bi bi-eye-slash-fill"></i> Sembunyi</span>
                                    @endif
                                </div>
                                <h6 class="fw-bold text-truncate mb-1" style="max-width: 180px;">{{ $book->title }}</h6>
                                <p class="text-muted small mb-2"><i class="bi bi-pen"></i> {{ $book->author }}</p>
                                <div class="d-flex gap-2 align-items-center">
                                    @if($book->external_link)
                                        <span class="badge bg-warning bg-opacity-10 text-warning" style="font-size: 0.65rem;">Link</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 0.65rem;">PDF</span>
                                    @endif
                                    <span class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-download"></i> {{ $book->download_count }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-light p-3 d-flex gap-2">
                            <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-primary flex-grow-1 rounded-pill py-2">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.books.toggle', $book->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $book->is_active ? 'btn-outline-danger' : 'btn-outline-success' }} w-100 rounded-pill py-2">
                                    <i class="bi {{ $book->is_active ? 'bi-eye-slash' : 'bi-eye' }} me-1"></i> {{ $book->is_active ? 'Sembunyi' : 'Tampil' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                    <h5>Belum ada buku</h5>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $books->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection
