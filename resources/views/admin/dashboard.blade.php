@extends('layout')

@section('title', 'Dashboard Admin - PustakaDigital RS Baladhika Husada')

@section('styles')
<style>
    .dashboard-heading {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--line);
        flex-wrap: wrap;
    }
    .dashboard-heading h1 {
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -0.5px;
        color: var(--text);
        margin-bottom: 6px;
    }
    .dashboard-heading p {
        color: var(--muted);
        font-size: 14px;
        margin: 0;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 32px;
    }
    .stat-box {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .stat-box.primary-stat {
        border-color: var(--accent);
        background: var(--soft);
    }
    .stat-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--muted);
    }
    .stat-box.primary-stat .stat-label {
        color: var(--accent);
    }
    .stat-number {
        font-size: 28px;
        font-weight: 800;
        color: var(--text);
        line-height: 1.2;
    }
    .admin-table-card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        overflow: hidden;
        margin-bottom: 32px;
    }
    .table {
        margin: 0;
        color: var(--text);
        background: var(--surface);
    }
    .table th {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--muted);
        border-bottom: 1px solid var(--line);
        background: var(--surface);
        padding: 14px 16px;
    }
    .table td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--line);
        vertical-align: middle;
        background: var(--surface);
        color: var(--text);
    }
    .book-thumbnail {
        width: 48px;
        height: 64px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid var(--line);
    }
    .action-btn {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid var(--line);
        background: var(--surface);
        color: var(--text);
        text-decoration: none;
    }
    .action-btn:hover {
        border-color: var(--accent);
        color: var(--accent);
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }
    @media (max-width: 992px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="wrap admin-wrap py-4">
    <div class="dashboard-heading">
        <div>
            <h1>Manajemen Koleksi Buku</h1>
            <p>Kelola dan pantau seluruh literatur dan referensi kesehatan digital.</p>
        </div>
        <a href="{{ route('admin.books.create') }}" class="primary" style="min-height: 44px; padding: 10px 20px;">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Buku Baru</span>
        </a>
    </div>

    <div class="stats-grid">
        <div class="stat-box primary-stat">
            <span class="stat-label">Total Koleksi</span>
            <span class="stat-number">{{ $books->total() }}</span>
        </div>
        <div class="stat-box">
            <span class="stat-label">Total Akses / Unduhan</span>
            <span class="stat-number">{{ $books->sum('download_count') }}</span>
        </div>
        <div class="stat-box">
            <span class="stat-label">Dokumen PDF</span>
            <span class="stat-number">{{ $books->whereNull('external_link')->count() }}</span>
        </div>
        <div class="stat-box">
            <span class="stat-label">Tautan Eksternal</span>
            <span class="stat-number">{{ $books->whereNotNull('external_link')->count() }}</span>
        </div>
    </div>

    <!-- Desktop Table View -->
    <div class="table-responsive d-none d-lg-block fade-in-up admin-table-card" style="animation-delay: 0.1s;">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="8%">Cover</th>
                    <th width="24%">Judul & Penulis</th>
                    <th width="12%">Kategori</th>
                    <th width="14%">Pengunggah</th>
                    <th width="8%" class="text-center">Format</th>
                    <th width="8%" class="text-center">Unduhan</th>
                    <th width="10%" class="text-center">Status</th>
                    <th width="12%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $index => $book)
                    <tr>
                        <td>{{ $books->firstItem() + $index }}</td>
                        <td>
                            <img src="{{ $book->cover_url }}" alt="Cover" class="book-thumbnail" style="{{ $book->has_custom_cover ? '' : 'object-fit: contain; background: var(--soft); padding: 2px;' }}">
                        </td>
                        <td>
                            <div class="fw-bold text-truncate" style="max-width: 240px;" title="{{ $book->title }}">{{ $book->title }}</div>
                            <div class="text-muted small"><i class="bi bi-pen"></i> {{ $book->author }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $book->category_ref->name ?? 'Tanpa Kategori' }}</span>
                        </td>
                        <td>
                            <div class="small fw-semibold text-truncate" style="max-width: 140px;">
                                {{ $book->uploader->name ?? 'Admin Perpustakaan' }}
                            </div>
                            @if($book->uploader && $book->uploader->isAdminUtama())
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" style="font-size: 9px;">Admin Utama</span>
                            @else
                                <span class="text-muted" style="font-size: 11px;">Petugas</span>
                            @endif
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
                            <span class="badge bg-info bg-opacity-10 text-info px-2 py-1 rounded-pill" style="font-size: 0.75rem;">
                                <i class="bi bi-download me-1"></i> {{ $book->download_count }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($book->is_active)
                                <span class="status-badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                    <i class="bi bi-eye-fill me-1"></i> Aktif
                                </span>
                            @else
                                <span class="status-badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                                    <i class="bi bi-eye-slash-fill me-1"></i> Sembunyi
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                @if(auth()->user()->canManageBook($book))
                                    <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="tooltip" title="Edit Buku">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.books.toggle', $book->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm action-btn {{ $book->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}" data-bs-toggle="tooltip" title="{{ $book->is_active ? 'Sembunyikan Buku' : 'Tampilkan Buku' }}">
                                            <i class="bi {{ $book->is_active ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku \'{{ addslashes($book->title) }}\' secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger action-btn" data-bs-toggle="tooltip" title="Hapus Buku">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="d-inline-block" data-bs-toggle="tooltip" title="Hanya pengunggah ({{ $book->uploader->name ?? 'Admin' }}) atau Admin Utama yang dapat mengedit/menghapus buku ini.">
                                        <button class="btn btn-sm action-btn text-muted" style="opacity: 0.5; cursor: not-allowed;" disabled>
                                            <i class="bi bi-lock-fill"></i>
                                        </button>
                                    </span>
                                @endif
                                
                                <a href="{{ route('books.show', $book->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary action-btn" data-bs-toggle="tooltip" title="Buka Detail">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
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
            <div class="card mb-3 border-0 shadow-sm overflow-hidden" style="border-radius: 16px; background: var(--surface); border: 1px solid var(--line) !important;">
                <div class="card-body p-0">
                    <div class="d-flex p-3">
                        <div class="flex-shrink-0 me-3">
                            <img src="{{ $book->cover_url }}" alt="Cover" class="rounded-3 border" style="width: 72px; height: 100px; {{ $book->has_custom_cover ? 'object-fit: cover;' : 'object-fit: contain; background: var(--soft); padding: 4px;' }}">
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <div class="d-flex justify-content-between align-items-start mb-1 gap-2">
                                <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 0.65rem;">{{ $book->category_ref->name ?? 'Tanpa Kategori' }}</span>
                                @if($book->is_active)
                                    <span class="badge bg-success bg-opacity-10 text-success" style="font-size: 0.65rem;"><i class="bi bi-eye-fill"></i> Tampil</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 0.65rem;"><i class="bi bi-eye-slash-fill"></i> Sembunyi</span>
                                @endif
                            </div>
                            <h6 class="fw-bold text-truncate mb-1" style="max-width: 180px;">{{ $book->title }}</h6>
                            <p class="text-muted small mb-1"><i class="bi bi-pen"></i> {{ $book->author }}</p>
                            <div class="text-muted small mb-2" style="font-size: 0.72rem;">
                                <i class="bi bi-person"></i> {{ $book->uploader->name ?? 'Admin' }}
                            </div>
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
                    <div class="bg-light p-3 d-flex gap-2 flex-wrap border-top" style="border-color: var(--line) !important;">
                        @if(auth()->user()->canManageBook($book))
                            <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-primary flex-grow-1 rounded-pill py-2" style="min-height: 44px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.books.toggle', $book->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $book->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} w-100 rounded-pill py-2" style="min-height: 44px;">
                                    <i class="bi {{ $book->is_active ? 'bi-eye-slash' : 'bi-eye' }} me-1"></i> {{ $book->is_active ? 'Sembunyi' : 'Tampil' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill py-2" style="min-height: 44px;">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </form>
                        @else
                            <div class="w-100 text-center py-1">
                                <span class="badge bg-secondary bg-opacity-10 text-muted border px-3 py-2 w-100" style="font-size: 0.75rem;">
                                    <i class="bi bi-lock-fill me-1"></i> Dikelola oleh {{ $book->uploader->name ?? 'Admin Perpustakaan' }}
                                </span>
                            </div>
                        @endif
                        <a href="{{ route('books.show', $book->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary w-100 rounded-pill py-2 mt-1" style="min-height: 44px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Halaman Buku
                        </a>
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
