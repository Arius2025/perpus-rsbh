@extends('layout')

@section('title', 'Masuk Pengelola · PustakaDigital')

@section('styles')
<style>
.auth-container {
  min-height: calc(100vh - 220px);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 48px 16px;
}

.auth-card {
  width: 100%;
  max-width: 440px;
  background: var(--surface);
  border: 1px solid var(--line);
  border-radius: var(--radius);
  padding: 40px 36px;
}

.auth-header {
  text-align: center;
  margin-bottom: 32px;
}

.auth-logo {
  width: 52px;
  height: auto;
  margin-bottom: 16px;
}

.auth-title {
  font-size: 22px;
  font-weight: 800;
  letter-spacing: -0.5px;
  color: var(--text);
  margin-bottom: 6px;
}

.auth-subtitle {
  font-size: 13px;
  color: var(--muted);
  line-height: 1.5;
  margin: 0;
}

.auth-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-size: 13px;
  font-weight: 600;
  color: var(--text);
}

.auth-input {
  width: 100%;
  min-height: 46px;
  padding: 10px 14px;
  border-radius: 8px;
  border: 1px solid var(--line);
  background: var(--surface);
  color: var(--text);
  font-size: 14px;
  transition: border-color var(--motion) ease;
}

.auth-input:focus {
  outline: 3px solid var(--accent);
  outline-offset: 2px;
  border-color: var(--accent);
}

.auth-alert {
  padding: 12px 16px;
  border-radius: 8px;
  font-size: 13px;
  background: #fef2f2;
  border: 1px solid #fecaca;
  color: #991b1b;
  margin-bottom: 20px;
}

:root[data-theme="dark"] .auth-alert {
  background: #2d1518;
  border-color: #5c2024;
  color: #fca5a5;
}

.auth-alert ul {
  margin: 0;
  padding-left: 18px;
}

.auth-submit {
  width: 100%;
  min-height: 48px;
  font-size: 14px;
  margin-top: 8px;
}

.auth-footer {
  margin-top: 28px;
  padding-top: 20px;
  border-top: 1px solid var(--line);
  text-align: center;
}

.auth-footer a {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  color: var(--muted);
  font-weight: 500;
}

.auth-footer a:hover {
  color: var(--accent);
}

@media (max-width: 480px) {
  .auth-container { padding: 24px 12px; }
  .auth-card { padding: 28px 20px; }
  .auth-title { font-size: 20px; }
}
</style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo RS TK. III Baladhika Husada" class="auth-logo">
            <h1 class="auth-title">Masuk ke Sistem Pengelola</h1>
            <p class="auth-subtitle">Portal administrasi pustaka RS TK. III Baladhika Husada</p>
        </div>

        @if ($errors->any())
            <div class="auth-alert" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('authenticate', [], false) }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input id="email" 
                       type="email" 
                       name="email" 
                       class="auth-input" 
                       value="{{ old('email') }}" 
                       placeholder="rsbaladhikahusada@gmail.com"
                       required 
                       autocomplete="email" 
                       autofocus>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input id="password" 
                       type="password" 
                       name="password" 
                       class="auth-input" 
                       placeholder="Masukkan kata sandi akun"
                       required 
                       autocomplete="current-password">
            </div>

            <button type="submit" class="primary auth-submit">
                Masuk ke Pengelola
            </button>
        </form>

        <div class="auth-footer">
            <a href="{{ route('home') }}">
                <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24"><path d="M19 12H5m7-7-7 7 7 7"/></svg>
                Kembali ke katalog beranda
            </a>
        </div>
    </div>
</div>
@endsection
