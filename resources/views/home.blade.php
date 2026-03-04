@extends('layout')

@section('title', 'Beranda - PustakaDigital')

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #0f766e 0%, #134e4a 100%);
        border-radius: 30px;
        padding: 5rem 3rem;
        color: white;
        margin-bottom: 4rem;
        box-shadow: 0 25px 50px -12px rgba(15, 118, 110, 0.25);
        position: relative;
        overflow: hidden;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        width: 150%;
        height: 150%;
        top: -25%;
        left: -25%;
        background-image: radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                          radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        animation: rotate 60s linear infinite;
        z-index: 1;
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-badge {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 8px 16px;
        border-radius: 100px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        border: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 1.5rem;
        display: inline-block;
    }

    /* Search Bar Inline (Desktop) */
    .search-box {
        background: white;
        padding: 8px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        max-width: 600px;
        margin-top: 2rem;
    }

    .search-box input {
        border: none;
        box-shadow: none;
        background: transparent;
        color: #333;
    }
    
    .search-box input:focus {
        border: none;
        box-shadow: none;
    }

    body.dark-mode .search-box {
        background: var(--card-bg-dark);
        box-shadow: 0 10px 25px rgba(0,0,0,0.4);
    }
    
    body.dark-mode .search-box input {
        color: var(--text-color-dark);
    }
    
    body.dark-mode .search-box input::placeholder {
        color: #718096;
    }

    /* Book Cards */
    .book-card {
        background: var(--card-bg-light);
        border: 1px solid var(--card-border-light);
        border-radius: 20px;
        transition: var(--transition-smooth);
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        position: relative;
    }
    
    body.dark-mode .book-card {
        background: var(--card-bg-dark);
        border: 1px solid var(--card-border-dark);
    }

    .book-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    .book-cover-wrapper {
        position: relative;
        padding-top: 140%; /* 5:7 aspect ratio */
        overflow: hidden;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    body.dark-mode .book-cover-wrapper {
        background: #334155;
    }

    .book-cover {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .book-card:hover .book-cover {
        transform: scale(1.05);
    }

    .no-cover-svg {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #94a3b8;
        text-align: center;
        width: 100%;
    }

    .book-info {
        padding: 1.25rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    @media (max-width: 575.98px) {
        .book-info {
            padding: 0.75rem;
        }
    }

    .book-title {
        font-weight: 700;
        font-size: 1rem;
        color: var(--text-color-light);
        margin-bottom: 0.5rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    @media (max-width: 575.98px) {
        .book-title {
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }
    }
    
    body.dark-mode .book-title {
        color: var(--text-color-dark);
    }

    .book-author {
        color: #64748b;
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }
    
    @media (max-width: 575.98px) {
        .book-author {
            font-size: 0.75rem;
            margin-bottom: 0.5rem;
        }
    }
    
    body.dark-mode .book-author {
        color: #94a3b8;
    }

    .category-badge {
        background-color: var(--bs-primary-light);
        color: var(--bs-primary);
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    
    body.dark-mode .category-badge {
        background-color: rgba(15, 118, 110, 0.2);
        color: #2dd4bf;
    }

    /* Category Filter */
    .filter-container {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 2rem;
    }
    
    .btn-filter {
        border-radius: 100px;
        white-space: nowrap;
        font-weight: 600;
        padding: 10px 24px;
        border: 1px solid rgba(15, 118, 110, 0.15);
        background: white;
        color: #0f766e;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.9rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    
    body.dark-mode .btn-filter {
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.05);
        color: #e2e8f0;
    }

    .btn-filter:hover {
        background: #0f766e;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(15, 118, 110, 0.3);
        border-color: #0f766e;
    }

    .btn-filter.active {
        background: #0f766e;
        color: white;
        border-color: #0f766e;
        box-shadow: 0 10px 15px -3px rgba(15, 118, 110, 0.4);
    }
    
    body.dark-mode .btn-filter.active {
        background: #2dd4bf;
        color: #042f2e;
        border-color: #2dd4bf;
    }
    
    /* Empty State */
    .empty-state {
        padding: 4rem 0;
        text-align: center;
        color: #6c757d;
    }
    
    body.dark-mode .empty-state {
        color: #cbd5e1;
    }

    .search-alert {
        background: rgba(15,118,110,0.05); 
        border-radius: 12px; 
        border: 1px dashed var(--bs-primary);
    }

    body.dark-mode .search-alert {
        background: rgba(255,255,255,0.05);
        border: 1px dashed #2dd4bf;
        color: #e2e8f0;
    }

    .hero-img-wrapper {
        position: relative;
        display: inline-block;
    }

    .hero-logo-glow {
        filter: drop-shadow(0 0 30px rgba(255,255,255,0.2));
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.8) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
    }

    body.dark-mode .glass-effect {
        background: rgba(30, 41, 59, 0.8) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

</style>
@endsection

@section('content')

<!-- Hero Section -->
<div class="hero-section text-center text-lg-start fade-in-up">
    <div class="row align-items-center hero-content">
        <div class="col-lg-7">
            <span class="hero-badge">Digital Library Ecosystem</span>
            <h1 class="display-4 fw-bold mb-3 lh-sm">Eksplorasi Literasi Tanpa Batas</h1>
            <p class="lead mb-5 opacity-75 fw-normal">Temukan ribuan karya tulis dan literatur berkualitas dalam genggaman Anda. Wadah inklusif untuk memperluas cakrawala pengetahuan.</p>
            
            <!-- Desktop Search (Hidden on Mobile) -->
            <form action="{{ route('home') }}" method="GET" class="search-box glass-effect d-none d-lg-flex mx-auto mx-lg-0 p-2">
                <i class="bi bi-search text-muted ms-3 me-2 fs-5"></i>
                <input type="text" name="search" class="form-control form-control-lg border-0 shadow-none" placeholder="Cari judul buku atau penulis..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary rounded-pill px-5 py-3">Cari Koleksi</button>
            </form>
        </div>
        <div class="col-lg-5 d-none d-lg-block text-center">
            <div class="hero-img-wrapper">
                <img src="{{ asset('images/logo.png') }}" alt="Rumkit Baladhika Husada" class="img-fluid hero-logo-glow" style="max-height: 320px;">
            </div>
        </div>
    </div>
</div>

<!-- Main Content Area -->
<div class="container pb-5 fade-in-up" style="animation-delay: 0.2s;">
    
    <div class="d-flex justify-content-between align-items-end mb-4">
        <h3 class="fw-bold mb-0">Rekomendasi Buku</h3>
    </div>

    <!-- Category Filter -->
    <div class="filter-container mb-4">
        <a href="{{ route('home', array_merge(request()->query(), ['category' => 'All'])) }}" class="btn btn-filter {{ request('category', 'All') == 'All' ? 'active' : '' }}">Semua Koleksi</a>
        @foreach($categories as $category)
            <a href="{{ route('home', array_merge(request()->query(), ['category' => $category->name])) }}" class="btn btn-filter {{ request('category') == $category->name ? 'active' : '' }} text-capitalize">{{ $category->name }}</a>
        @endforeach
    </div>

    @if(request('search'))
        <div class="mb-4 d-flex justify-content-between align-items-center w-100 p-3 search-alert">
            <span>Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong></span>
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-danger" style="border-radius:20px;">X Hapus Pencarian</a>
        </div>
    @endif

    @if($books->count() > 0)
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
            @foreach($books as $book)
                <div class="col fade-in-up" style="animation-delay: {{ 0.1 * $loop->iteration }}s;">
                    <a href="{{ route('books.show', $book->id) }}" class="book-card text-decoration-none">
                        <div class="book-cover-wrapper">
                            @if($book->cover_image)
                                <img src="{{ asset('uploads/books/' . $book->cover_image) }}" class="book-cover" alt="Cover {{ $book->title }}">
                            @else
                                <img src="{{ asset('images/buku.png') }}" class="book-cover" alt="Default Cover" style="object-fit: contain; padding: 1.5rem; background: #f8fafc;">
                            @endif
                        </div>
                        
                        <div class="book-info">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="category-badge">{{ $book->category_ref->name ?? 'Tanpa Kategori' }}</span>
                                <span class="text-muted small"><i class="bi bi-cloud-arrow-down me-1"></i> {{ $book->download_count }}</span>
                            </div>
                            <h5 class="book-title">{{ $book->title }}</h5>
                            <p class="book-author mb-3"><i class="bi bi-pen me-1"></i> {{ $book->author }}</p>
                            
                            <div class="mt-auto">
                                <span class="btn btn-sm btn-outline-primary w-100 rounded-pill fs-7 py-2">
                                    <i class="bi {{ $book->external_link ? 'bi-link-45deg' : 'bi-eye' }} me-1"></i> 
                                    {{ $book->external_link ? 'Buka Link' : 'Baca Sekarang' }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $books->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="empty-state">
            <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
            <h5>Buku tidak ditemukan</h5>
            <p>Maaf, tidak ada buku yang sesuai dengan pencarian atau saat ini perpustakaan sedang kosong.</p>
            @if(request('search'))
                <a href="{{ route('home') }}" class="btn btn-primary mt-3">Kembali ke Beranda</a>
            @endif
        </div>
    @endif

</div>
@endsection
