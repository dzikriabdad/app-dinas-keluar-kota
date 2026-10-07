@extends('layouts.portal')

@section('title', 'Login Admin')
@section('brand-title', 'Login Admin')
@section('brand-subtitle', 'PT. Sukun Wartono Indonesia')

@push('styles')
<style>
  .login-wrap{display:flex;justify-content:center}

  .login-card{
    width:100%;max-width:410px;
    background:var(--surface);
    border:1px solid var(--line);
    border-radius:var(--r-lg);
    box-shadow:var(--shadow-card);
    overflow:hidden;
  }

  .login-body{padding:30px 28px 32px}

  .login-title{
    font-size:18px;font-weight:700;letter-spacing:-.2px;
    text-align:center;color:var(--ink);
  }

  .login-sub{
    font-size:12.5px;color:var(--muted);
    text-align:center;margin-top:6px;margin-bottom:24px;
  }

  .alert-error{
    display:flex;align-items:flex-start;gap:11px;
    padding:13px 15px;margin-bottom:18px;
    border:1px solid #f0c2c2;
    border-left:3px solid var(--red);
    border-radius:13px;
    background:linear-gradient(180deg,#fdf4f4,#fbebeb);
    color:var(--red);
    font-size:12.5px;font-weight:500;line-height:1.6;
  }

  .login-links{
    margin-top:20px;
    padding-top:18px;
    border-top:1px solid var(--line-soft);
    text-align:center;
    font-size:12.5px;
    color:var(--muted);
  }

  .login-links a{
    color:var(--navy-700);
    font-weight:600;
    text-decoration:none;
  }

  .login-links a:hover{text-decoration:underline}

  .login-card .submit{margin-top:8px}
</style>
@endpush

@section('content')

  <div class="login-wrap">
    <div class="login-card">
      <div class="login-body">

        <h1 class="login-title">Login Admin</h1>
        <p class="login-sub">Masuk untuk mengelola rekapitulasi dinas</p>

        @if(session('error'))
          <div class="alert-error" role="alert">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
              <circle cx="12" cy="12" r="9"/>
              <path d="M12 8v4.5M12 16h.01"/>
            </svg>
            <span>{{ session('error') }}</span>
          </div>
        @endif

        <form action="{{ route('admin.proses_login') }}" method="POST">
          @csrf

          <div class="field">
            <label for="email">Email Akses</label>
            <input type="email"
                   id="email"
                   name="email"
                   placeholder="admin@sukun.com"
                   autocomplete="username"
                   required>
          </div>

          <div class="field">
            <label for="password">Password</label>
            <input type="password"
                   id="password"
                   name="password"
                   placeholder="Masukkan password"
                   autocomplete="current-password"
                   required>
          </div>

          <button type="submit" class="submit">
            <span class="btn-text">Masuk</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M5 12h13M13 6l6 6-6 6"/>
            </svg>
          </button>
        </form>

        <div class="login-links">
          <a href="{{ url('/') }}">Kembali ke form utama</a>
        </div>

      </div>
    </div>
  </div>

@endsection
