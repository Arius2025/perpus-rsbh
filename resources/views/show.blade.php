@extends('layout')

@section('title', $book->title . ' - PustakaDigital')

@section('styles')
<style>
    .book-detail-card {
        background: var(--card-bg-light);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
    }

    body.dark-mode .book-detail-card {
        background: var(--card-bg-dark);
        border: 1px solid rgba(255,255,255,0.05);
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }

    .book-detail-cover {
        width: 100%;
        max-width: 350px;
        border-radius: 12px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        margin: 0 auto;
        display: block;
    }

    .book-meta-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px dashed rgba(0,0,0,0.1);
    }
    
    body.dark-mode .book-meta-grid {
        border-top: 1px dashed rgba(255,255,255,0.1);
    }

    .meta-item label {
        display: block;
        font-size: 0.85rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .meta-item span {
        font-weight: 500;
        font-size: 1.05rem;
    }

    .btn-download-large {
        padding: 1rem 2rem;
        font-size: 1.1rem;
        border-radius: 50px;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 10px 20px rgba(21, 115, 71, 0.3);
    }

    .btn-download-large:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px rgba(21, 115, 71, 0.4);
    }
    
    .description-text {
        line-height: 1.8;
        font-size: 1.05rem;
        color: #4a5568;
    }
    
    body.dark-mode .description-text {
        color: #e2e8f0;
    }

</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">
        
        <a href="{{ route('home') }}" class="btn btn-link text-decoration-none px-0 mb-4 text-muted fade-in-up">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>

        <div class="book-detail-card fade-in-up" style="animation-delay: 0.1s;">
            <div class="row g-0">
                
                <!-- Left Column: Cover & Download -->
                <div class="col-md-5 col-lg-4 p-4 p-md-5 text-center" style="background: rgba(21,115,71,0.03);">
                    @if($book->cover_image)
                        <img src="{{ asset('uploads/books/' . $book->cover_image) }}" alt="Cover" class="book-detail-cover mb-4">
                    @else
                        <img src="{{ asset('images/buku.png') }}" alt="Default Cover" class="book-detail-cover mb-4" style="object-fit: contain; background: #f8fafc; padding: 2rem;">
                    @endif
                    
                    @if($book->external_link)
                        <a href="{{ route('books.view', $book->id) }}" target="_blank" class="btn btn-primary btn-download-large mt-2">
                            <i class="bi bi-link-45deg fs-4 me-2 align-middle"></i> Buka Link Buku
                        </a>
                    @else
                        <div class="d-grid gap-2">
                            <a href="{{ route('books.view', $book->id) }}" target="_blank" class="btn btn-primary btn-download-large mt-2">
                                <i class="bi bi-eye-fill fs-4 me-2 align-middle"></i> Baca Sekarang
                            </a>
                            <a href="{{ route('books.download', $book->id) }}" class="btn btn-outline-primary mt-2">
                                <i class="bi bi-cloud-arrow-down-fill me-2"></i> Unduh PDF
                            </a>
                        </div>
                    @endif
                    
                    <p class="text-muted small mt-3 mb-0">
                        <i class="bi bi-info-circle"></i> Telah diunduh sebanyak {{ $book->download_count }} kali
                    </p>
                </div>

                <!-- Right Column: Details -->
                <div class="col-md-7 col-lg-8 p-4 p-md-5">
                    <span class="badge bg-primary rounded-pill mb-3 px-3 py-2 bg-opacity-10 text-primary">{{ $book->category_ref->name ?? 'Tanpa Kategori' }}</span>
                    
                    <h1 class="fw-bold mb-3" style="font-size: 2.5rem; letter-spacing: -1px;">{{ $book->title }}</h1>
                    
                    <div class="d-flex align-items-center mb-4 text-muted">
                        <i class="bi bi-pen fs-5 me-2"></i>
                        <span class="fs-5">{{ $book->author }}</span>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Sinopsis / Deskripsi</h5>
                        <p class="description-text">{{ $book->description }}</p>
                    </div>

                    <div class="book-meta-grid">
                        <div class="meta-item">
                            <label>Penerbit</label>
                            <span>{{ $book->publisher ?: 'Tidak diketahui' }}</span>
                        </div>
                        <div class="meta-item">
                            <label>Tahun / Tanggal Upload</label>
                            <span>{{ $book->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <label>Kategori</label>
                            <span>{{ $book->category_ref->name ?? 'Tanpa Kategori' }}</span>
                        </div>
                        <div class="meta-item">
                            <label>Status</label>
                            <span class="text-success"><i class="bi bi-check-circle-fill"></i> Tersedia</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
