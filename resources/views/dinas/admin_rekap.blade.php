@extends('layouts.portal')

@section('title', 'Rekap Dinas — Admin')
@section('brand-title', 'Rekapitulasi Dinas')
@section('brand-subtitle', 'Panel Administrator')
@section('page-class', 'page-wide')

@section('topbar-action')
  <a class="topbar-back" href="{{ route('admin.logout') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="M15 17l5-5-5-5M20 12H9"/>
      <path d="M12 20H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h6"/>
    </svg>
    <span>Logout</span>
  </a>
@endsection

@push('styles')
<style>
  /* ── Alert sukses ── */
  .alert-ok{
    display:flex;align-items:flex-start;gap:11px;
    padding:14px 16px;margin-bottom:18px;
    border:1px solid #b8e0c8;
    border-left:3px solid var(--green);
    border-radius:13px;
    background:linear-gradient(180deg,#f2fbf6,#eaf7f0);
    color:var(--green);
    font-size:12.5px;font-weight:500;line-height:1.6;
  }
  .alert-ok svg{width:16px;height:16px;flex-shrink:0;margin-top:2px}

  /* ── Badge jenis form ── */
  .badge{
    display:inline-block;
    padding:5px 11px;
    border-radius:999px;
    border:1px solid var(--line);
    background:#eef3fa;
    color:var(--navy-800);
    font-size:10.5px;font-weight:700;
    letter-spacing:.6px;text-transform:uppercase;
    white-space:nowrap;
  }

  /* ── Sel aksi ── */
  .cell-aksi{display:flex;gap:8px;flex-wrap:nowrap}
  .cell-aksi > a.btn,
  .cell-aksi > form{flex:1;min-width:0}
  .cell-aksi form{margin:0;display:flex}
  .cell-aksi form .btn{width:100%}

  .cell-center{text-align:center}

  .empty-state{
    text-align:center !important;
    padding:34px 14px !important;
    color:var(--muted) !important;
    font-weight:500;
  }
</style>
@endpush

@section('content')

  <div class="page-head">
    <h1>Rekapitulasi Dinas Keluar Kota</h1>
    <p>Daftar seluruh pengajuan dinas yang tersimpan. Tombol cetak membuka dokumen A4 siap print pada tab baru.</p>
    <div class="rule"></div>
  </div>

  @if(session('success'))
    <div class="alert-ok" role="status">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M20 6 9 17l-5-5"/>
      </svg>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <div class="btn-row" style="margin-top:0;margin-bottom:18px">
    <a class="btn btn-navy" href="{{ route('dinas.create') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M12 5v14M5 12h14"/>
      </svg>
      Buat Form Baru
    </a>

    <a class="btn" href="{{ route('admin.export') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M12 3v12M7.5 10.5 12 15l4.5-4.5"/>
        <path d="M4 19h16"/>
      </svg>
      Download Excel (CSV)
    </a>
  </div>

  <div class="table-wrap">
    <div class="table-scroll">
      <table class="table">
        <thead>
          <tr>
            <th style="width:5%">No</th>
            <th style="width:17%">Nama Pegawai</th>
            <th style="width:16%">Jabatan</th>
            <th style="width:14%">Kota Tujuan</th>
            <th style="width:15%">Tanggal Pelaksanaan</th>
            <th style="width:13%">Jenis Form</th>
            <th style="width:20%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($dataDinas as $key => $d)
            <tr>
              <td class="cell-center">{{ $key + 1 }}</td>

              <td>
                <span style="font-weight:600;color:var(--ink)">{{ $d->nama }}</span>
              </td>

              <td>{{ $d->divisi }} — {{ $d->jabatan }}</td>

              <td>{{ $d->kota_tujuan }}</td>

              <td>{{ $d->tanggal_dokumen }}</td>

              <td class="cell-center">
                <span class="badge">{{ strtoupper(str_replace('_', ' ', $d->jenis_form)) }}</span>
              </td>

              <td>
                <div class="cell-aksi">
                  <a class="btn btn-sm btn-navy"
                     href="{{ route('admin.cetak', $d->id) }}"
                     target="_blank"
                     rel="noopener">
                    Cetak
                  </a>

                  <form action="{{ route('admin.hapus', $d->id) }}"
                        method="POST"
                        data-nama="{{ $d->nama }}"
                        onsubmit="return confirm('Yakin ingin menghapus form milik ' + this.dataset.nama + '?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="empty-state">Belum ada data dinas yang tersimpan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

@endsection
