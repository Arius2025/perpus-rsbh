@extends('layout')

@section('title', $book->title . ' · PustakaDigital RS Baladhika Husada')

@section('styles')
<style>
.detail-page-wrap {
  padding: 32px 0 72px;
}

.breadcrumb-nav {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 24px;
  font-size: 13px;
  color: var(--muted);
  flex-wrap: wrap;
}
.breadcrumb-nav a {
  color: var(--muted);
  text-decoration: none;
}
.breadcrumb-nav a:hover {
  color: var(--accent);
  text-decoration: underline;
}
.breadcrumb-separator {
  opacity: 0.5;
}
.breadcrumb-current {
  color: var(--text);
  font-weight: 600;
  max-width: 320px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Two-column layout */
.book-layout {
  display: grid;
  grid-template-columns: 320px 1fr;
  gap: 40px;
  align-items: flex-start;
}

/* Sidebar (Cover & CTA) */
.book-sidebar {
  display: flex;
  flex-direction: column;
  gap: 20px;
  position: sticky;
  top: 110px;
}

.book-cover-card {
  background: var(--surface);
  border: 1px solid var(--line);
  border-radius: var(--radius);
  padding: 16px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}

.book-cover-frame {
  background: var(--soft);
  border-radius: 8px;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  aspect-ratio: 3 / 4.2;
  box-shadow: 0 6px 16px rgba(0,0,0,0.08);
  border: 1px solid var(--line);
}
.book-cover-frame img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
.book-cover-frame .default-cover {
  object-fit: contain;
  padding: 16px;
}

.sidebar-actions {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.btn-detail-action {
  min-height: 48px;
  padding: 12px 20px;
  border-radius: 8px;
  font-weight: 700;
  font-size: 15px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  text-decoration: none;
  transition: all var(--motion) ease;
  width: 100%;
  box-sizing: border-box;
}

.btn-detail-primary {
  background: var(--accent);
  color: #ffffff;
  border: 1px solid var(--accent);
}
.btn-detail-primary:hover {
  background: var(--accent-hover);
  color: #ffffff;
  transform: translateY(-1px);
}

.btn-detail-secondary {
  background: var(--surface);
  color: var(--text);
  border: 1px solid var(--line);
}
.btn-detail-secondary:hover {
  border-color: var(--accent);
  color: var(--accent);
  background: var(--soft);
}

.book-meta-box {
  background: var(--surface);
  border: 1px solid var(--line);
  border-radius: var(--radius);
  padding: 20px;
  font-size: 13px;
}
.book-meta-box h4 {
  font-size: 13px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: var(--muted);
  margin-bottom: 14px;
}
.meta-row {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding: 8px 0;
  border-bottom: 1px solid var(--line);
  gap: 12px;
}
.meta-row:last-child {
  border-bottom: none;
  padding-bottom: 0;
}
.meta-label {
  color: var(--muted);
}
.meta-val {
  color: var(--text);
  font-weight: 600;
  text-align: right;
  overflow-wrap: anywhere;
}

/* Main Editorial Content Pane */
.book-main-panel {
  background: var(--surface);
  border: 1px solid var(--line);
  border-radius: var(--radius);
  padding: 40px 48px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.02);
}

.book-header {
  margin-bottom: 28px;
  padding-bottom: 24px;
  border-bottom: 1px solid var(--line);
}

.badge-row {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
  margin-bottom: 12px;
}

.badge-tag {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  padding: 4px 12px;
  border-radius: 6px;
}
.badge-category {
  background: var(--soft);
  color: var(--accent);
  border: 1px solid var(--line);
}
.badge-format-pdf {
  background: rgba(220, 38, 38, 0.1);
  color: #dc2626;
  border: 1px solid rgba(220, 38, 38, 0.2);
}
.badge-format-link {
  background: rgba(217, 119, 6, 0.1);
  color: #d97706;
  border: 1px solid rgba(217, 119, 6, 0.2);
}

.book-headline {
  font-size: clamp(24px, 3.2vw, 36px);
  line-height: 1.25;
  font-weight: 800;
  letter-spacing: -0.6px;
  color: var(--text);
  margin-bottom: 14px;
}

.book-subline {
  font-size: 15px;
  color: var(--muted);
  line-height: 1.6;
}
.book-subline strong {
  color: var(--text);
}

/* Quick Metrics Row */
.book-metrics {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  margin-bottom: 32px;
  padding: 16px 20px;
  background: var(--soft);
  border-radius: 8px;
  border: 1px solid var(--line);
}
.metric-item {
  display: flex;
  flex-direction: column;
  gap: 2px;
}
.metric-item small {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.4px;
  color: var(--muted);
}
.metric-item span {
  font-size: 15px;
  font-weight: 700;
  color: var(--text);
}

/* Editorial Reading Section */
.reading-section-title {
  font-size: 18px;
  font-weight: 800;
  letter-spacing: -0.3px;
  color: var(--text);
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.reading-section-title svg {
  color: var(--accent);
  width: 20px;
  height: 20px;
}

/* High Legibility Prose Container for Word-like Content */
.prose-reading {
  font-size: 16px;
  line-height: 1.85;
  color: var(--text);
  overflow-wrap: anywhere;
}
.prose-reading p {
  margin-bottom: 1.35em;
}
.prose-reading p:last-child {
  margin-bottom: 0;
}
.prose-reading h1, 
.prose-reading h2, 
.prose-reading h3, 
.prose-reading h4, 
.prose-reading h5, 
.prose-reading h6 {
  color: var(--text);
  font-weight: 800;
  line-height: 1.35;
  margin-top: 1.8em;
  margin-bottom: 0.6em;
}
.prose-reading h1 { font-size: 1.6em; }
.prose-reading h2 { font-size: 1.4em; }
.prose-reading h3 { font-size: 1.25em; }
.prose-reading h4 { font-size: 1.1em; }

.prose-reading ul, 
.prose-reading ol {
  margin: 1em 0 1.5em 1.5em;
  padding: 0;
}
.prose-reading li {
  margin-bottom: 0.5em;
  line-height: 1.7;
}

.prose-reading blockquote {
  margin: 1.5em 0;
  padding: 16px 24px;
  border-left: 4px solid var(--accent);
  background: var(--soft);
  border-radius: 0 8px 8px 0;
  font-style: italic;
  color: var(--text);
}

.prose-reading table {
  width: 100%;
  border-collapse: collapse;
  margin: 1.75em 0;
  font-size: 14px;
}
.prose-reading table th, 
.prose-reading table td {
  border: 1px solid var(--line);
  padding: 10px 14px;
  text-align: left;
}
.prose-reading table th {
  background: var(--soft);
  font-weight: 700;
  color: var(--text);
}

.prose-reading a {
  color: var(--accent);
  text-decoration: underline;
  text-underline-offset: 3px;
}
.prose-reading a:hover {
  color: var(--accent-hover);
}

.prose-reading img {
  max-width: 100%;
  height: auto;
  border-radius: 8px;
  margin: 1.5em 0;
  border: 1px solid var(--line);
}

.prose-reading strong, 
.prose-reading b {
  font-weight: 700;
  color: var(--text);
}

/* Management box for authorized user */
.admin-actions-card {
  margin-top: 32px;
  padding: 20px;
  background: var(--soft);
  border: 1px dashed var(--accent);
  border-radius: var(--radius);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  flex-wrap: wrap;
}
.admin-actions-info h5 {
  font-size: 14px;
  font-weight: 700;
  margin-bottom: 4px;
  color: var(--text);
}
.admin-actions-info p {
  font-size: 12px;
  color: var(--muted);
  margin: 0;
}

/* Responsive adjustments */
@media (max-width: 992px) {
  .book-layout {
    grid-template-columns: 280px 1fr;
    gap: 28px;
  }
  .book-main-panel {
    padding: 32px 28px;
  }
}

@media (max-width: 768px) {
  .book-layout {
    grid-template-columns: 1fr;
    gap: 24px;
  }
  .book-sidebar {
    position: static;
  }
  .book-cover-card {
    max-width: 260px;
    margin: 0 auto;
    width: 100%;
  }
  .book-main-panel {
    padding: 24px 20px;
  }
  .book-metrics {
    grid-template-columns: 1fr;
    gap: 12px;
  }
  .btn-detail-action {
    min-height: 48px;
  }
}
</style>
@endsection

@section('content')
<div class="wrap detail-page-wrap">
    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span class="breadcrumb-separator">/</span>
        <a href="{{ route('home') }}#koleksi">Koleksi Buku</a>
        <span class="breadcrumb-separator">/</span>
        <span>{{ $book->category_ref->name ?? 'Kategori' }}</span>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">{{ $book->title }}</span>
    </nav>

    <div class="book-layout">
        <!-- Left Column: Cover, Action CTA, Metadata Card -->
        <aside class="book-sidebar">
            <div class="book-cover-card">
                <div class="book-cover-frame">
                    @if($book->has_custom_cover)
                        <img src="{{ $book->cover_url }}" alt="Sampul {{ $book->title }}">
                    @else
                        <img class="default-cover" src="{{ $book->cover_url }}" alt="Sampul belum tersedia">
                    @endif
                </div>
            </div>

            <!-- Main CTA Buttons -->
            <div class="sidebar-actions">
                @if($book->external_link)
                    <a class="btn-detail-action btn-detail-primary" href="{{ route('books.view', $book->id) }}" target="_blank" rel="noopener">
                        <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6m4-3h6v6m-11 5L21 3"/></svg>
                        Buka Sumber Asli
                    </a>
                @else
                    @if($book->pdf_file)
                        <a class="btn-detail-action btn-detail-primary" href="{{ route('books.view', $book->id) }}" target="_blank" rel="noopener">
                            <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            Baca Sekarang
                        </a>
                        <a class="btn-detail-action btn-detail-secondary" href="{{ route('books.download', $book->id) }}">
                            <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4m4-5 5 5 5-5m-5 5V3"/></svg>
                            Unduh Dokumen PDF
                        </a>
                    @else
                        <a class="btn-detail-action btn-detail-primary" href="https://perpus.rsbaladhikahusada.com/books/{{ $book->id }}" target="_blank" rel="noopener">
                            <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6m4-3h6v6m-11 5L21 3"/></svg>
                            Buka Sumber Asli
                        </a>
                    @endif
                @endif

                <a class="btn-detail-action btn-detail-secondary" href="{{ route('home') }}#koleksi">
                    <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24"><path d="M19 12H5m7-7-7 7 7 7"/></svg>
                    Kembali ke Katalog
                </a>
            </div>

            <!-- Quick Metadata Details -->
            <div class="book-meta-box">
                <h4>Informasi Koleksi</h4>
                <div class="meta-row">
                    <span class="meta-label">Diupload Oleh</span>
                    <span class="meta-val">
                        {{ $book->uploader->name ?? 'Admin Perpustakaan' }}
                        @if($book->uploader && $book->uploader->isAdminUtama())
                            <span class="badge bg-primary ms-1" style="font-size: 10px;">Admin Utama</span>
                        @endif
                    </span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Format Berkas</span>
                    <span class="meta-val">{{ $book->external_link ? 'Tautan Web' : 'Dokumen PDF' }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Total Akses</span>
                    <span class="meta-val">{{ $book->download_count }} kali dibaca</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Institusi</span>
                    <span class="meta-val">RS Baladhika Husada</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Tanggal Masuk</span>
                    <span class="meta-val">{{ $book->created_at ? $book->created_at->format('d M Y') : 'Tersedia' }}</span>
                </div>
            </div>
        </aside>

        <!-- Right Column: Editorial Reading Pane -->
        <article class="book-main-panel">
            <header class="book-header">
                <div class="badge-row">
                    <span class="badge-tag badge-category">
                        <i class="bi bi-bookmark-fill"></i>
                        {{ $book->category_ref->name ?? 'Umum' }}
                    </span>
                    @if($book->external_link)
                        <span class="badge-tag badge-format-link">
                            <i class="bi bi-link-45deg"></i> Link Eksternal
                        </span>
                    @else
                        <span class="badge-tag badge-format-pdf">
                            <i class="bi bi-file-earmark-pdf-fill"></i> PDF Digital
                        </span>
                    @endif
                </div>

                <h1 class="book-headline">{{ $book->title }}</h1>

                <p class="book-subline">
                    Karya <strong>{{ $book->author }}</strong> 
                    &bull; Diterbitkan oleh <strong>{{ $book->publisher ?: 'RS TK. III Baladhika Husada' }}</strong>
                </p>
            </header>

            <!-- Compact Metrics Grid -->
            <div class="book-metrics">
                <div class="metric-item">
                    <small>Penulis</small>
                    <span>{{ $book->author }}</span>
                </div>
                <div class="metric-item">
                    <small>Penerbit</small>
                    <span>{{ $book->publisher ?: 'RS Baladhika Husada' }}</span>
                </div>
                <div class="metric-item">
                    <small>Dibaca / Diunduh</small>
                    <span>{{ $book->download_count }} Kali</span>
                </div>
            </div>

            <!-- Reading Section -->
            <section class="book-description-wrap">
                <h2 class="reading-section-title">
                    <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Sinopsis & Deskripsi Lengkap
                </h2>

                <div class="prose-reading">
                    @if(!empty($book->description))
                        {!! $book->description !!}
                    @else
                        <p class="text-muted fst-italic">Belum ada deskripsi lengkap atau sinopsis untuk buku ini.</p>
                    @endif
                </div>
            </section>

            <!-- Admin / Uploader Management Action Quick Bar -->
            @auth
                @if(auth()->user()->canManageBook($book))
                    <div class="admin-actions-card">
                        <div class="admin-actions-info">
                            <h5>Akses Pengelola Buku</h5>
                            <p>Anda berhak mengelola atau menyunting koleksi ini (sebagai pengunggah atau Admin Utama).</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-outline-primary" style="min-height: 38px; border-radius: 6px; display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
                                <i class="bi bi-pencil-square"></i> Edit Buku
                            </a>
                            <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" style="min-height: 38px; border-radius: 6px; display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth
        </article>
    </div>
</div>
@endsection
