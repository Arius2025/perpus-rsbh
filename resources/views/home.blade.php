@extends('layout')

@section('title', 'PustakaDigital · Baladhika Husada')

@section('styles')
<style>
.intro {
  padding: 56px 0 48px;
  display: grid;
  grid-template-columns: 1.35fr 1fr;
  gap: 64px;
  align-items: center;
}
.eyebrow {
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--accent);
  margin-bottom: 16px;
}
.intro h1 {
  font-size: var(--display);
  letter-spacing: -2px;
  font-weight: 800;
  max-width: 650px;
  color: var(--text);
}
.intro h1 em {
  font-style: normal;
  color: var(--accent);
}
.intro p {
  color: var(--muted);
  max-width: 520px;
  margin-top: 24px;
  font-size: 16px;
}
.intro-side {
  border-left: 1px solid var(--line);
  padding-left: 32px;
  max-width: 360px;
  justify-self: end;
}
.intro-side p {
  margin: 0;
  font-size: 16px;
  color: var(--text);
}
.intro-side .od-row {
  margin-top: 24px;
  font-size: 12px;
  font-weight: 600;
  color: var(--accent);
  gap: 12px;
}

/* Search Panel */
.search-panel {
  background: var(--hero);
  border-radius: var(--radius);
  padding: 32px 40px;
  color: var(--hero-text);
  margin-bottom: 8px;
}
.search-panel label {
  display: block;
  font-weight: 600;
  margin-bottom: 12px;
  font-size: 20px;
  color: var(--hero-text);
}
.search-box {
  display: flex;
  gap: 8px;
  background: #ffffff;
  border-radius: 8px;
  padding: 8px;
  align-items: center;
  color: #172c32;
}
.search-box svg {
  margin-left: 16px;
  color: #52636b;
}
.search-box input {
  display: block;
  flex: 1;
  min-width: 0;
  border: 0;
  padding: 12px;
  background: #ffffff;
  color: #172c32;
  font-size: 15px;
  outline: none;
}
.search-box input:focus {
  outline: none;
}
.suggestions {
  display: flex;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
  margin-top: 16px;
  color: #c7e1db;
  font-size: 12px;
}
.suggestion-btn {
  color: #ffffff;
  padding: 4px 0;
  text-decoration: underline;
  text-underline-offset: 4px;
  font-size: 12px;
  min-height: 32px;
  display: inline-flex;
  align-items: center;
  transition: opacity var(--motion) ease;
}
.suggestion-btn:hover {
  color: #ffffff;
  opacity: 0.85;
}

/* Catalog */
.catalog {
  padding: 48px 0 64px;
}
.section-heading {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  gap: 24px;
  margin-bottom: 24px;
}
.section-heading h2 {
  font-size: var(--h2);
  letter-spacing: -1px;
  font-weight: 700;
  color: var(--text);
}
.section-heading p {
  color: var(--muted);
  margin-top: 8px;
  font-size: 14px;
}
.catalog-layout {
  display: grid;
  grid-template-columns: 208px minmax(0, 1fr);
  gap: 40px;
}
.filters {
  border-top: 1px solid var(--line);
  padding-top: 24px;
}
.filters h3 {
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 16px;
  color: var(--muted);
  font-weight: 700;
}
.mobile-category {
  display: none;
}
.category-list {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.cat-btn {
  display: flex;
  text-align: left;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
  min-height: 44px;
  border-radius: 6px;
  padding: 8px 12px;
  font-size: 14px;
  color: var(--text);
  text-decoration: none;
  background: transparent;
  transition: background-color var(--motion) ease, color var(--motion) ease;
}
.cat-btn:hover {
  background: var(--soft);
  color: var(--accent);
}
.cat-btn.selected {
  background: var(--soft);
  color: var(--accent);
  font-weight: 700;
}
.cat-btn small {
  font-size: 12px;
  color: var(--muted);
}
.cat-btn.selected small {
  color: var(--accent);
  font-weight: 700;
}
.aside-note {
  margin-top: 32px;
  border-top: 1px solid var(--line);
  padding-top: 24px;
  font-size: 12px;
  color: var(--muted);
}
.aside-note svg {
  margin-bottom: 8px;
  color: var(--accent);
}

/* Results Top Bar */
.results-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 16px 0;
  border-top: 1px solid var(--line);
  margin-bottom: 16px;
  font-size: 12px;
  color: var(--muted);
}
.results-top select {
  background: var(--surface);
  color: var(--text);
  border: 1px solid var(--line);
  border-radius: 6px;
  padding: 8px 12px;
  min-height: 44px;
  font-size: 12px;
  font-weight: 500;
}
.results-top label {
  display: flex;
  align-items: center;
  gap: 8px;
}

/* Books Grid */
.books {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 24px;
}
.book {
  background: var(--surface);
  border: 1px solid var(--line);
  border-radius: 8px;
  text-decoration: none;
  color: var(--text);
  display: flex;
  flex-direction: column;
  min-width: 0;
  overflow: hidden;
  transition: border-color var(--motion) ease;
}
.book:hover {
  border-color: var(--accent);
  color: var(--text);
}
.book:hover .book-foot span {
  text-decoration: underline;
}

.cover-frame {
  display: grid;
  align-items: center;
  background: var(--soft);
  border-radius: 7px 7px 0 0;
  overflow: hidden;
  position: relative;
}
.default-cover {
  display: block;
  width: 100%;
  height: auto;
  aspect-ratio: 360/240;
  object-fit: contain;
}
.book-cover-img {
  display: block;
  width: 100%;
  height: 200px;
  aspect-ratio: 360/240;
  object-fit: cover;
}
.book-body {
  display: flex;
  flex-direction: column;
  flex: 1;
  padding: 20px;
  gap: 12px;
}
.tag {
  font-size: 11px;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  color: var(--accent);
  font-weight: 600;
}
.book h3 {
  font-size: 16px;
  line-height: 1.6;
  font-weight: 700;
  color: var(--text);
  margin: 0;
}
.author {
  font-size: 12px;
  color: var(--muted);
  margin-top: auto;
}
.book-foot {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
  border-top: 1px solid var(--line);
  padding-top: 12px;
  margin-top: 4px;
  font-size: 12px;
  color: var(--accent);
  font-weight: 600;
}
.book-foot svg {
  width: 16px;
  height: 16px;
}

/* Empty State */
.empty {
  padding: 64px 24px;
  text-align: center;
  border: 1px dashed var(--line);
  border-radius: 8px;
  grid-column: 1 / -1;
  background: var(--surface);
}
.empty h3 {
  font-size: 20px;
  font-weight: 700;
  color: var(--text);
  margin-bottom: 8px;
}
.empty p {
  margin: 8px 0 24px;
  color: var(--muted);
  font-size: 14px;
}

/* Pagination Styling */
.catalog-pagination {
  margin-top: 40px;
  display: flex;
  justify-content: center;
}
.catalog-pagination .pagination {
  gap: 4px;
  margin: 0;
}
.catalog-pagination .page-link {
  color: var(--text);
  background: var(--surface);
  border: 1px solid var(--line);
  border-radius: 6px !important;
  min-width: 40px;
  min-height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  font-weight: 600;
}
.catalog-pagination .page-item.active .page-link {
  background: var(--accent);
  border-color: var(--accent);
  color: #ffffff;
}
.catalog-pagination .page-link:hover {
  background: var(--soft);
  color: var(--accent);
  border-color: var(--accent);
}

/* Responsive Rules */
@media (max-width: 1024px) {
  .intro { gap: 32px; }
  .catalog-layout { grid-template-columns: 168px 1fr; gap: 24px; }
  .books { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}

@media (max-width: 768px) {
  .intro {
    grid-template-columns: 1fr;
    padding: 24px 0 20px;
    gap: 20px;
  }
  .intro-side { display: none; }
  .eyebrow { font-size: 11px; margin-bottom: 8px; }
  .intro h1 { font-size: 28px; letter-spacing: -1px; line-height: 1.25; }
  .intro p { font-size: 15px; margin-top: 12px; line-height: 1.5; }

  .search-panel { padding: 16px; }
  .search-panel label { font-size: 16px; margin-bottom: 8px; }
  .search-box { flex-wrap: nowrap; padding: 4px; gap: 4px; }
  .search-box svg { width: 20px; margin-left: 8px; }
  .search-box input { font-size: 16px; padding: 10px 4px; }
  .search-box .primary { min-height: 44px; padding: 10px 16px; font-size: 14px; }
  .suggestions { gap: 8px; margin-top: 8px; }
  .suggestions > span { display: none; }
  .suggestion-btn { font-size: 12px; min-height: 44px; padding: 8px; }

  .catalog { padding: 24px 0 32px; }
  .section-heading { margin-bottom: 12px; }
  .section-heading h2 { font-size: 24px; }
  .section-heading p { display: none; }

  .filters { border: 0; padding: 0; }
  .category-list, .aside-note { display: none; }
  .mobile-category { display: grid; gap: 8px; font-size: 14px; margin-bottom: 16px; }
  .mobile-category select {
    display: block;
    width: 100%;
    min-height: 44px;
    padding: 8px 12px;
    border: 1px solid var(--line);
    border-radius: 8px;
    background: var(--surface);
    color: var(--text);
  }
  .catalog-layout { display: flex; flex-direction: column; gap: 16px; }
  .results-top { padding: 8px 0; margin-bottom: 12px; }

  .books { grid-template-columns: 1fr; gap: 12px; }
  .book {
    display: grid;
    grid-template-columns: 100px minmax(0, 1fr);
    align-items: stretch;
  }
  .cover-frame {
    border-radius: 7px 0 0 7px;
    height: 100%;
  }
  .default-cover, .book-cover-img {
    height: 100%;
    object-fit: cover;
  }
  .book-body { padding: 12px; gap: 8px; }
  .book h3 { font-size: 15px; line-height: 1.4; }
  .author { font-size: 12px; }
  .book-foot { padding-top: 8px; margin-top: 0; }
  .tag { font-size: 10px; }
}
</style>
@endsection

@section('content')
<div class="wrap">
    <!-- Hero Intro -->
    <section class="intro">
        <div>
            <div class="eyebrow">Perpustakaan Digital</div>
            <h1>Ruang pengetahuan.<br><em>Untuk terus bertumbuh.</em></h1>
            <p>Temukan referensi, penelitian, dan pengetahuan kesehatan dalam satu ruang yang mudah dijangkau.</p>
        </div>
        <div class="intro-side">
            <p>Setiap referensi membuka sudut pandang baru. Mulai perjalanan belajar Anda dari sini.</p>
            <div class="od-row">
                <svg aria-hidden="true"><use href="#book"/></svg>
                <span>Pustaka RS Baladhika Husada</span>
            </div>
        </div>
    </section>

    <!-- Search Panel -->
    <section id="pencarian" class="search-panel" aria-label="Pencarian koleksi">
        <form id="search-form" action="{{ route('home') }}#koleksi" method="GET">
            <label for="query">Apa yang ingin Anda pelajari hari ini?</label>
            <div class="search-box">
                <svg aria-hidden="true"><use href="#search"/></svg>
                <input id="query" name="search" type="search" placeholder="Cari judul atau nama penulis…" value="{{ request('search') }}" autocomplete="off">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <button class="primary" type="submit">Cari</button>
            </div>
        </form>
        <div class="suggestions">
            <span>Topik penelusuran:</span>
            <a href="{{ route('home', array_merge(request()->except(['search', 'page']), ['search' => 'Rekam medis'])) }}#koleksi" class="suggestion-btn">Rekam medis</a>
            <a href="{{ route('home', array_merge(request()->except(['search', 'page']), ['search' => 'SIMRS'])) }}#koleksi" class="suggestion-btn">SIMRS</a>
            <a href="{{ route('home', array_merge(request()->except(['search', 'page']), ['search' => 'BPJS'])) }}#koleksi" class="suggestion-btn">BPJS</a>
        </div>
    </section>

    <!-- Catalog Section -->
    <section id="koleksi" class="catalog">
        <div class="section-heading">
            <div>
                <h2>Jelajahi koleksi</h2>
                <p>Referensi untuk mendukung pengetahuan dan praktik Anda.</p>
            </div>
        </div>

        <div class="catalog-layout">
            <!-- Sidebar Filter -->
            <aside class="filters">
                <h3>Kategori pustaka</h3>

                <!-- Mobile Category Dropdown -->
                <div class="mobile-category">
                    <label for="mobile-category" class="visually-hidden">Kategori pustaka</label>
                    <select id="mobile-category" onchange="if(this.value) window.location.href=this.value;">
                        <option value="{{ route('home', array_merge(request()->except(['category', 'page']), ['category' => 'All'])) }}#koleksi" {{ request('category', 'All') == 'All' ? 'selected' : '' }}>
                            Semua Koleksi ({{ $totalBooks }})
                        </option>
                        @foreach($categories as $cat)
                            <option value="{{ route('home', array_merge(request()->except(['category', 'page']), ['category' => $cat->name])) }}#koleksi" {{ request('category') == $cat->name ? 'selected' : '' }}>
                                {{ $cat->name }} ({{ $cat->books_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Desktop Category List -->
                <div class="category-list" aria-label="Filter kategori">
                    <a href="{{ route('home', array_merge(request()->except(['category', 'page']), ['category' => 'All'])) }}#koleksi" 
                       class="cat-btn {{ request('category', 'All') == 'All' ? 'selected' : '' }}" 
                       aria-pressed="{{ request('category', 'All') == 'All' ? 'true' : 'false' }}">
                        <span>Semua Koleksi</span>
                        <small>{{ $totalBooks }}</small>
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('home', array_merge(request()->except(['category', 'page']), ['category' => $cat->name])) }}#koleksi" 
                           class="cat-btn {{ request('category') == $cat->name ? 'selected' : '' }}" 
                           aria-pressed="{{ request('category') == $cat->name ? 'true' : 'false' }}">
                            <span>{{ $cat->name }}</span>
                            <small>{{ $cat->books_count }}</small>
                        </a>
                    @endforeach
                </div>

                <div class="aside-note">
                    <svg aria-hidden="true"><use href="#book"/></svg>
                    <p>Temukan judul yang relevan, lalu buka detail untuk mengakses sumber koleksi.</p>
                </div>
            </aside>

            <!-- Results Section -->
            <div>
                <div class="results-top">
                    <span id="result-count" aria-live="polite">
                        {{ $books->total() }} koleksi {{ request('search') ? 'untuk “' . request('search') . '”' : 'tersedia' }}
                    </span>

                    <form id="sort-form" method="GET" action="{{ route('home') }}#koleksi">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <label>
                            <span>Urutkan</span>
                            <select id="sort" name="sort" onchange="this.form.submit()" aria-label="Urutkan koleksi">
                                <option value="default" {{ request('sort', 'default') == 'default' ? 'selected' : '' }}>Urutan koleksi</option>
                                <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>Judul A-Z</option>
                                <option value="author" {{ request('sort') == 'author' ? 'selected' : '' }}>Nama penulis</option>
                            </select>
                        </label>
                    </form>
                </div>

                @if($books->count() > 0)
                    <div id="books" class="books">
                        @foreach($books as $book)
                            <a class="book" href="{{ route('books.show', $book->id) }}" aria-label="Baca detail: {{ $book->title }}">
                                <div class="cover-frame">
                                    @if($book->has_custom_cover)
                                        <img class="od-media book-cover-img" src="{{ $book->cover_url }}" alt="Sampul {{ $book->title }}" loading="lazy">
                                    @else
                                        {{-- Automatic fallback to default-cover.svg if no custom cover is uploaded --}}
                                        <img class="od-media default-cover" src="{{ $book->cover_url }}" alt="Sampul belum tersedia" loading="lazy">
                                    @endif
                                </div>
                                <div class="book-body">
                                    <span class="tag">{{ $book->category_ref->name ?? 'Kesehatan' }}</span>
                                    <h3 class="od-clamp-3">{{ Str::title($book->title) }}</h3>
                                    <p class="author">{{ $book->author }}</p>
                                    <div class="book-foot">
                                        <span>Baca detail</span>
                                        <svg aria-hidden="true"><use href="#arrow"/></svg>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    @if($books->hasPages())
                        <div class="catalog-pagination">
                            {{ $books->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                @else
                    <div class="empty">
                        <h3>Koleksi belum ditemukan</h3>
                        <p>Coba judul atau penulis lain, atau tampilkan kembali semua koleksi.</p>
                        <a href="{{ route('home') }}#koleksi" class="primary">Tampilkan semua</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
