@extends('layouts.portal')

@section('title', 'Pesan Hotel & Tiket')
@section('brand-title', 'Pesan Hotel & Tiket')
@section('brand-subtitle', 'Sistem Pemesanan Internal')

@section('topbar-action')
  <a class="topbar-back" href="{{ route('home') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
    <span>Menu utama</span>
  </a>
@endsection

@section('content')

  <div class="page-head">
    <h1>Formulir Pemesanan</h1>
    <p>Lengkapi data di bawah ini. Data akan tersimpan otomatis pada basis data pemesanan dan diteruskan ke admin melalui WhatsApp.</p>
    <div class="rule"></div>
  </div>

  <div class="card">

    <div class="tabs" role="tablist">
      <button type="button" class="tab active" data-tab="hotel" role="tab" aria-selected="true" onclick="switchTab('hotel')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M3 20v-6.5A1.5 1.5 0 0 1 4.5 12h15A1.5 1.5 0 0 1 21 13.5V20"/>
          <path d="M3 20h18"/>
          <path d="M7 12V9.5A1.5 1.5 0 0 1 8.5 8h3v4"/>
          <path d="M11.5 12V8H16a1.5 1.5 0 0 1 1.5 1.5V12"/>
        </svg>
        <span>Hotel</span>
      </button>

      <button type="button" class="tab" data-tab="pesawat" role="tab" aria-selected="false" onclick="switchTab('pesawat')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M12 3.2 13 9l6.5 3.2v1.6L13 12.4v4.2l2.2 1.7v1.4L12 18.8l-3.2.9v-1.4l2.2-1.7v-4.2L4.5 13.8v-1.6L11 9z"/>
        </svg>
        <span>Pesawat</span>
      </button>

      <button type="button" class="tab" data-tab="kereta" role="tab" aria-selected="false" onclick="switchTab('kereta')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="5" y="3" width="14" height="13" rx="3"/>
          <path d="M5 10h14"/>
          <path d="M9.5 13h.01M14.5 13h.01"/>
          <path d="M8.5 16 6.5 20M15.5 16l2 4M9.5 20h5"/>
        </svg>
        <span>Kereta</span>
      </button>
    </div>

    <div class="form-body">

      {{-- ══════════ HOTEL ══════════ --}}
      <form id="formHotel" class="form-section active" onsubmit="return false;">
        <div class="legend"><span class="legend-num">1</span>Data Kamar</div>

        <div class="field">
          <label for="h-nama">Nama Tamu</label>
          <input type="text" id="h-nama" name="nama" placeholder="Nama lengkap tamu" required>
        </div>

        <div class="field">
          <label for="h-bed">Type Bed</label>
          <select id="h-bed" name="type_bed" required>
            <option value="Double Bed (1 ranjang besar)">Double Bed (1 ranjang besar)</option>
            <option value="Twin Bed (2 ranjang single)">Twin Bed (2 ranjang single)</option>
          </select>
        </div>

        <div class="grid-2">
          <div class="field">
            <label for="h-in">Tanggal Check-in</label>
            <input type="date" id="h-in" name="tgl_in" required>
          </div>
          <div class="field">
            <label for="h-out">Tanggal Check-out</label>
            <input type="date" id="h-out" name="tgl_out" required>
          </div>
        </div>

        <div class="field">
          <label for="h-kota">Kota</label>
          <input type="text" id="h-kota" name="kota" placeholder="Contoh: Yogyakarta" required>
        </div>

        <div class="field">
          <label for="mapsInput">Detail Venue <span class="hint">(opsional)</span></label>
          <div class="venue-row">
            <input type="text" id="mapsInput" name="maps" placeholder="Nama venue atau tautan Google Maps" oninput="onMapsInput(this.value)">
            <button type="button" class="attach-btn" id="mapsAttachBtn" onclick="toggleMapsAttach()">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M21.4 11.05 12.25 20.2a5.5 5.5 0 0 1-7.78-7.78l8.49-8.49a3.7 3.7 0 0 1 5.23 5.23l-8.49 8.49a1.85 1.85 0 0 1-2.62-2.62l7.43-7.43"/>
              </svg>
              <span id="mapsAttachLabel">Terlampir</span>
            </button>
          </div>

          <div class="note note-warn note-venue" id="mapsReminder">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
              <circle cx="12" cy="12" r="9"/><path d="M12 8v4.5M12 16h.01"/>
            </svg>
            <span>Detail venue belum diisi. Setelah chat WhatsApp terbuka, kirimkan detail venue kepada admin.</span>
          </div>
        </div>

        <div class="field">
          <label for="h-rek">Rekomendasi Hotel <span class="hint">(opsional)</span></label>
          <input type="text" id="h-rek" name="rekomendasi" placeholder="Nama hotel jika ada preferensi">
        </div>

        <div class="field">
          <label for="h-cat">Catatan <span class="hint">(opsional)</span></label>
          <textarea id="h-cat" name="catatan_hotel" rows="3" placeholder="Catatan tambahan untuk admin"></textarea>
        </div>

        <div class="note note-info">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
            <circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8h.01"/>
          </svg>
          <span><strong>Perhatian</strong>Pastikan tanggal check-in dan check-out sudah benar sebelum pesanan dikirim.</span>
        </div>

        <hr class="divider">
        <div class="legend"><span class="legend-num">2</span>Kontak Pemesan</div>

        <div class="grid-2">
          <div class="field">
            <label for="h-hp">No HP / WhatsApp</label>
            <input type="tel" id="h-hp" name="hp" placeholder="08xxxxxxxxxx" required>
          </div>
          <div class="field">
            <label for="h-email">Email</label>
            <input type="email" id="h-email" name="email" placeholder="nama@email.com" required>
          </div>
        </div>

        <button type="button" class="submit" onclick="showConfirm('hotel')">
          <span class="spinner"></span>
          <span class="btn-text">Kirim Pesanan Hotel</span>
          <svg class="submit-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M5 12h13M13 6l6 6-6 6"/>
          </svg>
        </button>
      </form>

      {{-- ══════════ PESAWAT ══════════ --}}
      <form id="formPesawat" class="form-section" onsubmit="return false;">
        <div class="legend"><span class="legend-num">1</span>Data Penerbangan</div>

        <div class="trip-row">
          <span class="trip-label">Tipe Perjalanan</span>
          <div class="seg">
            <button type="button" class="selected" id="pesawatBtnSekali" onclick="setPP('pesawat','sekali')">Sekali Jalan</button>
            <button type="button" id="pesawatBtnPP" onclick="setPP('pesawat','pp')">Pulang Pergi</button>
          </div>
        </div>

        <div class="grid-2">
          <div class="field">
            <label for="p-berangkat">Tanggal Berangkat</label>
            <input type="date" id="p-berangkat" name="tgl_berangkat" required>
          </div>
          <div class="field pulang-field" id="pesawatPulangField">
            <label for="p-pulang">Tanggal Pulang</label>
            <input type="date" id="p-pulang" name="tgl_pulang">
          </div>
        </div>

        <div class="grid-2">
          <div class="field">
            <label for="p-asal">Dari Kota</label>
            <input type="text" id="p-asal" name="kota_asal" placeholder="Contoh: Bali" required>
          </div>
          <div class="field">
            <label for="p-tujuan">Ke Kota</label>
            <input type="text" id="p-tujuan" name="kota_tujuan" placeholder="Contoh: Semarang" required>
          </div>
        </div>

        <div class="field">
          <label>Waktu Berangkat</label>
          <div class="choice-grid">
            <button type="button" class="choice" onclick="selectTime('pesawat','Dini Hari (00:00 - 06:00)',this)">
              <div class="c-title">Dini Hari</div><div class="c-time">00:00 – 06:00</div>
            </button>
            <button type="button" class="choice" onclick="selectTime('pesawat','Pagi (06:00 - 12:00)',this)">
              <div class="c-title">Pagi</div><div class="c-time">06:00 – 12:00</div>
            </button>
            <button type="button" class="choice" onclick="selectTime('pesawat','Siang (12:00 - 18:00)',this)">
              <div class="c-title">Siang</div><div class="c-time">12:00 – 18:00</div>
            </button>
            <button type="button" class="choice" onclick="selectTime('pesawat','Malam (18:00 - 24:00)',this)">
              <div class="c-title">Malam</div><div class="c-time">18:00 – 24:00</div>
            </button>
          </div>
          <input type="hidden" name="waktu_berangkat" id="pesawatWaktu">
        </div>

        <hr class="divider">
        <div class="legend"><span class="legend-num">2</span>Data Penumpang</div>

        <div class="field">
          <label for="p-nama">Nama Sesuai KTP</label>
          <input type="text" id="p-nama" name="nama_penumpang" placeholder="Contoh: Bryan Utomo" required>
        </div>

        <div class="grid-2">
          <div class="field" id="fieldNikPesawat">
            <label for="inputNikPesawat">NIK KTP <span class="hint">(16 digit)</span></label>
            <input type="text" id="inputNikPesawat" name="nik" placeholder="16 digit NIK" maxlength="16"
                   inputmode="numeric" autocomplete="off"
                   oninput="this.value=this.value.replace(/\D/g,'').slice(0,16);validateNik('pesawat');"
                   onblur="validateNik('pesawat')" required>
            <div class="error-msg" id="nikErrorPesawat">NIK harus tepat 16 digit angka</div>
          </div>
          <div class="field">
            <label for="p-unit">Unit / Kantor Perwakilan</label>
            <input type="text" id="p-unit" name="perwakilan" placeholder="Contoh: Kantor Bali" required>
          </div>
        </div>

        <div class="grid-2">
          <div class="field">
            <label for="p-hp">No HP</label>
            <input type="tel" id="p-hp" name="hp_tkt" placeholder="08xxxxxxxxxx" required>
          </div>
          <div class="field">
            <label for="p-email">Email</label>
            <input type="email" id="p-email" name="email_tkt" placeholder="nama@email.com" required>
          </div>
        </div>

        <div class="field">
          <label for="p-acara">Acara / Keperluan</label>
          <input type="text" id="p-acara" name="acara" placeholder="Contoh: Training Team Leader Distribusi" required>
        </div>

        <div class="field">
          <label for="p-cat">Catatan <span class="hint">(opsional)</span></label>
          <textarea id="p-cat" name="catatan_tkt" rows="2" placeholder="Catatan tambahan untuk admin"></textarea>
        </div>

        <div class="note note-warn note-block">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
            <circle cx="12" cy="12" r="9"/><path d="M12 8v4.5M12 16h.01"/>
          </svg>
          <span><strong>Kelengkapan berkas</strong>Setelah formulir dikirim, lampirkan foto KTP penumpang pada chat WhatsApp yang terbuka. Pesanan tidak dapat diproses tanpa KTP yang sesuai.</span>
        </div>

        <div class="check">
          <input type="checkbox" id="setujuKtpPesawat" required>
          <label for="setujuKtpPesawat">Saya bersedia melampirkan foto KTP penumpang pada chat WhatsApp setelah formulir ini dikirim.</label>
        </div>

        <button type="button" class="submit" onclick="showConfirm('pesawat')">
          <span class="spinner"></span>
          <span class="btn-text">Kirim Pesanan Tiket Pesawat</span>
          <svg class="submit-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M5 12h13M13 6l6 6-6 6"/>
          </svg>
        </button>
      </form>

      {{-- ══════════ KERETA ══════════ --}}
      <form id="formKereta" class="form-section" onsubmit="return false;">
        <div class="legend"><span class="legend-num">1</span>Data Perjalanan</div>

        <div class="trip-row">
          <span class="trip-label">Tipe Perjalanan</span>
          <div class="seg">
            <button type="button" class="selected" id="keretaBtnSekali" onclick="setPP('kereta','sekali')">Sekali Jalan</button>
            <button type="button" id="keretaBtnPP" onclick="setPP('kereta','pp')">Pulang Pergi</button>
          </div>
        </div>

        <div class="grid-2">
          <div class="field">
            <label for="k-berangkat">Tanggal Berangkat</label>
            <input type="date" id="k-berangkat" name="tgl_berangkat_krt" required>
          </div>
          <div class="field pulang-field" id="keretaPulangField">
            <label for="k-pulang">Tanggal Pulang</label>
            <input type="date" id="k-pulang" name="tgl_pulang_krt">
          </div>
        </div>

        <div class="grid-2">
          <div class="field">
            <label for="k-asal">Dari Kota / Stasiun</label>
            <input type="text" id="k-asal" name="stasiun_asal" placeholder="Contoh: Stasiun Gambir, Jakarta" required>
          </div>
          <div class="field">
            <label for="k-tujuan">Ke Kota / Stasiun</label>
            <input type="text" id="k-tujuan" name="stasiun_tujuan" placeholder="Contoh: Stasiun Tugu, Yogyakarta" required>
          </div>
        </div>

        <div class="field">
          <label>Waktu Berangkat</label>
          <div class="choice-grid">
            <button type="button" class="choice" onclick="selectTime('kereta','Dini Hari (00:00 - 06:00)',this)">
              <div class="c-title">Dini Hari</div><div class="c-time">00:00 – 06:00</div>
            </button>
            <button type="button" class="choice" onclick="selectTime('kereta','Pagi (06:00 - 12:00)',this)">
              <div class="c-title">Pagi</div><div class="c-time">06:00 – 12:00</div>
            </button>
            <button type="button" class="choice" onclick="selectTime('kereta','Siang (12:00 - 18:00)',this)">
              <div class="c-title">Siang</div><div class="c-time">12:00 – 18:00</div>
            </button>
            <button type="button" class="choice" onclick="selectTime('kereta','Malam (18:00 - 24:00)',this)">
              <div class="c-title">Malam</div><div class="c-time">18:00 – 24:00</div>
            </button>
          </div>
          <input type="hidden" name="waktu_berangkat_krt" id="keretaWaktu">
        </div>

        <hr class="divider">
        <div class="legend"><span class="legend-num">2</span>Data Penumpang</div>

        <div class="field">
          <label for="k-nama">Nama Sesuai KTP</label>
          <input type="text" id="k-nama" name="nama_penumpang_krt" placeholder="Contoh: Bryan Utomo" required>
        </div>

        <div class="grid-2">
          <div class="field" id="fieldNikKereta">
            <label for="inputNikKereta">NIK KTP <span class="hint">(16 digit)</span></label>
            <input type="text" id="inputNikKereta" name="nik_krt" placeholder="16 digit NIK" maxlength="16"
                   inputmode="numeric" autocomplete="off"
                   oninput="this.value=this.value.replace(/\D/g,'').slice(0,16);validateNik('kereta');"
                   onblur="validateNik('kereta')" required>
            <div class="error-msg" id="nikErrorKereta">NIK harus tepat 16 digit angka</div>
          </div>
          <div class="field">
            <label for="k-unit">Unit / Kantor Perwakilan</label>
            <input type="text" id="k-unit" name="perwakilan_krt" placeholder="Contoh: Kantor Bali" required>
          </div>
        </div>

        <div class="grid-2">
          <div class="field">
            <label for="k-hp">No HP</label>
            <input type="tel" id="k-hp" name="hp_krt" placeholder="08xxxxxxxxxx" required>
          </div>
          <div class="field">
            <label for="k-email">Email</label>
            <input type="email" id="k-email" name="email_krt" placeholder="nama@email.com" required>
          </div>
        </div>

        <div class="field">
          <label for="k-acara">Acara / Keperluan</label>
          <input type="text" id="k-acara" name="acara_krt" placeholder="Contoh: Training Team Leader Distribusi" required>
        </div>

        <div class="field">
          <label for="k-cat">Catatan <span class="hint">(opsional)</span></label>
          <textarea id="k-cat" name="catatan_krt" rows="2" placeholder="Catatan tambahan untuk admin"></textarea>
        </div>

        <div class="note note-warn note-block">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
            <circle cx="12" cy="12" r="9"/><path d="M12 8v4.5M12 16h.01"/>
          </svg>
          <span><strong>Kelengkapan berkas</strong>Setelah formulir dikirim, lampirkan foto KTP penumpang pada chat WhatsApp yang terbuka. Pesanan tidak dapat diproses tanpa KTP yang sesuai.</span>
        </div>

        <div class="check">
          <input type="checkbox" id="setujuKtpKereta" required>
          <label for="setujuKtpKereta">Saya bersedia melampirkan foto KTP penumpang pada chat WhatsApp setelah formulir ini dikirim.</label>
        </div>

        <button type="button" class="submit" onclick="showConfirm('kereta')">
          <span class="spinner"></span>
          <span class="btn-text">Kirim Pesanan Tiket Kereta</span>
          <svg class="submit-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M5 12h13M13 6l6 6-6 6"/>
          </svg>
        </button>
      </form>

    </div>
  </div>

@endsection

@push('modals')
<div class="overlay" id="confirmModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
  <div class="modal">
    <div class="modal-head">
      <span class="m-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M9 4h6a1 1 0 0 1 1 1v1h2a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h2V5a1 1 0 0 1 1-1Z"/>
          <path d="M9 12h6M9 16h4"/>
        </svg>
      </span>
      <div>
        <h3 id="modalTitle">Konfirmasi Data</h3>
        <p>Periksa kembali seluruh data sebelum dikirim</p>
      </div>
    </div>

    <div class="modal-body" id="modalBody"></div>

    <div class="modal-foot">
      <button type="button" class="btn-secondary" onclick="closeConfirm()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M19 12H5M11 18l-6-6 6-6"/>
        </svg>
        Kembali Edit
      </button>
      <button type="button" class="btn-primary" onclick="confirmSubmit()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M20 12a8 8 0 0 1-11.7 7.1L4 20l1-4.2A8 8 0 1 1 20 12Z"/>
        </svg>
        Kirim via WhatsApp
      </button>
    </div>
  </div>
</div>
@endpush

@push('scripts')
<script>
  /* ══════════════════════════════════════════════
     KONFIGURASI
     Nomor admin disimpan ter-encode (Base64) agar
     tidak terbaca langsung pada source code.
  ══════════════════════════════════════════════ */
  const ENDPOINT = 'https://script.google.com/macros/s/AKfycbyjghE0dzXbcXhNsj5DHYmsjYuNcNAhmIuSUOVriE9NK3f0DWAJ783Q4gajXkjNyR76gw/exec';

  function getAdminWa() {
    return atob('NjI4NTY0MTExMDA5Mg==');
  }

  const HARI  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
  const BULAN = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

  function formatDate(iso) {
    if (!iso) return '-';
    const d = new Date(iso + 'T00:00:00');
    return HARI[d.getDay()] + ', ' + d.getDate() + ' ' + BULAN[d.getMonth()] + ' ' + d.getFullYear();
  }

  function esc(s) {
    if (s === undefined || s === null || s === '') return '-';
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  function showToast(msg, type) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = 'toast ' + (type || 'success');
    void t.offsetWidth;
    t.classList.add('show');
    setTimeout(function(){ t.classList.remove('show'); }, 3500);
  }

  /* ── NAVIGASI TAB ── */
  function switchTab(type) {
    document.querySelectorAll('.tab').forEach(function(btn){
      const on = btn.dataset.tab === type;
      btn.classList.toggle('active', on);
      btn.setAttribute('aria-selected', on ? 'true' : 'false');
    });
    document.querySelectorAll('.form-section').forEach(function(sec){
      sec.classList.remove('active');
    });
    document.getElementById('form' + type.charAt(0).toUpperCase() + type.slice(1)).classList.add('active');
  }

  /* ── PILIH RENTANG WAKTU ── */
  function selectTime(form, val, el) {
    el.closest('.choice-grid').querySelectorAll('.choice').forEach(function(b){
      b.classList.remove('selected');
    });
    el.classList.add('selected');
    document.getElementById(form + 'Waktu').value = val;
  }

  /* ── TIPE PERJALANAN (PP / SEKALI JALAN) ── */
  const ppState = { pesawat: 'sekali', kereta: 'sekali' };

  function setPP(form, val) {
    ppState[form] = val;

    document.getElementById(form + 'BtnSekali').classList.toggle('selected', val === 'sekali');
    document.getElementById(form + 'BtnPP').classList.toggle('selected', val === 'pp');

    const wrap  = document.getElementById(form + 'PulangField');
    const input = wrap.querySelector('input');

    if (val === 'pp') {
      wrap.classList.add('show');
      input.required = true;
    } else {
      wrap.classList.remove('show');
      input.required = false;
      input.value = '';
    }
  }

  /* ── DETAIL VENUE TERLAMPIR ── */
  let mapsAttached = false;

  function onMapsInput(val) {
    if (mapsAttached && val !== 'Terlampir') {
      mapsAttached = false;
      document.getElementById('mapsAttachBtn').classList.remove('selected');
      document.getElementById('mapsAttachLabel').textContent = 'Terlampir';
      document.getElementById('mapsReminder').classList.remove('show');
    }
  }

  function toggleMapsAttach() {
    mapsAttached = !mapsAttached;

    const btn      = document.getElementById('mapsAttachBtn');
    const label    = document.getElementById('mapsAttachLabel');
    const input    = document.getElementById('mapsInput');
    const reminder = document.getElementById('mapsReminder');

    if (mapsAttached) {
      btn.classList.add('selected');
      label.textContent = 'Terlampir';
      input.value = 'Terlampir';
      input.disabled = false;
      reminder.classList.add('show');
    } else {
      btn.classList.remove('selected');
      label.textContent = 'Terlampir';
      input.value = '';
      input.disabled = false;
      reminder.classList.remove('show');
    }
  }

  /* ── VALIDASI NIK ── */
  function validateNik(form) {
    const inp = document.getElementById(form === 'pesawat' ? 'inputNikPesawat' : 'inputNikKereta');
    const fld = document.getElementById(form === 'pesawat' ? 'fieldNikPesawat' : 'fieldNikKereta');
    const val = inp.value.trim();

    if (val.length > 0 && val.length !== 16) {
      fld.classList.add('error');
      return false;
    }
    fld.classList.remove('error');
    return val.length === 16;
  }

  /* ── PENGAMBILAN DATA FORMULIR ── */
  function collectData(jenis) {
    const formId = 'form' + jenis.charAt(0).toUpperCase() + jenis.slice(1);

    function get(name) {
      const el = document.querySelector('#' + formId + ' [name="' + name + '"]');
      return el ? el.value : '';
    }

    if (jenis === 'hotel') {
      return {
        jenis:         'hotel',
        nama:          get('nama'),
        type_bed:      get('type_bed'),
        tgl_in:        get('tgl_in'),
        tgl_out:       get('tgl_out'),
        kota:          get('kota'),
        maps:          get('maps'),
        rekomendasi:   get('rekomendasi'),
        catatan_hotel: get('catatan_hotel'),
        hp:            get('hp'),
        email:         get('email')
      };
    }

    if (jenis === 'pesawat') {
      return {
        jenis:           'pesawat',
        tipe_perjalanan: ppState.pesawat === 'pp' ? 'PP (Pulang Pergi)' : 'Sekali Jalan',
        tgl_berangkat:   get('tgl_berangkat'),
        tgl_pulang:      get('tgl_pulang'),
        kota_asal:       get('kota_asal'),
        kota_tujuan:     get('kota_tujuan'),
        waktu_berangkat: get('waktu_berangkat'),
        nama_penumpang:  get('nama_penumpang'),
        nik:             get('nik'),
        perwakilan:      get('perwakilan'),
        hp_tkt:          get('hp_tkt'),
        email_tkt:       get('email_tkt'),
        acara:           get('acara'),
        catatan_tkt:     get('catatan_tkt')
      };
    }

    return {
      jenis:               'kereta',
      tipe_perjalanan_krt: ppState.kereta === 'pp' ? 'PP (Pulang Pergi)' : 'Sekali Jalan',
      tgl_berangkat_krt:   get('tgl_berangkat_krt'),
      tgl_pulang_krt:      get('tgl_pulang_krt'),
      stasiun_asal:        get('stasiun_asal'),
      stasiun_tujuan:      get('stasiun_tujuan'),
      waktu_berangkat_krt: get('waktu_berangkat_krt'),
      nama_penumpang_krt:  get('nama_penumpang_krt'),
      nik_krt:             get('nik_krt'),
      perwakilan_krt:      get('perwakilan_krt'),
      hp_krt:              get('hp_krt'),
      email_krt:           get('email_krt'),
      acara_krt:           get('acara_krt'),
      catatan_krt:         get('catatan_krt')
    };
  }

  /* ── BARIS REVIEW MODAL ── */
  function ri(label, val) {
    return '<div class="rev-row">' +
             '<span class="rev-label">' + label + '</span>' +
             '<span class="rev-value">' + esc(val) + '</span>' +
           '</div>';
  }

  const NOTE_ICON =
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">' +
    '<circle cx="12" cy="12" r="9"/><path d="M12 8v4.5M12 16h.01"/></svg>';

  /* ══════════════════════════════════════════════
     PENYUSUNAN PESAN WHATSAPP
  ══════════════════════════════════════════════ */
  function buildHotelMsg(d) {
    const nl = '\n';
    const venue = d.maps || '-';
    const isTerlampir = (venue === 'Terlampir');

    let msg = '*Form Pemesanan Hotel*' + nl + nl;
    msg += 'Nama tamu : ' + (d.nama || '-') + nl;
    msg += 'Type bed :' + nl + '  - ' + (d.type_bed || '-') + nl;
    msg += 'Tanggal check-in : ' + formatDate(d.tgl_in) + nl;
    msg += 'Tanggal check-out : ' + formatDate(d.tgl_out) + nl;
    msg += 'Kota : ' + (d.kota || '-') + nl;
    msg += 'Detail venue : ' + venue + nl;
    msg += 'Rekomendasi hotel : ' + (d.rekomendasi || '-') + nl;
    msg += 'Catatan : ' + (d.catatan_hotel || '-') + nl + nl;
    msg += 'Kontak pemesan' + nl;
    msg += 'No HP : ' + (d.hp || '-') + nl;
    msg += 'Email : ' + (d.email || '-');

    if (isTerlampir) {
      msg += nl + nl + 'Detail venue akan dikirim menyusul pada chat ini.';
    }
    return msg;
  }

  function buildPesawatMsg(d) {
    const nl = '\n';
    const isPP = (d.tipe_perjalanan === 'PP (Pulang Pergi)');

    let msg = '*Form Pemesanan Tiket Pesawat' + (isPP ? ' (PP)' : ' (Sekali Jalan)') + '*' + nl + nl;
    msg += 'Tanggal berangkat : ' + formatDate(d.tgl_berangkat) + nl;
    if (isPP) msg += 'Tanggal pulang : ' + formatDate(d.tgl_pulang) + nl;
    msg += 'Dari kota : ' + (d.kota_asal || '-') + nl;
    msg += 'Ke kota : ' + (d.kota_tujuan || '-') + nl;
    msg += 'Waktu berangkat : ' + (d.waktu_berangkat || '-') + nl + nl;
    msg += 'Data penumpang' + nl;
    msg += 'Nama sesuai KTP : ' + (d.nama_penumpang || '-') + nl;
    msg += 'NIK KTP : ' + (d.nik || '-') + nl;
    msg += 'Unit / Kantor perwakilan : ' + (d.perwakilan || '-') + nl;
    msg += 'No HP : ' + (d.hp_tkt || '-') + nl;
    msg += 'Email : ' + (d.email_tkt || '-') + nl;
    msg += 'Acara : ' + (d.acara || '-') + nl;
    msg += 'Catatan : ' + (d.catatan_tkt || '-') + nl + nl;
    msg += 'Mohon lampirkan foto KTP penumpang pada chat ini.';

    return msg;
  }

  function buildKeretaMsg(d) {
    const nl = '\n';
    const isPP = (d.tipe_perjalanan_krt === 'PP (Pulang Pergi)');

    let msg = '*Form Pemesanan Tiket Kereta' + (isPP ? ' (PP)' : ' (Sekali Jalan)') + '*' + nl + nl;
    msg += 'Tanggal berangkat : ' + formatDate(d.tgl_berangkat_krt) + nl;
    if (isPP) msg += 'Tanggal pulang : ' + formatDate(d.tgl_pulang_krt) + nl;
    msg += 'Dari stasiun : ' + (d.stasiun_asal || '-') + nl;
    msg += 'Ke stasiun : ' + (d.stasiun_tujuan || '-') + nl;
    msg += 'Waktu berangkat : ' + (d.waktu_berangkat_krt || '-') + nl + nl;
    msg += 'Data penumpang' + nl;
    msg += 'Nama sesuai KTP : ' + (d.nama_penumpang_krt || '-') + nl;
    msg += 'NIK KTP : ' + (d.nik_krt || '-') + nl;
    msg += 'Unit / Kantor perwakilan : ' + (d.perwakilan_krt || '-') + nl;
    msg += 'No HP : ' + (d.hp_krt || '-') + nl;
    msg += 'Email : ' + (d.email_krt || '-') + nl;
    msg += 'Acara : ' + (d.acara_krt || '-') + nl;
    msg += 'Catatan : ' + (d.catatan_krt || '-') + nl + nl;
    msg += 'Mohon lampirkan foto KTP penumpang pada chat ini.';

    return msg;
  }

  /* ══════════════════════════════════════════════
     MODAL KONFIRMASI
  ══════════════════════════════════════════════ */
  let currentJenis = '';

  function showConfirm(jenis) {
    currentJenis = jenis;

    if (jenis === 'pesawat') {
      if (!validateNik('pesawat')) {
        showToast('NIK KTP harus tepat 16 digit angka.', 'error');
        document.getElementById('inputNikPesawat').focus();
        return;
      }
      if (!document.getElementById('setujuKtpPesawat').checked) {
        showToast('Persetujuan lampiran KTP belum dicentang.', 'error');
        return;
      }
    }

    if (jenis === 'kereta') {
      if (!validateNik('kereta')) {
        showToast('NIK KTP harus tepat 16 digit angka.', 'error');
        document.getElementById('inputNikKereta').focus();
        return;
      }
      if (!document.getElementById('setujuKtpKereta').checked) {
        showToast('Persetujuan lampiran KTP belum dicentang.', 'error');
        return;
      }
    }

    const formId = { hotel: 'formHotel', pesawat: 'formPesawat', kereta: 'formKereta' }[jenis];
    const formEl = document.getElementById(formId);

    if (!formEl.checkValidity()) {
      formEl.reportValidity();
      return;
    }

    const d     = collectData(jenis);
    const body  = document.getElementById('modalBody');
    const title = document.getElementById('modalTitle');

    if (jenis === 'hotel') {
      title.textContent = 'Konfirmasi Pesanan Hotel';
      body.innerHTML =
        '<div class="rev-block">' +
          '<div class="rev-title">Data Kamar</div>' +
          ri('Nama Tamu', d.nama) +
          ri('Type Bed', d.type_bed) +
          ri('Check-in', formatDate(d.tgl_in)) +
          ri('Check-out', formatDate(d.tgl_out)) +
          ri('Kota', d.kota) +
          ri('Detail Venue', d.maps || '-') +
          ri('Rekomendasi Hotel', d.rekomendasi || '-') +
          ri('Catatan', d.catatan_hotel || '-') +
        '</div>' +
        '<div class="rev-block">' +
          '<div class="rev-title">Kontak Pemesan</div>' +
          ri('No HP', d.hp) +
          ri('Email', d.email) +
        '</div>' +
        (d.maps === 'Terlampir'
          ? '<div class="rev-note">' + NOTE_ICON +
            '<span>Detail Venue ditandai <b>Terlampir</b>. Kirimkan detail venue pada chat WhatsApp setelah formulir dikirim.</span></div>'
          : '') +
        '<div class="rev-note">' + NOTE_ICON +
          '<span>Pastikan seluruh data sudah benar sebelum dikirim ke admin.</span></div>';

    } else if (jenis === 'pesawat') {
      const isPP = ppState.pesawat === 'pp';
      title.textContent = 'Konfirmasi Tiket Pesawat';
      body.innerHTML =
        '<div class="rev-block">' +
          '<div class="rev-title">Data Penerbangan</div>' +
          ri('Tipe Perjalanan', isPP ? 'PP (Pulang Pergi)' : 'Sekali Jalan') +
          ri('Tgl Berangkat', formatDate(d.tgl_berangkat)) +
          (isPP ? ri('Tgl Pulang', formatDate(d.tgl_pulang)) : '') +
          ri('Dari Kota', d.kota_asal) +
          ri('Ke Kota', d.kota_tujuan) +
          ri('Waktu Berangkat', d.waktu_berangkat || '-') +
        '</div>' +
        '<div class="rev-block">' +
          '<div class="rev-title">Data Penumpang</div>' +
          ri('Nama Sesuai KTP', d.nama_penumpang) +
          ri('NIK KTP', d.nik) +
          ri('Unit / Kantor Perwakilan', d.perwakilan) +
          ri('No HP', d.hp_tkt) +
          ri('Email', d.email_tkt) +
          ri('Acara', d.acara) +
          ri('Catatan', d.catatan_tkt || '-') +
        '</div>' +
        '<div class="rev-note">' + NOTE_ICON +
          '<span>Setelah dikirim, <b>wajib melampirkan foto KTP</b> penumpang pada chat WhatsApp.</span></div>';

    } else {
      const isPP = ppState.kereta === 'pp';
      title.textContent = 'Konfirmasi Tiket Kereta';
      body.innerHTML =
        '<div class="rev-block">' +
          '<div class="rev-title">Data Perjalanan</div>' +
          ri('Tipe Perjalanan', isPP ? 'PP (Pulang Pergi)' : 'Sekali Jalan') +
          ri('Tgl Berangkat', formatDate(d.tgl_berangkat_krt)) +
          (isPP ? ri('Tgl Pulang', formatDate(d.tgl_pulang_krt)) : '') +
          ri('Dari Stasiun', d.stasiun_asal) +
          ri('Ke Stasiun', d.stasiun_tujuan) +
          ri('Waktu Berangkat', d.waktu_berangkat_krt || '-') +
        '</div>' +
        '<div class="rev-block">' +
          '<div class="rev-title">Data Penumpang</div>' +
          ri('Nama Sesuai KTP', d.nama_penumpang_krt) +
          ri('NIK KTP', d.nik_krt) +
          ri('Unit / Kantor Perwakilan', d.perwakilan_krt) +
          ri('No HP', d.hp_krt) +
          ri('Email', d.email_krt) +
          ri('Acara', d.acara_krt) +
          ri('Catatan', d.catatan_krt || '-') +
        '</div>' +
        '<div class="rev-note">' + NOTE_ICON +
          '<span>Setelah dikirim, <b>wajib melampirkan foto KTP</b> penumpang pada chat WhatsApp.</span></div>';
    }

    document.getElementById('confirmModal').classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeConfirm() {
    document.getElementById('confirmModal').classList.remove('active');
    document.body.style.overflow = '';
  }

  /* ══════════════════════════════════════════════
     KIRIM
  ══════════════════════════════════════════════ */
  function confirmSubmit() {
    closeConfirm();

    const formId = { hotel: 'formHotel', pesawat: 'formPesawat', kereta: 'formKereta' }[currentJenis];
    const form   = document.getElementById(formId);
    const btn    = form.querySelector('.submit');
    const txt    = btn.querySelector('.btn-text');

    btn.disabled = true;
    btn.classList.add('loading');
    txt.textContent = 'Menyimpan data...';

    const d = collectData(currentJenis);

    let waMsg = '';
    if (currentJenis === 'hotel')   waMsg = buildHotelMsg(d);
    if (currentJenis === 'pesawat') waMsg = buildPesawatMsg(d);
    if (currentJenis === 'kereta')  waMsg = buildKeretaMsg(d);

    /* 1) Simpan ke basis data (fire & forget) */
    fetch(ENDPOINT, {
      method: 'POST',
      mode: 'no-cors',
      headers: { 'Content-Type': 'text/plain;charset=utf-8' },
      body: JSON.stringify(d)
    }).catch(function(){});

    /* 2) Buka WhatsApp */
    showToast('Data berhasil disimpan. Membuka WhatsApp...', 'success');
    txt.textContent = 'Membuka WhatsApp...';

    setTimeout(function() {
      window.location.href = 'https://wa.me/' + getAdminWa() + '?text=' + encodeURIComponent(waMsg);
    }, 1200);
  }

  document.getElementById('confirmModal').addEventListener('click', function(e) {
    if (e.target === this) closeConfirm();
  });

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeConfirm();
  });
</script>
@endpush
