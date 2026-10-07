@extends('layouts.portal')

@section('title', 'Pilih Formulir')
@section('brand-title', 'Sistem Pemesanan')
@section('brand-subtitle', 'Perjalanan Dinas & Reservasi')

@section('content')

  <div class="page-head">
    <h1>Pilih Formulir</h1>
    <p>Pilih jenis pengajuan yang ingin diisi. Setiap formulir akan tersimpan otomatis pada basis data dan diteruskan ke admin melalui WhatsApp.</p>
    <div class="rule"></div>
  </div>

  <div class="pick-grid">

    {{-- ══ FORM DINAS ══ --}}
    <a class="pick" href="{{ route('dinas.create') }}">
      <span class="pick-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M9 4h6a1 1 0 0 1 1 1v1h1.5A1.5 1.5 0 0 1 19 7.5v12A1.5 1.5 0 0 1 17.5 21h-11A1.5 1.5 0 0 1 5 19.5v-12A1.5 1.5 0 0 1 6.5 6H8V5a1 1 0 0 1 1-1Z"/>
          <path d="M9 12h6M9 16h4"/>
        </svg>
      </span>

      <h2 class="pick-title">Form Perjalanan Dinas</h2>
      <p class="pick-desc">Pengajuan perjalanan dinas untuk keperluan kantor, lengkap dengan rincian agenda, uang makan, dan biaya perjalanan.</p>

      <ul class="pick-list">
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
          Pra tugas, pasca tugas, uang makan
        </li>
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
          Tarif otomatis per jabatan &amp; wilayah
        </li>
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
          Deteksi wilayah dari nama kota
        </li>
      </ul>

      <span class="pick-cta">
        Buka formulir
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg>
      </span>
    </a>

    {{-- ══ PESAN HOTEL & TIKET ══ --}}
    <a class="pick" href="{{ route('order.input') }}">
      <span class="pick-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M3 21V7.5A1.5 1.5 0 0 1 4.5 6H10v15"/>
          <path d="M10 11h9.5A1.5 1.5 0 0 1 21 12.5V21"/>
          <path d="M2 21h20"/>
          <path d="M6 9.5h1.5M6 13h1.5M6 16.5h1.5"/>
          <path d="M13.5 14.5H15M13.5 18H15"/>
        </svg>
      </span>

      <h2 class="pick-title">Pesan Hotel &amp; Tiket</h2>
      <p class="pick-desc">Pemesanan akomodasi hotel serta tiket pesawat dan kereta untuk keperluan perjalanan.</p>

      <ul class="pick-list">
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
          Reservasi kamar hotel
        </li>
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
          Tiket pesawat — sekali jalan atau PP
        </li>
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
          Tiket kereta antarkota
        </li>
      </ul>

      <span class="pick-cta">
        Buka formulir
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg>
      </span>
    </a>

  </div>

@endsection
