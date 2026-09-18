<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f766e">
    <title>@yield('title', 'PustakaDigital · Baladhika Husada')</title>

    <!-- Bootstrap 5 CSS for Admin & Utility Compatibility -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    /* OD-LAYOUT-PRIMITIVES v1 */
    @layer od-layout {
      :where(.od-stack,.od-row,.od-row-top,.od-cluster,.od-grid,.od-field,.od-stat,.od-cell,.od-tile) > :where(*) { min-width: 0; }
      .od-stack   { display: flex; flex-direction: column; gap: var(--od-gap, 8px); }
      .od-row     { display: flex; align-items: center; gap: var(--od-gap, 8px); }
      .od-row-top { display: flex; align-items: flex-start; gap: var(--od-gap, 8px); }
      .od-cluster { display: flex; flex-wrap: wrap; align-items: center; gap: var(--od-gap, 8px); }
      .od-fill    { flex: 1 1 0; min-width: 0; }
      .od-fixed   { flex: none; }
      .od-grid    { display: grid; gap: var(--od-gap, 12px); grid-template-columns: repeat(var(--od-cols, 3), minmax(0, 1fr)); }
      .od-stat, .od-field, .od-cell { display: grid; gap: var(--od-gap, 2px); }
      :where(.od-stat,.od-field,.od-cell) > :where(*) { display: block; }
      .od-tile { display: grid; grid-template-rows: auto 1fr; }
      :where(.od-tile) > :where(*) { display: block; }
      .od-media { display: block; width: 100%; height: auto; aspect-ratio: var(--od-ratio, auto); }
      .od-media-cover { object-fit: cover; }
      .od-truncate { display: block; max-width: 100%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
      .od-clamp-2, .od-clamp-3 { display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; overflow-wrap: anywhere; }
      .od-clamp-2 { -webkit-line-clamp: 2; }
      .od-clamp-3 { -webkit-line-clamp: 3; }
      .od-lines-2 { min-height: calc(2 * 1.4em); }
      .od-nowrap  { white-space: nowrap; }
      .od-keep    { word-break: keep-all; overflow-wrap: anywhere; }
      .od-screen { display: grid; grid-template-rows: auto minmax(0, 1fr) auto; height: 100%; }
      .od-scroll { overflow-y: auto; overscroll-behavior: contain; min-height: 0; }
      .od-rail { display: flex; gap: var(--od-gap, 8px); overflow-x: auto; scroll-snap-type: x proximity; scrollbar-width: none;
                 padding-inline: var(--od-rail-pad, 16px); scroll-padding-inline: var(--od-rail-pad, 16px); }
      .od-rail::-webkit-scrollbar { display: none; }
      :where(.od-rail) > :where(*) { flex: none; scroll-snap-align: start; }
      :where(.od-rail) > :where(:last-child) { margin-inline-end: var(--od-rail-pad, 16px); }
      .od-spacer { flex: none; visibility: hidden; pointer-events: none; }
      .od-touch  { min-width: 44px; min-height: 44px; }
    }

    @font-face {
      font-family: 'Jakarta';
      src: url('{{ asset('fonts/jakarta.ttf') }}') format('truetype');
      font-display: swap;
    }

    :root {
      --bg: #f8fafc;
      --surface: #ffffff;
      --text: #172c32;
      --muted: #52636b;
      --accent: #0f766e;
      --accent-hover: #095f58;
      --soft: #e9f3f1;
      --line: #dce6e7;
      --hero: #113f3b;
      --hero-text: #ffffff;
      --radius: 12px;
      --space: 8px;
      --small: 16px;
      --body: 16px;
      --h3: 20px;
      --h2: 32px;
      --display: clamp(32px, 4vw, 56px);
      --motion: 180ms;
      --font: 'Jakarta', 'Segoe UI', system-ui, -apple-system, sans-serif;
      color-scheme: light;

      /* Bootstrap Variable Overrides */
      --bs-primary: #0f766e;
      --bs-primary-rgb: 15, 118, 110;
      --bs-body-font-family: var(--font);
      --bs-body-bg: var(--bg);
      --bs-body-color: var(--text);
    }

    :root[data-theme="dark"], body.dark-mode {
      --bg: #102126;
      --surface: #193239;
      --text: #f1f5f9;
      --muted: #bacbd0;
      --accent: #83ded0;
      --accent-hover: #67cbbe;
      --soft: #22443f;
      --line: #365057;
      --hero: #123c38;
      --hero-text: #ffffff;
      color-scheme: dark;

      --bs-body-bg: var(--bg);
      --bs-body-color: var(--text);
    }

    * { box-sizing: border-box; }
    body {
      margin: 0;
      background: var(--bg);
      color: var(--text);
      font: var(--body)/1.6 var(--font);
      transition: background-color var(--motion) ease, color var(--motion) ease;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    button, input, select { font: inherit; }
    button, a, input, select { -webkit-tap-highlight-color: transparent; }
    button, a, select { cursor: pointer; }
    button { color: inherit; background: none; border: 0; }
    a { color: var(--accent); text-decoration: none; }
    button:focus-visible, a:focus-visible, input:focus-visible, select:focus-visible {
      outline: 3px solid var(--accent);
      outline-offset: 4px;
    }
    h1, h2, h3, p { margin: 0; }
    h1, h2, h3 { line-height: 1.3; }
    button, a { transition: opacity var(--motion) ease-out, color var(--motion) ease-out, background-color var(--motion) ease-out; }
    svg {
      width: 24px;
      height: 24px;
      fill: none;
      stroke: currentColor;
      stroke-width: 1.7;
      stroke-linecap: round;
      stroke-linejoin: round;
      flex: none;
    }

    .wrap {
      width: min(1280px, calc(100% - 96px));
      margin: auto;
    }

    /* Accessibility Skip Link */
    .skip {
      position: fixed;
      top: 8px;
      left: 8px;
      z-index: 1050;
      background: var(--surface);
      color: var(--accent);
      padding: 12px 16px;
      border-radius: 6px;
      border: 1px solid var(--line);
      font-weight: 700;
      text-decoration: none;
      transform: translateY(-150%);
      transition: transform var(--motion) ease;
    }
    .skip:focus { transform: translateY(0); }

    /* Header */
    .header {
      border-bottom: 1px solid var(--line);
      background: var(--surface);
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .header-inner {
      min-height: 96px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 32px;
    }
    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      color: var(--text);
    }
    .brand img {
      display: block;
      width: 48px;
      height: auto;
    }
    .brand strong {
      font-size: 20px;
      letter-spacing: -0.6px;
      display: block;
    }
    .brand small {
      font-size: 12px;
      color: var(--muted);
      letter-spacing: 0.3px;
      display: block;
    }
    .nav {
      display: flex;
      align-items: center;
      gap: 32px;
    }
    .nav a {
      text-decoration: none;
      color: var(--muted);
      padding: 32px 0;
      font-weight: 500;
      position: relative;
    }
    .nav a.active {
      color: var(--accent);
      box-shadow: inset 0 -2px var(--accent);
      font-weight: 700;
    }
    .theme-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      min-width: 44px;
      min-height: 44px;
      border: 1px solid var(--line);
      border-radius: 8px;
      color: var(--text);
      background: var(--surface);
    }
    .theme-btn:hover {
      border-color: var(--accent);
      color: var(--accent);
    }

    /* Primary Action Buttons */
    .primary {
      background: #0f766e;
      color: #fff !important;
      min-height: 48px;
      padding: 12px 32px;
      border-radius: 6px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      gap: 8px;
      border: 0;
    }
    .primary:hover {
      background: #095f58;
      color: #fff !important;
    }
    :root[data-theme="dark"] .primary {
      background: #0f766e;
      color: #fff !important;
    }
    :root[data-theme="dark"] .primary:hover {
      background: #115e59;
    }

    /* Footer */
    .footer {
      border-top: 1px solid var(--line);
      padding: 24px 0;
      color: var(--muted);
      font-size: 12px;
      background: var(--surface);
      margin-top: auto;
    }
    .footer .wrap {
      display: flex;
      justify-content: space-between;
      gap: 24px;
      align-items: center;
    }

    /* Mobile Bottom Navigation (for quick access on phones) */
    .mobile-bottom-bar {
      display: none;
    }

    @media (hover: hover) {
      button:hover, .nav a:hover { color: var(--accent); }
    }

    @media (max-width: 1024px) {
      .wrap { width: calc(100% - 64px); }
      .nav { gap: 24px; }
    }

    @media (max-width: 768px) {
      .wrap { width: calc(100% - 32px); }
      .header-inner { min-height: 64px; gap: 8px; }
      .brand { min-width: 0; gap: 8px; }
      .brand img { width: 36px; }
      .brand strong { font-size: 16px; }
      .brand small { font-size: 9px; letter-spacing: 0; }
      .nav a { display: none; }
      .footer .wrap { flex-direction: column; text-align: center; gap: 8px; }
      .footer { padding: 16px 0 76px; }

      .mobile-bottom-bar {
        display: flex;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60px;
        background: var(--surface);
        border-top: 1px solid var(--line);
        justify-content: space-around;
        align-items: center;
        z-index: 1020;
      }
      .mobile-bottom-bar a, .mobile-bottom-bar button {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        font-size: 11px;
        font-weight: 600;
        text-decoration: none;
        min-width: 44px;
        min-height: 44px;
        gap: 2px;
      }
      .mobile-bottom-bar a svg, .mobile-bottom-bar button svg {
        width: 20px;
        height: 20px;
      }
      .mobile-bottom-bar a.active {
        color: var(--accent);
      }
    }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Hidden Global SVG Symbols -->
    <svg style="display:none" aria-hidden="true">
        <symbol id="search" viewBox="0 0 24 24"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 5 5"/></symbol>
        <symbol id="arrow" viewBox="0 0 24 24"><path d="M4 12h16m-6-6 6 6-6 6"/></symbol>
        <symbol id="book" viewBox="0 0 24 24"><path d="M12 5c-3-2-6-2-9-1v15c3-1 6-1 9 1 3-2 6-2 9-1V4c-3-1-6-1-9 1Zm0 0v15"/></symbol>
        <symbol id="moon" viewBox="0 0 24 24"><path d="M20 15A9 9 0 0 1 9 4a9 9 0 1 0 11 11Z"/></symbol>
        <symbol id="sun" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72 1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></symbol>
        <symbol id="file" viewBox="0 0 24 24"><path d="M14 3H5v18h14V8Zm0 0v5h5M8 12h8m-8 4h6"/></symbol>
    </svg>

    <!-- Accessibility Skip Link -->
    <a href="#main" class="skip">Lewati ke konten</a>

    <!-- Top Navigation Header -->
    <header class="header">
        <div class="wrap header-inner">
            <a href="{{ route('home') }}" class="brand" aria-label="PustakaDigital beranda">
                <img src="{{ asset('images/logo.png') }}" width="48" height="48" alt="Logo Baladhika Husada">
                <span class="od-field">
                    <strong>PustakaDigital<span style="color:var(--accent)">.</span></strong>
                    <small>RS TK. III BALADHIKA HUSADA</small>
                </span>
            </a>
            <nav class="nav" aria-label="Navigasi utama">
                <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('home') }}#koleksi">Koleksi Pustaka</a>
                @auth
                    <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                    <a class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Kategori</a>
                    <a class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Akun</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 6px;">Keluar</button>
                    </form>
                @endauth
                <button class="theme-btn" id="theme-btn" aria-label="Aktifkan mode gelap" title="Ganti tema">
                    <svg id="theme-icon" aria-hidden="true"><use href="#moon"/></svg>
                </button>
            </nav>
        </div>
    </header>

    <!-- Main Content Area -->
    <main id="main" tabindex="-1">
        @if(session('success'))
            <div class="wrap my-3">
                <div class="alert alert-success alert-dismissible fade show mb-0" role="alert" style="border-radius: var(--radius); border-left: 4px solid var(--accent);">
                    <strong>Berhasil:</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="wrap my-3">
                <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert" style="border-radius: var(--radius);">
                    <strong>Terjadi kesalahan:</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-bottom-bar" aria-label="Navigasi bawah seluler">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <svg aria-hidden="true"><use href="#book"/></svg>
            <span>Koleksi</span>
        </a>
        <a href="{{ route('home') }}#pencarian">
            <svg aria-hidden="true"><use href="#search"/></svg>
            <span>Cari</span>
        </a>
        @auth
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">
                <svg aria-hidden="true"><use href="#file"/></svg>
                <span>Admin</span>
            </a>
        @endauth
        <button id="mobile-theme-btn" aria-label="Ganti mode tampilan">
            <svg id="mobile-theme-icon" aria-hidden="true"><use href="#moon"/></svg>
            <span>Tema</span>
        </button>
    </nav>

    <!-- Footer -->
    <footer class="footer">
        <div class="wrap">
            <span>PustakaDigital · RS TK. III Baladhika Husada</span>
            <span>Ruang baca digital, akses pengetahuan lebih dekat.</span>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Synchronized Theme Script -->
    <script>
    (function(){
        function applyTheme(isDark) {
            document.documentElement.dataset.theme = isDark ? 'dark' : 'light';
            if (isDark) {
                document.body.classList.add('dark-mode');
            } else {
                document.body.classList.remove('dark-mode');
            }

            const label = isDark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap';
            const iconHref = isDark ? '#sun' : '#moon';

            const btn = document.getElementById('theme-btn');
            if (btn) {
                btn.setAttribute('aria-label', label);
                btn.setAttribute('aria-pressed', String(isDark));
                const icon = document.getElementById('theme-icon');
                if (icon) icon.innerHTML = `<use href="${iconHref}"/>`;
            }

            const mobileBtn = document.getElementById('mobile-theme-btn');
            if (mobileBtn) {
                mobileBtn.setAttribute('aria-label', label);
                const mobileIcon = document.getElementById('mobile-theme-icon');
                if (mobileIcon) mobileIcon.innerHTML = `<use href="${iconHref}"/>`;
            }
        }

        let isDark = false;
        try {
            const saved = localStorage.getItem('pustaka-theme');
            if (saved !== null) {
                isDark = saved === 'dark';
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                isDark = true;
            }
        } catch(e) {}

        applyTheme(isDark);

        function toggle() {
            isDark = !isDark;
            applyTheme(isDark);
            try {
                localStorage.setItem('pustaka-theme', isDark ? 'dark' : 'light');
            } catch(e) {}
        }

        const btn = document.getElementById('theme-btn');
        if (btn) btn.addEventListener('click', toggle);

        const mobileBtn = document.getElementById('mobile-theme-btn');
        if (mobileBtn) mobileBtn.addEventListener('click', toggle);
    })();
    </script>

    @yield('scripts')
</body>
</html>
