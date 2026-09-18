@extends('layout')

@section('title', $book->title . ' · PustakaDigital')

@section('styles')
<style>
.detail-wrap {
  padding: 40px 0 80px;
  max-width: 900px;
  margin: auto;
}
.back-link {
  min-height: 44px;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  color: var(--accent);
  margin-bottom: 24px;
  font-weight: 600;
  text-decoration: none;
  font-size: 14px;
}
.back-link:hover {
  text-decoration: underline;
}
.back-link svg {
  width: 16px;
  height: 16px;
}

.detail-panel {
  background: var(--surface);
  border: 1px solid var(--line);
  padding: 48px;
  border-radius: var(--radius);
}

.detail-grid {
  display: grid;
  grid-template-columns: 260px 1fr;
  gap: 40px;
  align-items: flex-start;
  margin-bottom: 32px;
}

.detail-cover-box {
  background: var(--soft);
  border: 1px solid var(--line);
  border-radius: 8px;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}
.detail-cover-box img {
  display: block;
  width: 100%;
  height: auto;
  aspect-ratio: 360/240;
  object-fit: cover;
}
.detail-cover-box .default-cover {
  object-fit: contain;
  padding: 8px;
}

.detail-info {
  display: flex;
  flex-direction: column;
}

.detail-tag {
  font-size: 12px;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  color: var(--accent);
  font-weight: 700;
  margin-bottom: 8px;
}

.detail-title {
  font-size: clamp(22px, 3vw, 30px);
  line-height: 1.35;
  font-weight: 800;
  letter-spacing: -0.5px;
  margin-bottom: 24px;
  overflow-wrap: anywhere;
  color: var(--text);
}

.detail-dl {
  display: grid;
  grid-template-columns: 130px 1fr;
  gap: 14px 16px;
  margin: 0 0 24px;
  font-size: 14px;
}
.detail-dl dt {
  color: var(--muted);
  font-weight: 500;
}
.detail-dl dd {
  margin: 0;
  color: var(--text);
  font-weight: 600;
  overflow-wrap: anywhere;
}

.detail-description {
  margin-top: 24px;
  padding-top: 24px;
  border-top: 1px solid var(--line);
}
.detail-description h3 {
  font-size: 16px;
  font-weight: 700;
  margin-bottom: 12px;
  color: var(--text);
}
.detail-description p {
  color: var(--muted);
  line-height: 1.7;
  font-size: 15px;
  white-space: pre-line;
}

.actions-row {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
  margin-top: 32px;
  padding-top: 24px;
  border-top: 1px solid var(--line);
}

.btn-secondary-action {
  min-height: 48px;
  padding: 12px 24px;
  border-radius: 6px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  border: 1px solid var(--line);
  color: var(--text);
  background: var(--surface);
  gap: 8px;
}
.btn-secondary-action:hover {
  border-color: var(--accent);
  color: var(--accent);
}

.detail-note {
  color: var(--muted);
  font-size: 13px;
  margin: 20px 0 0;
}

@media (max-width: 768px) {
  .detail-wrap { padding: 24px 0 48px; }
  .detail-panel { padding: 24px 16px; }
  .detail-grid { grid-template-columns: 1fr; gap: 24px; }
  .detail-cover-box { max-width: 280px; margin: 0 auto; width: 100%; }
  .detail-dl { grid-template-columns: 110px 1fr; gap: 10px; font-size: 13px; }
  .actions-row { flex-direction: column; align-items: stretch; }
  .actions-row .primary, .actions-row .btn-secondary-action { width: 100%; }
}
</style>
@endsection

@section('content')
<div class="wrap">
    <div class="detail-wrap">
        <a class="back-link" href="{{ route('home') }}#koleksi">
            <svg aria-hidden="true" viewBox="0 0 24 24"><path d="M19 12H5m7-7-7 7 7 7"/></svg>
            Kembali ke koleksi
        </a>

        <article class="detail-panel">
            <div class="detail-grid">
                <!-- Book Cover Preview -->
                <div class="detail-cover-box">
                    @if($book->has_custom_cover)
                        <img src="{{ $book->cover_url }}" alt="Sampul {{ $book->title }}">
                    @else
                        {{-- Automatic fallback to default-cover.svg if no custom cover is uploaded --}}
                        <img class="default-cover" src="{{ $book->cover_url }}" alt="Sampul belum tersedia">
                    @endif
                </div>

                <!-- Book Metadata Info -->
                <div class="detail-info">
                    <span class="detail-tag">{{ $book->category_ref->name ?? 'Kesehatan' }} / Detail koleksi</span>
                    <h1 class="detail-title">{{ $book->title }}</h1>

                    <dl class="detail-dl">
                        <dt>Penulis</dt>
                        <dd>{{ $book->author }}</dd>

                        <dt>Kategori</dt>
                        <dd>{{ $book->category_ref->name ?? 'Koleksi Umum' }}</dd>

                        <dt>Penerbit</dt>
                        <dd>{{ $book->publisher ?: 'RS TK. III Baladhika Husada' }}</dd>

                        <dt>Perpustakaan</dt>
                        <dd>RS TK. III Baladhika Husada Jember</dd>

                        <dt>Tanggal rilis</dt>
                        <dd>{{ $book->created_at ? $book->created_at->format('d F Y') : 'Tersedia' }}</dd>

                        <dt>Total akses</dt>
                        <dd>{{ $book->download_count }} kali diakses</dd>
                    </dl>
                </div>
            </div>

            @if($book->description)
                <div class="detail-description">
                    <h3>Ringkasan dan Sinopsis</h3>
                    <p>{{ $book->description }}</p>
                </div>
            @endif

            <div class="actions-row">
                @if($book->external_link)
                    <a class="primary" href="{{ route('books.view', $book->id) }}" target="_blank" rel="noopener">
                        Buka sumber asli
                        <svg aria-hidden="true"><use href="#arrow"/></svg>
                    </a>
                @else
                    @if($book->pdf_file)
                        <a class="primary" href="{{ route('books.view', $book->id) }}" target="_blank" rel="noopener">
                            Baca sekarang
                            <svg aria-hidden="true"><use href="#arrow"/></svg>
                        </a>
                        <a class="btn-secondary-action" href="{{ route('books.download', $book->id) }}">
                            <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4m4-5 5 5 5-5m-5 5V3"/></svg>
                            Unduh PDF
                        </a>
                    @else
                        <a class="primary" href="https://perpus.rsbaladhikahusada.com/books/{{ $book->id }}" target="_blank" rel="noopener">
                            Buka sumber asli
                            <svg aria-hidden="true"><use href="#arrow"/></svg>
                        </a>
                    @endif
                @endif
            </div>

            <p class="detail-note">Sumber koleksi dibuka di tab baru. Ketersediaan dokumen dan hak akses baca mengikuti ketentuan RS Baladhika Husada.</p>
        </article>
    </div>
</div>
@endsection
