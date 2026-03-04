@extends('layout')

@section('title', 'Beranda - PustakaDigital')

@section('styles')
<style>
    /* Premium Design System */
    :root {
        --primary-teal: #0f766e;
        --primary-emerald: #10b981;
        --primary-light: #f0fdfa;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --hero-text: #020617; /* High contrast black */
        --card-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
        --glass-bg: rgba(255, 255, 255, 0.9);
        --glass-border: rgba(255, 255, 255, 0.4);
    }

    body.dark-mode {
        --text-main: #f1f5f9;
        --text-muted: #94a3b8;
        --hero-text: #f8fafc; /* Keep light in dark mode for standard accessibility */
        --card-shadow: 0 10px 30px rgba(0,0,0,0.3);
        --glass-bg: rgba(15, 23, 42, 0.75);
        --glass-border: rgba(255, 255, 255, 0.1);
    }

    /* Floating Card Hero */
    .hero-container {
        display: flex;
        justify-content: center;
        width: 100%;
        margin-bottom: 3.5rem;
    }

    .hero-section {
        max-width: 1050px;
        width: 100%;
        /* Light premium background to support black text */
        background: linear-gradient(135deg, #f0fdfa 0%, #e2e8f0 100%);
        background-image: 
            radial-gradient(at 0% 0%, rgba(20, 184, 166, 0.15) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.1) 0px, transparent 50%);
        border-radius: 32px;
        padding: 3rem 3.5rem;
        color: var(--hero-text);
        position: relative;
        overflow: hidden;
        box-shadow: 0 30px 60px -15px rgba(15, 118, 110, 0.15);
        border: 1px solid rgba(15, 118, 110, 0.1);
    }

    body.dark-mode .hero-section {
        background: linear-gradient(135deg, #042f2e 0%, #064e3b 100%);
        background-image: 
            radial-gradient(at 0% 0%, rgba(20, 184, 166, 0.2) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.1) 0px, transparent 50%);
        box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.5);
        border-color: rgba(255, 255, 255, 0.05);
        color: white; /* Switch back to white in dark mode for proper UX */
    }

    /* If user strictly wanted black text even in dark mode, we would need a light card in dark mode. 
       But usually, "tulisan terang jadi hitam" implies the light mode state. 
       I will use dark charcoal for better visibility in light mode. */

    @media (max-width: 991.98px) {
        .hero-section { padding: 2.5rem 2rem; border-radius: 24px; }
    }

    .hero-content { position: relative; z-index: 5; }

    .hero-badge {
        background: rgba(15, 118, 110, 0.05);
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        border: 1px solid rgba(15, 118, 110, 0.2);
        margin-bottom: 1.25rem;
        display: inline-block;
        color: var(--primary-teal);
    }

    body.dark-mode .hero-badge {
        background: rgba(255, 255, 255, 0.1);
        color: #ccfbf1;
        border-color: rgba(255, 255, 255, 0.15);
    }

    .hero-title {
        font-size: 2.75rem;
        font-weight: 900;
        line-height: 1.15;
        margin-bottom: 1.5rem;
        color: var(--hero-text);
        letter-spacing: -1.5px;
    }

    @media (max-width: 991.98px) {
        .hero-title { font-size: 2.25rem; }
    }

    /* Modern Category Pill Filters */
    .filter-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 2.5rem;
    }

    .btn-filter {
        border: none;
        background: #f1f5f9;
        color: var(--text-muted);
        padding: 0.6rem 1.75rem;
        border-radius: 100px;
        font-size: 0.85rem;
        font-weight: 700;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-block;
    }

    body.dark-mode .btn-filter {
        background: rgba(255, 255, 255, 0.05);
        color: #94a3b8;
    }

    .btn-filter:hover {
        background: #e2e8f0;
        color: var(--primary-teal);
        transform: translateY(-2px);
    }

    body.dark-mode .btn-filter:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #2dd4bf;
    }

    .btn-filter.active {
        background: var(--primary-teal);
        color: #ffffff !important;
        box-shadow: 0 10px 20px -5px rgba(15, 118, 110, 0.4);
    }

    body.dark-mode .btn-filter.active {
        background: #2dd4bf;
        color: #042f2e !important;
        box-shadow: 0 10px 20px -5px rgba(45, 212, 191, 0.3);
    }

    /* Premium Search Bar */
    .search-box-premium {
        background: #ffffff;
        padding: 6px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        max-width: 580px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    body.dark-mode .search-box-premium {
        background: var(--glass-bg);
        border-color: var(--glass-border);
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }

    .search-box-premium:focus-within {
        border-color: var(--primary-teal);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .search-box-premium input {
        border: none;
        background: transparent;
        color: var(--text-main);
        font-size: 0.95rem;
        font-weight: 500;
        padding: 10px 15px;
        width: 100%;
        outline: none;
    }

    .search-btn-premium {
        background: var(--primary-teal);
        color: #ffffff;
        border: none;
        padding: 10px 24px;
        border-radius: 14px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    body.dark-mode .search-btn-premium {
        background: #2dd4bf;
        color: #042f2e;
    }

    /* Popular Tags - Hero Section */
    .hero-tags {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .tag-label-hero {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--hero-text);
        opacity: 0.7;
    }

    .tag-premium {
        background: rgba(15, 118, 110, 0.05);
        color: var(--hero-text);
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 5px 14px;
        border-radius: 100px;
        border: 1px solid rgba(15, 118, 110, 0.15);
        transition: all 0.3s ease;
    }

    body.dark-mode .tag-premium {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-color: rgba(255, 255, 255, 0.1);
    }

    .tag-premium:hover {
        background: var(--primary-teal);
        color: white;
        transform: translateY(-2px);
    }

    /* Book Cards */
    .book-card {
        border-radius: 20px;
        background: #ffffff;
        border: 1px solid #f1f5f9;
        transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: var(--card-shadow);
    }

    body.dark-mode .book-card {
        background: #1e293b;
        border-color: rgba(255, 255, 255, 0.05);
    }

    .book-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px -15px rgba(0,0,0,0.15);
        border-color: var(--primary-teal);
    }

    body.dark-mode .book-card:hover {
        box-shadow: 0 30px 60px -15px rgba(0,0,0,0.5);
        border-color: #2dd4bf;
    }

    .book-cover-wrapper {
        padding-top: 140%;
        position: relative;
        overflow: hidden;
        background: #f8fafc;
    }

    body.dark-mode .book-cover-wrapper { background: #0f172a; }

    .book-cover {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .book-card:hover .book-cover { transform: scale(1.1); }

    .book-info { padding: 1.25rem; flex-grow: 1; display: flex; flex-direction: column; }

    .book-title {
        font-weight: 800;
        font-size: 1rem;
        margin-bottom: 0.4rem;
        color: var(--text-main);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .book-author {
        color: var(--text-muted);
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 1.25rem;
    }

    .category-badge {
        background: rgba(15, 118, 110, 0.08);
        color: var(--primary-teal);
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 800;
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    body.dark-mode .category-badge {
        background: rgba(45, 212, 191, 0.1);
        color: #2dd4bf;
    }

    /* Premium Empty State */
    .empty-state-card {
        max-width: 580px;
        margin: 2rem auto;
        padding: 4rem 3rem;
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 32px;
        box-shadow: var(--card-shadow);
        text-align: center;
    }

    body.dark-mode .empty-state-card {
        background: #1e293b;
        border-color: rgba(255, 255, 255, 0.05);
    }

    .empty-state-icon { font-size: 4.5rem; color: var(--primary-teal); opacity: 0.8; margin-bottom: 2rem; }
    body.dark-mode .empty-state-icon { color: #2dd4bf; }

    .empty-state-title { font-weight: 800; font-size: 1.75rem; color: var(--text-main); margin-bottom: 1rem; }
    .empty-state-text { color: var(--text-muted); font-size: 1rem; line-height: 1.6; margin-bottom: 2.5rem; }

    /* Animations */
    .reveal-item {
        opacity: 0;
        transform: translateY(20px);
        animation: reveal 0.6s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
    }

    @keyframes reveal { to { opacity: 1; transform: translateY(0); } }

    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }

    .hero-logo-main {
        max-height: 260px;
        filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1));
        animation: float-logo 6s ease-in-out infinite;
    }

    @keyframes float-logo { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }

</style>
@endsection

@section('content')

<!-- Hero Section - Premium Floating Card -->
<div class="hero-container">
    <div class="hero-section reveal-item">
        <div class="row align-items-center hero-content">
            <div class="col-lg-7 text-center text-lg-start">
                <span class="hero-badge reveal-item delay-1">Digital Library</span>
                <h1 class="hero-title reveal-item delay-2">Eksplorasi Literasi<br>Tanpa Batas</h1>
                
                <!-- Premium Search -->
                <form action="{{ route('home') }}" method="GET" class="search-box-premium reveal-item delay-3 mx-auto mx-lg-0">
                    <i class="bi bi-search text-muted ms-3"></i>
                    <input type="text" name="search" placeholder="Cari judul buku, penulis, atau topik..." value="{{ request('search') }}">
                    <button type="submit" class="search-btn-premium d-none d-sm-block">Cari Koleksi</button>
                    <button type="submit" class="btn btn-primary d-sm-none rounded-pill px-3"><i class="bi bi-search"></i></button>
                </form>

                <!-- Premium Tags -->
                <div class="hero-tags reveal-item delay-4">
                    <span class="tag-label-hero me-2">Populer:</span>
                    @foreach($categories->take(3) as $cat)
                        <a href="{{ route('home', ['category' => $cat->name]) }}" class="tag-premium">{{ $cat->name }}</a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-end">
                <div class="hero-logo-container reveal-item delay-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="hero-logo-main">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Area -->
<div class="container pb-5 reveal-item" style="animation-delay: 0.5s;">
    
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
        <div class="mb-5 d-flex justify-content-between align-items-center w-100 p-4 search-alert shadow-sm reveal-item">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                    <i class="bi bi-search text-primary"></i>
                </div>
                <span>Hasil pencarian untuk: <strong class="text-primary">"{{ request('search') }}"</strong></span>
            </div>
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-danger px-3 rounded-pill">Hapus Pencarian</a>
        </div>
    @endif

    @if($books->count() > 0)
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
            @foreach($books as $book)
                <div class="col reveal-item" style="animation-delay: {{ 0.2 + (0.05 * $loop->index) }}s;">
                    <a href="{{ route('books.show', $book->id) }}" class="book-card text-decoration-none">
                        <div class="book-cover-wrapper">
                            @if($book->cover_image)
                                <img src="{{ asset('uploads/books/' . $book->cover_image) }}" class="book-cover" alt="Cover {{ $book->title }}">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                                    <i class="bi bi-book text-muted opacity-25" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="book-info">
                            <div class="mb-2">
                                <span class="category-badge">{{ $book->category_ref->name ?? 'Koleksi' }}</span>
                            </div>
                            <h5 class="book-title">{{ $book->title }}</h5>
                            <p class="book-author"><i class="bi bi-person me-1"></i> {{ $book->author }}</p>
                            
                            <div class="mt-auto pt-3 border-top border-light d-flex justify-content-between align-items-center" style="border-color: rgba(0,0,0,0.05) !important;">
                                <span class="text-primary small fw-bold">Detail</span>
                                <span class="text-muted small"><i class="bi bi-download me-1"></i> {{ $book->download_count }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $books->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @else
        <!-- Premium Empty State -->
        <div class="empty-state-container reveal-item">
            <div class="empty-state-card">
                <div class="empty-state-icon-wrapper">
                    <div class="empty-state-glow"></div>
                    <i class="bi bi-journal-x empty-state-icon"></i>
                </div>
                <h2 class="empty-state-title">Koleksi Belum Tersedia</h2>
                <p class="empty-state-text">
                    Maaf, kami tidak dapat menemukan buku yang Anda cari.<br>
                    Coba gunakan kata kunci lain atau telusuri kategori yang tersedia untuk menemukan literatur menarik lainnya.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow">Segarkan Halaman</a>
                    @if(request('search'))
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill">Reset Pencarian</a>
                    @endif
                </div>
            </div>
        </div>
    @endif

</div>

</div>
@endsection
