<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Sistem Pemesanan')</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endif

@stack('styles')
</head>
<body>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<header class="topbar">
  <div class="topbar-inner">
    <a class="brand" href="{{ url('/') }}">
      <span class="brand-mark">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="9"/>
          <path d="m15.5 8.5-2 5-5 2 2-5z"/>
        </svg>
      </span>
      <span class="brand-text">
        <strong>@yield('brand-title', 'Sistem Pemesanan')</strong>
        <small>@yield('brand-subtitle', 'Perjalanan Dinas & Reservasi')</small>
      </span>
    </a>

    @hasSection('topbar-action')
      @yield('topbar-action')
    @else
      <span class="topbar-tag">Internal</span>
    @endif
  </div>
</header>

<main class="page @yield('page-class')">
  @yield('content')

  <div class="page-footer">
    © {{ date('Y') }} IT PT. Sukun Wartono Indonesia
  </div>
</main>

@stack('modals')
@stack('scripts')

</body>
</html>
