<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Digital Library System')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bs-primary: #0f766e; /* Teal Green */
            --bs-primary-rgb: 15, 118, 110;
            --bs-primary-light: #f0fdfa;
            --bg-color-light: #f8fafc;
            --text-color-light: #1e293b;
            --card-bg-light: #ffffff;
            --card-border-light: rgba(0, 0, 0, 0.05);
            
            /* Dark Mode Variables */
            --bg-color-dark: #0f172a;
            --text-color-dark: #f8fafc;
            --card-bg-dark: #1e293b;
            --card-border-dark: rgba(255, 255, 255, 0.05);
            --navbar-dark: #1e293b;
            
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-bg-dark: rgba(30, 41, 59, 0.7);
        }

        /* Base Typography & Body */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color-light);
            color: var(--text-color-light);
            transition: background-color 0.3s ease, color 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-bottom: 70px; /* Space for mobile nav */
        }

        body.dark-mode {
            background-color: var(--bg-color-dark);
            color: var(--text-color-dark);
        }

        /* Navbar Styling */
        .navbar {
            background-color: #ffffff;
            /* Emerald green subtle bottom border */
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-bottom: 2px solid var(--bs-primary);
            transition: all 0.3s ease;
        }

        body.dark-mode .navbar {
            background-color: var(--navbar-dark);
            border-bottom: 2px solid var(--bs-primary);
        }

        body.dark-mode .navbar-brand, 
        body.dark-mode .nav-link {
            color: #ffffff !important;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--bs-primary) !important;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 500;
            position: relative;
        }

        /* Desktop Nav Hover Effect */
        @media (min-width: 992px) {
            .nav-link::after {
                content: '';
                position: absolute;
                width: 0;
                height: 2px;
                bottom: 0;
                left: 50%;
                background-color: var(--bs-primary);
                transition: all 0.3s ease;
            }
            .nav-link:hover::after {
                width: 100%;
                left: 0;
            }
            .mobile-bottom-nav {
                display: none !important;
            }
            body {
                padding-bottom: 0px;
            }
        }

        /* Mobile Bottom Nav Styling */
        @media (max-width: 991.98px) {
            .desktop-nav-items {
                display: none !important;
            }
            
            .mobile-bottom-nav {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background-color: #ffffff;
                box-shadow: 0 -4px 12px rgba(0,0,0,0.08);
                display: flex;
                justify-content: space-around;
                align-items: center;
                padding: 10px 0;
                z-index: 1030;
                transition: background-color 0.3s ease;
                border-top-left-radius: 20px;
                border-top-right-radius: 20px;
            }
            
            body.dark-mode .mobile-bottom-nav {
                background-color: var(--navbar-dark);
                box-shadow: 0 -4px 12px rgba(0,0,0,0.2);
            }

            .mobile-nav-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                color: #6c757d;
                text-decoration: none;
                font-size: 0.8rem;
                font-weight: 500;
                transition: all 0.2s ease;
            }

            body.dark-mode .mobile-nav-item {
                color: #a0aec0;
            }

            .mobile-nav-item i {
                font-size: 1.5rem;
                margin-bottom: 2px;
                transition: transform 0.2s ease;
            }

            .mobile-nav-item:hover, .mobile-nav-item:active, .mobile-nav-item.active {
                color: var(--bs-primary);
            }

            .mobile-nav-item:hover i, .mobile-nav-item:active i, .mobile-nav-item.active i {
                transform: translateY(-3px);
            }
        }

        /* Content Container */
        .main-content {
            flex: 1;
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        /* Buttons & Interactions */
        .btn-primary {
            background-color: var(--bs-primary);
            border: none;
            font-weight: 600;
            padding: 0.7rem 1.8rem;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(15, 118, 110, 0.25);
            transition: var(--transition-smooth);
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: #0d9488;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(15, 118, 110, 0.35);
        }

        /* Card Styling for Premium Look */
        .card {
            border: 1px solid var(--card-border-light);
            border-radius: 20px;
            background-color: var(--card-bg-light);
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            transition: var(--transition-smooth);
            overflow: hidden;
        }

        body.dark-mode .card {
            background-color: var(--card-bg-dark);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        /* Theme Toggle Button */
        #theme-toggle {
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #f8f9fa;
            border: none;
            transition: all 0.3s ease;
        }

        body.dark-mode #theme-toggle {
            background-color: #2d3748;
            color: #f6e05e;
        }

        #theme-toggle:hover {
            transform: rotate(15deg) scale(1.1);
        }

        /* Dark Mode General Overrides */
        body.dark-mode .text-muted { color: #a0aec0 !important; }
        body.dark-mode .bg-light { background-color: #2d3748 !important; }
        body.dark-mode .text-dark { color: #f8f9fa !important; }
        body.dark-mode .modal-content { background-color: var(--card-bg-dark); color: var(--text-color-dark); }
        body.dark-mode .modal-header { border-bottom-color: rgba(255,255,255,0.05); }
        body.dark-mode .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
        body.dark-mode .form-control { color: #e2e8f0; }
        body.dark-mode h1, body.dark-mode h2, body.dark-mode h3, body.dark-mode h4, body.dark-mode h5, body.dark-mode h6, body.dark-mode p { color: var(--text-color-dark) !important; }

        /* Utility animations */
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body.dark-mode .input-group-text {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
            color: #e2e8f0 !important;
        }

        body.dark-mode .modal-content {
            background-color: var(--card-bg-dark);
            border: 1px solid rgba(255,255,255,0.1);
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Top Sticky Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="bi bi-book-half fs-3 me-2"></i>
                PustakaDigital
            </a>
            
            <div class="d-flex align-items-center">
                <!-- Mobile Theme Toggle -->
                <button id="theme-toggle-mobile" class="btn btn-link nav-link d-lg-none me-2" aria-label="Toggle Dark Mode">
                    <i class="bi bi-moon-stars-fill"></i>
                </button>
            </div>

            <!-- Desktop Menu -->
            <div class="collapse navbar-collapse desktop-nav-items" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Manajemen Kategori</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Manajemen Akun</a>
                        </li>
                        <li class="nav-item ms-3">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-outline-danger btn-sm" style="border-radius:20px;">Logout</button>
                            </form>
                        </li>
                    @else
                        <!--
                        <li class="nav-item ms-3">
                            <a class="btn btn-primary btn-sm" href="{{ route('login') }}" style="border-radius:20px;">Login Admin</a>
                        </li>
                        -->
                    @endauth
                    
                    <!-- Desktop Theme Toggle -->
                    <li class="nav-item ms-3">
                        <button id="theme-toggle" aria-label="Toggle Dark Mode">
                            <i class="bi bi-moon-stars-fill"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content container fade-in-up">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" style="border-radius: 12px; border-left: 5px solid var(--bs-primary);" role="alert">
                <i class="bi bi-check-circle-fill me-2 text-primary"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Mobile Bottom Navigation Bar -->
    <nav class="mobile-bottom-nav">
        <a href="{{ route('home') }}" class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill"></i>
            <span>Beranda</span>
        </a>
        <a href="#" class="mobile-nav-item" data-bs-toggle="modal" data-bs-target="#searchModal">
            <i class="bi bi-search"></i>
            <span>Cari</span>
        </a>
        @auth
            <a href="#" class="mobile-nav-item {{ request()->routeIs('admin.*') ? 'active' : '' }}" data-bs-toggle="modal" data-bs-target="#adminMenuModal">
                <i class="bi bi-grid-fill"></i>
                <span>Admin</span>
            </a>
            <a href="#" class="mobile-nav-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @else
            <!--
            <a href="{{ route('login') }}" class="mobile-nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Login</span>
            </a>
            -->
        @endauth
    </nav>

    <!-- Search Modal for Mobile -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border:none;">
          <div class="modal-header border-0 pb-0">
            <h5 class="modal-title fw-bold">Pencarian Buku</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('home') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0" style="border-radius: 12px 0 0 12px;"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0 form-control-lg" placeholder="Judul atau Penulis..." style="border-radius: 0 12px 12px 0; box-shadow:none;" value="{{ request('search') }}">
                </div>
                <div class="mt-3 text-center">
                    <button type="submit" class="btn btn-primary w-100" style="border-radius:12px;">Cari Sekarang</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Admin Menu Modal for Mobile -->
    <div class="modal fade" id="adminMenuModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border:none;">
          <div class="modal-header border-0 pb-0">
            <h5 class="modal-title fw-bold">Menu Administrasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4">
            <div class="list-group list-group-flush border-0">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 mb-2 {{ request()->routeIs('admin.dashboard') ? 'bg-primary bg-opacity-10 text-primary fw-bold' : '' }}" style="border-radius: 12px;">
                    <div class="p-2 bg-primary bg-opacity-10 rounded-3 me-3">
                        <i class="bi bi-book fs-4"></i>
                    </div>
                    Manajemen Buku
                </a>
                <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 mb-2 {{ request()->routeIs('admin.categories.*') ? 'bg-primary bg-opacity-10 text-primary fw-bold' : '' }}" style="border-radius: 12px;">
                    <div class="p-2 bg-warning bg-opacity-10 rounded-3 me-3 text-warning">
                        <i class="bi bi-tags fs-4"></i>
                    </div>
                    Manajemen Kategori
                </a>
                <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3 border-0 mb-2 {{ request()->routeIs('admin.users.*') ? 'bg-primary bg-opacity-10 text-primary fw-bold' : '' }}" style="border-radius: 12px;">
                    <div class="p-2 bg-info bg-opacity-10 rounded-3 me-3 text-info">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    Manajemen Akun
                </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Theme Selection Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const body = document.body;
            const themeToggles = [document.getElementById('theme-toggle'), document.getElementById('theme-toggle-mobile')];
            
            // Check Local Storage
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                body.classList.add('dark-mode');
                updateIcons(true);
            }

            themeToggles.forEach(btn => {
                if(!btn) return;
                btn.addEventListener('click', () => {
                    body.classList.toggle('dark-mode');
                    const isDark = body.classList.contains('dark-mode');
                    
                    if (isDark) {
                        localStorage.setItem('theme', 'dark');
                    } else {
                        localStorage.setItem('theme', 'light');
                    }
                    
                    updateIcons(isDark);
                });
            });

            function updateIcons(isDark) {
                themeToggles.forEach(btn => {
                    if(!btn) return;
                    const icon = btn.querySelector('i');
                    if (isDark) {
                        icon.classList.remove('bi-moon-stars-fill');
                        icon.classList.add('bi-sun-fill');
                    } else {
                        icon.classList.remove('bi-sun-fill');
                        icon.classList.add('bi-moon-stars-fill');
                    }
                });
            }

            // Animate items sequentially on load
            const animatedItems = document.querySelectorAll('.fade-in-up');
            animatedItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
    @yield('modals')
    @yield('scripts')
</body>
</html>
