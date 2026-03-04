@extends('layout')

@section('title', 'Login Administrator - PustakaDigital')

@section('styles')
<style>
    .login-container {
        min-height: calc(100vh - 250px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    
    .login-card {
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        border: 1px solid rgba(21, 115, 71, 0.1);
        overflow: hidden;
        background: var(--card-bg-light);
        max-width: 900px;
        width: 100%;
        margin: 0 auto;
    }

    body.dark-mode .login-card {
        background: var(--card-bg-dark);
        border: 1px solid rgba(255,255,255,0.05);
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    }

    .login-image-panel {
        background: linear-gradient(135deg, var(--bs-primary) 0%, #0a3622 100%);
        padding: 4rem;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
        position: relative;
    }

    .login-image-panel::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://www.transparenttextures.com/patterns/cubes.png');
        opacity: 0.1;
    }

    .login-form-panel {
        padding: 4rem 3rem;
    }

    .form-control {
        padding: 0.8rem 1rem;
        border-radius: 12px;
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
    
    body.dark-mode .form-control {
        border-color: #4a5568;
        background-color: #2d3748;
        color: #e2e8f0;
    }

    .form-control:focus {
        background-color: #ffffff;
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.25rem rgba(21, 115, 71, 0.25);
    }
    
    body.dark-mode .form-control:focus {
        background-color: #1a202c;
    }

    .btn-login {
        padding: 0.8rem;
        border-radius: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        font-size: 1.1rem;
        margin-top: 1rem;
        box-shadow: 0 8px 15px rgba(21, 115, 71, 0.2);
    }
</style>
@endsection

@section('content')
<div class="container login-container fade-in-up">
    <div class="card login-card">
        <div class="row g-0 h-100">
            <!-- Left Side: Image / Brand -->
            <div class="col-md-5 d-none d-md-flex login-image-panel">
                <i class="bi bi-shield-lock text-white mb-4" style="font-size: 5rem;"></i>
                <h2 class="fw-bold mb-3">Administrator Portal</h2>
                <p class="opacity-75">Sistem Manajemen Perpustakaan Digital Terpadu. Silakan masuk untuk mengelola koleksi buku.</p>
            </div>
            
            <!-- Right Side: Login Form -->
            <div class="col-md-7 login-form-panel">
                <div class="text-center mb-4 d-md-none">
                    <i class="bi bi-shield-lock text-primary mb-2" style="font-size: 3rem;"></i>
                    <h3 class="fw-bold">Login Admin</h3>
                </div>
                
                <h3 class="fw-bold mb-4 d-none d-md-block text-center">Masuk ke Akun Anda</h3>
                
                @if ($errors->any())
                    <div class="alert alert-danger" style="border-radius: 12px;">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('authenticate') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold text-muted">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent" style="border-radius: 12px 0 0 12px;"><i class="bi bi-envelope"></i></span>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="border-radius: 0 12px 12px 0;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold text-muted">Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent" style="border-radius: 12px 0 0 12px;"><i class="bi bi-key"></i></span>
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" style="border-radius: 0 12px 12px 0;">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-login">
                            Masuk Sekarang <i class="bi bi-box-arrow-in-right ms-2"></i>
                        </button>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
