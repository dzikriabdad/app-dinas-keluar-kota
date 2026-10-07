@extends('layouts.portal')

@section('title', 'Form Perjalanan Dinas')
@section('brand-title', 'Form Perjalanan Dinas')
@section('brand-subtitle', 'PT. Sukun Wartono Indonesia')

@section('topbar-action')
  <a class="topbar-back" href="{{ route('home') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
    <span>Menu utama</span>
  </a>
@endsection

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')

  <div class="page-head">
    <h1>Aplikasi Form Dinas Keluar Kota</h1>
    <p>Lengkapi data pegawai, pilih jenis form, lalu isi rincian kegiatan. Tarif uang tugas dan uang makan dihitung otomatis berdasarkan jabatan dan wilayah tujuan.</p>
    <div class="rule"></div>
  </div>

  <form action="{{ route('dinas.preview') }}" method="POST" id="formDinas">
    @csrf

    {{-- ══════════ 1. DATA PEGAWAI & DOKUMEN ══════════ --}}
    <div class="card">
      <div class="card-head">Data Pegawai &amp; Dokumen</div>
      <div class="card-body">

        <div class="grid-3">
          <div class="field">
            <label for="nama">Nama Pegawai</label>
            <input type="text" id="nama" name="nama" placeholder="Masukkan nama" required>
          </div>

          <div class="field">
            <label for="divisi">Divisi</label>
            <input type="text" id="divisi" name="divisi" placeholder="Contoh: IT / Marketing" required>
          </div>

          <div class="field">
            <label for="jabatanSelect">Jabatan <span class="hint">(menentukan tarif)</span></label>
            <select name="jabatan" id="jabatanSelect" required>
              <option value="" disabled selected>-- Pilih Jabatan --</option>
              <option value="Sopir">Sopir</option>
              <option value="Pelaksana">Pelaksana</option>
              <option value="Kapel">Kapel</option>
              <option value="Kasie">Kasie</option>
              <option value="Kabag">Kabag</option>
              <option value="Manager">Manager</option>
            </select>
          </div>
        </div>

        <div class="grid-2">
          <div class="field">
            <label for="tanggalDokumen">Tanggal Form <span class="hint">(bisa rentang)</span></label>
            <input type="text" name="tanggal_dokumen" id="tanggalDokumen"
                   class="locked-date" required readonly onkeydown="return false;"
                   placeholder="Pilih tanggal pelaksanaan">
          </div>

          <div class="field">
            <label for="kotaTujuanGlobal">Kota Tujuan <span class="hint">(wilayah terdeteksi otomatis)</span></label>
            <input type="text" name="kota_tujuan" id="kotaTujuanGlobal"
                   placeholder="Ketik nama kota, misal: Bandung / Semarang" required>
          </div>
        </div>

        <div class="field">
          <label for="jenisFormSelect">Jenis Form yang Akan Dibuat</label>
          <select name="jenis_form" id="jenisFormSelect" required>
            <option value="" selected disabled>-- Pilih Form Dinas --</option>
            <option value="pra_tugas">1. Form Pra Tugas Dinas</option>
            <option value="pasca_tugas">2. Form Pasca Tugas Dinas</option>
            <option value="uang_makan">3. Form Uang Makan</option>
            <option value="undangan_dinas">4. Form Pasca Undangan Dinas</option>
          </select>
          <p class="field-note">Bagian rincian di bawah akan menyesuaikan pilihan ini.</p>
        </div>

      </div>
    </div>

    {{-- ══════════ 2A. PRA TUGAS ══════════ --}}
    <div class="card form-section" id="section_pra_tugas">
      <div class="card-head">Rencana Kegiatan — Pra Tugas</div>
      <div class="card-body">

        <div class="table-wrap">
          <div class="table-scroll">
            <table class="table" id="tablePraTugas">
              <thead>
                <tr>
                  <th style="width:25%">Tanggal (Harian)</th>
                  <th>Rencana Kegiatan</th>
                  <th style="width:10%">Aksi</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>

        <div class="btn-row">
          <button type="button" class="btn btn-ghost btn-sm" onclick="tambahBaris('tablePraTugas', 'pra')">+ Tambah Baris</button>
        </div>

      </div>
    </div>

    {{-- ══════════ 2B. PASCA TUGAS ══════════ --}}
    <div class="card form-section" id="section_pasca_tugas">
      <div class="card-head">Realisasi Kegiatan — Pasca Tugas</div>
      <div class="card-body">

        <div class="table-wrap">
          <div class="table-scroll">
            <table class="table" id="tablePascaTugas">
              <thead>
                <tr>
                  <th style="width:20%">Tanggal (Harian)</th>
                  <th>Realisasi Kegiatan</th>
                  <th style="width:22%">Wilayah &amp; Uang Tugas <span class="hint">(otomatis)</span></th>
                  <th style="width:8%">Aksi</th>
                </tr>
              </thead>
              <tbody></tbody>
              <tfoot>
                <tr>
                  <td colspan="2" style="text-align:right">TOTAL UANG TUGAS</td>
                  <td><input type="text" id="totalPascaTugas" readonly placeholder="Rp 0"></td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <div class="btn-row">
          <button type="button" class="btn btn-ghost btn-sm" onclick="tambahBaris('tablePascaTugas', 'pasca')">+ Tambah Baris</button>
        </div>

      </div>
    </div>

    {{-- ══════════ 2C. UANG MAKAN ══════════ --}}
    <div class="card form-section" id="section_uang_makan">
      <div class="card-head">Rincian Uang Makan &amp; Snack</div>
      <div class="card-body">

        <div class="table-wrap">
          <div class="table-scroll">
            <table class="table" id="tableUangMakan">
              <thead>
                <tr>
                  <th style="width:14%">Keterangan</th>
                  <th style="width:16%">Kota <span class="hint">(otomatis)</span></th>
                  <th>Tanggal</th>
                  <th style="width:8%">Hari</th>
                  <th style="width:18%">Wilayah &amp; Nominal</th>
                  <th style="width:15%">Total (Rp)</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <td colspan="5" style="text-align:right">GRAND TOTAL MAKAN &amp; SNACK</td>
                  <td><input type="text" id="grandTotalUM" readonly placeholder="Rp 0"></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <div class="btn-row">
          <button type="button" class="btn btn-ghost btn-sm" onclick="tambahBaris('tableUangMakan', 'um')">+ Tambah Baris</button>
        </div>

      </div>
    </div>

    {{-- ══════════ 2D. UNDANGAN DINAS ══════════ --}}
    <div class="card form-section" id="section_undangan_dinas">
      <div class="card-head">Realisasi Kegiatan — Undangan Dinas</div>
      <div class="card-body">

        <div class="grid-3">
          <div class="field">
            <label for="undanganTgl">Tanggal Pelaksanaan</label>
            <input type="text" name="undangan_tgl" id="undanganTgl"
                   class="date-range-undangan locked-date" required readonly onkeydown="return false;"
                   placeholder="Pilih dari form atas">
          </div>

          <div class="field" style="grid-column:span 2">
            <label for="pilihKategoriHari">Kategori Hari Pelaksanaan</label>
            <select id="pilihKategoriHari" required>
              <option value="" disabled selected>-- Pilih Jenis Hari --</option>
              <option value="200000">Hari Kerja (Biasa / Jumat Pas Masuk)</option>
              <option value="300000">Hari Libur (Jumat Normal / Rabu Kliwon / Kamis Pon)</option>
            </select>
            <p class="field-note field-note-warn">Hari kerja = Rp 200.000 flat &nbsp;|&nbsp; Hari libur = Rp 300.000 flat</p>
          </div>
        </div>

        <div class="grid-3">
          <div class="field" style="grid-column:span 2">
            <label for="undanganKegiatan">Realisasi Kegiatan</label>
            <textarea name="undangan_kegiatan" id="undanganKegiatan" rows="3" placeholder="Tulis rincian kegiatan..." required></textarea>
          </div>

          <div class="field">
            <label for="undanganUang">Uang Tugas <span class="hint">(terisi otomatis)</span></label>
            <div class="input-group">
              <span class="input-prefix">Rp</span>
              <input type="number" name="undangan_uang" id="undanganUang" readonly placeholder="0" required>
            </div>
          </div>
        </div>

      </div>
    </div>

    {{-- ══════════ AKSI ══════════ --}}
    <div class="form-actions">
      <button type="reset" class="btn">Reset Form</button>
      <button type="submit" class="submit">Simpan Data &amp; Cetak Form</button>
    </div>

  </form>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

<script>
    // MENCEGAH ENTER MENSUBMIT FORM
    $('#formDinas').on('keypress', function(e) {
        if (e.target.tagName.toLowerCase() === 'textarea') {
            return true;
        }
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

    let globalMinDate = null;
    let globalMaxDate = null;

    // MATRIKS TARIF DINAS
    const tarifDinas = {
        "Sopir": { "Kudus": {ut: 0, um: 0}, "Kars. Pati": {ut: 15000, um: 30000}, "Jateng & DIY": {ut: 25000, um: 40000}, "Jatim & Madura": {ut: 30000, um: 40000}, "Jabar & DKI": {ut: 40000, um: 50000}, "Luar Jawa": {ut: 40000, um: 60000} },
        "Pelaksana": { "Kudus": {ut: 0, um: 15000}, "Kars. Pati": {ut: 20000, um: 45000}, "Jateng & DIY": {ut: 50000, um: 50000}, "Jatim & Madura": {ut: 75000, um: 50000}, "Jabar & DKI": {ut: 75000, um: 60000}, "Luar Jawa": {ut: 100000, um: 75000} },
        "Kapel": { "Kudus": {ut: 0, um: 20000}, "Kars. Pati": {ut: 25000, um: 50000}, "Jateng & DIY": {ut: 75000, um: 50000}, "Jatim & Madura": {ut: 75000, um: 75000}, "Jabar & DKI": {ut: 75000, um: 75000}, "Luar Jawa": {ut: 100000, um: 100000} },
        "Kasie": { "Kudus": {ut: 0, um: 25000}, "Kars. Pati": {ut: 50000, um: 75000}, "Jateng & DIY": {ut: 75000, um: 75000}, "Jatim & Madura": {ut: 100000, um: 75000}, "Jabar & DKI": {ut: 100000, um: 75000}, "Luar Jawa": {ut: 125000, um: 100000} },
        "Kabag": { "Kudus": {ut: 0, um: 0}, "Kars. Pati": {ut: 75000, um: 'REIMBURSE'}, "Jateng & DIY": {ut: 100000, um: 'REIMBURSE'}, "Jatim & Madura": {ut: 125000, um: 'REIMBURSE'}, "Jabar & DKI": {ut: 125000, um: 'REIMBURSE'}, "Luar Jawa": {ut: 150000, um: 'REIMBURSE'} },
        "Manager": { "Kudus": {ut: 0, um: 0}, "Kars. Pati": {ut: 150000, um: 'REIMBURSE'}, "Jateng & DIY": {ut: 200000, um: 'REIMBURSE'}, "Jatim & Madura": {ut: 250000, um: 'REIMBURSE'}, "Jabar & DKI": {ut: 300000, um: 'REIMBURSE'}, "Luar Jawa": {ut: 400000, um: 'REIMBURSE'} }
    };

    const optionsWilayah = `
        <option value="Kudus">Kudus</option>
        <option value="Kars. Pati">Kars. Pati</option>
        <option value="Jateng & DIY">Jateng & DIY</option>
        <option value="Jatim & Madura">Jatim & Madura</option>
        <option value="Jabar & DKI">Jabar & DKI</option>
        <option value="Luar Jawa">Luar Jawa</option>
    `;

    // DETEKSI KOTA -> WILAYAH
    function autoDeteksiWilayah(kotaInput) {
        let k = kotaInput.toLowerCase();

        if (k.includes('kudus')) return 'Kudus';
        let karsPati = ['jepara', 'pati', 'rembang', 'blora'];
        if (karsPati.some(c => k.includes(c))) return 'Kars. Pati';

        let jatengDiy = ['demak', 'grobogan', 'purwodadi', 'semarang', 'salatiga', 'kendal', 'batang', 'pekalongan', 'tegal', 'brebes', 'pemalang', 'banyumas', 'purwokerto', 'purbalingga', 'cilacap', 'kebumen', 'temanggung', 'wonosobo', 'banjarnegara', 'surakarta', 'solo', 'karanganyar', 'sragen', 'boyolali', 'klaten', 'sukoharjo', 'magelang', 'purworejo', 'yogjakarta', 'yogyakarta', 'jogja', 'bantul', 'sleman', 'kulon progo', 'wonogiri', 'gunung kidul', 'pacitan'];
        if (jatengDiy.some(c => k.includes(c))) return 'Jateng & DIY';

        let jatim = ['malang', 'batu', 'pasuruan', 'lumajang', 'probolinggo', 'jember', 'bondowoso', 'situbondo', 'banyuwangi', 'sampang', 'pamekasan', 'sumenep', 'bangkalan', 'sidoarjo', 'surabaya', 'gresik', 'jombang', 'mojokerto', 'lamongan', 'babat', 'bojonegoro', 'tuban', 'nganjuk', 'kediri', 'tulungagung', 'blitar', 'trenggalek', 'madiun', 'ponorogo', 'ngawi', 'magetan'];
        if (jatim.some(c => k.includes(c))) return 'Jatim & Madura';

        let jabarDki = ['jakarta', 'seribu', 'depok', 'bekasi', 'bogor', 'pandeglang', 'serang', 'cilegon', 'karawang', 'tangerang', 'bandung', 'cimahi', 'garut', 'sumedang', 'ciamis', 'pangandaran', 'tasikmalaya', 'banjar', 'cianjur', 'sukabumi', 'cirebon', 'kuningan', 'majalengka', 'indramayu', 'purwakarta', 'subang'];
        if (jabarDki.some(c => k.includes(c))) return 'Jabar & DKI';

        let luarJawa = ['banjarmasin', 'tanah laut', 'pangkalan bun', 'kotawari', 'bali', 'denpasar', 'lombok', 'lampung', 'jambi', 'sarolangun', 'pekanbaru', 'rokanhilir', 'indragiri hulu', 'indragiri hilir', 'medan', 'padang', 'palembang', 'batam', 'bengkulu', 'aceh', 'pangkalpinang', 'tanjungpinang', 'dumai', 'bukittinggi', 'lubuklinggau', 'pontianak', 'samarinda', 'balikpapan', 'palangkaraya', 'tarakan', 'banjarbaru', 'singkawang', 'bontang', 'makassar', 'manado', 'palu', 'kendari', 'bitung', 'gorontalo', 'palopo', 'baubau', 'parepare', 'mataram', 'kupang', 'bima', 'ambon', 'ternate', 'jayapura', 'sorong', 'manokwari', 'papua', 'maluku', 'sumatera', 'kalimantan', 'sulawesi', 'riau'];
        if (luarJawa.some(c => k.includes(c))) return 'Luar Jawa';

        return '';
    }

    // UPDATE SEMUA KALENDER DI TABEL SAAT TANGGAL UTAMA BERUBAH
    function applyDateRestrictions() {
        let childCalendars = document.querySelectorAll('.date-single, .date-range-um');
        childCalendars.forEach(el => {
            if (el._flatpickr) {
                el._flatpickr.set('minDate', globalMinDate);
                el._flatpickr.set('maxDate', globalMaxDate);

                let sel = el._flatpickr.selectedDates;
                if (sel.length > 0 && globalMinDate && globalMaxDate) {
                    let minTime = globalMinDate.getTime();
                    let maxTime = globalMaxDate.getTime();
                    let isOut = false;

                    sel.forEach(d => {
                        let t = new Date(d);
                        t.setHours(0,0,0,0);
                        if(t.getTime() < minTime || t.getTime() > maxTime) isOut = true;
                    });

                    if(isOut) {
                        el._flatpickr.clear();
                        let group = $(el).closest('tbody');
                        if(group.hasClass('um-group')) {
                            group.find('.um-hari-makan').val(0).trigger('change');
                            group.find('.tgl-snack').val('');
                        }
                    }
                }
            }
        });
    }

    // INISIALISASI KALENDER UTAMA
    flatpickr("#tanggalDokumen", {
        mode: "range",
        dateFormat: "d F Y",
        locale: "id",
        disableMobile: true,
        allowInput: false,
        onChange: function(selectedDates, dateStr) {
            if (selectedDates.length > 0) {
                globalMinDate = new Date(selectedDates[0]);
                globalMinDate.setHours(0,0,0,0);
                globalMaxDate = new Date(selectedDates[selectedDates.length - 1]);
                globalMaxDate.setHours(23,59,59,999);
            } else {
                globalMinDate = null;
                globalMaxDate = null;
            }
            applyDateRestrictions();

            // Otomatis isi tanggal di Form Uang Makan
            $('.date-range-um').val(dateStr);
            if(selectedDates.length === 2) {
                let diffTime = Math.abs(selectedDates[1] - selectedDates[0]);
                let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                $('.um-hari-makan').val(diffDays).trigger('change');
            } else if (selectedDates.length === 1) {
                $('.um-hari-makan').val(1).trigger('change');
            }
            $('.tgl-snack').val(dateStr);

            // Otomatis isi tanggal di form Undangan Dinas
            $('.date-range-undangan').val(dateStr);
            let fpUndangan = document.querySelector('.date-range-undangan');
            if(fpUndangan && fpUndangan._flatpickr) {
                fpUndangan._flatpickr.setDate(selectedDates);
            }
        }
    });

    // INISIALISASI KALENDER ANAK SECARA DINAMIS
    function initDatePickerChild(container) {
        let optsSingle = { dateFormat: "d M Y", locale: "id", disableMobile: true, allowInput: false };
        let optsRange = { mode: "range", dateFormat: "d M Y", locale: "id", disableMobile: true, allowInput: false };

        if (globalMinDate) { optsSingle.minDate = globalMinDate; optsRange.minDate = globalMinDate; }
        if (globalMaxDate) { optsSingle.maxDate = globalMaxDate; optsRange.maxDate = globalMaxDate; }

        let elSingle = container ? $(container).find('.date-single').toArray() : $('.date-single').toArray();
        if(elSingle.length) flatpickr(elSingle, optsSingle);

        let elUndangan = container ? $(container).find('.date-range-undangan').toArray() : $('.date-range-undangan').toArray();
        if(elUndangan.length) flatpickr(elUndangan, { mode: "range", dateFormat: "d M Y", locale: "id", disableMobile: true, allowInput: false });

        let elUM = container ? $(container).find('.date-range-um').toArray() : $('.date-range-um').toArray();
        if(elUM.length) {
            let optsUM = Object.assign({}, optsRange, {
                onChange: function(selectedDates, dateStr, instance) {
                    let group = $(instance.element).closest('tbody');
                    group.find('.tgl-snack').val(dateStr);
                    if (selectedDates.length === 2) {
                        let diffTime = Math.abs(selectedDates[1] - selectedDates[0]);
                        let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                        group.find('.um-hari-makan').val(diffDays).trigger('change');
                    } else if (selectedDates.length === 1) {
                        group.find('.um-hari-makan').val(1).trigger('change');
                    } else {
                        group.find('.um-hari-makan').val(0).trigger('change');
                    }
                }
            });
            flatpickr(elUM, optsUM);
        }
    }

    // ===============================================
    // JURUS DISABLE-ENABLE FORM MANDATORY
    // ===============================================
    $('#jenisFormSelect').on('change', function() {
        $('.form-section').removeClass('active');

        // Disable semua input di bagian form-section agar browser abaikan validasinya
        $('.form-section').find('input, select, textarea, button').prop('disabled', true);

        let val = $(this).val();
        if(val) {
            $('#section_' + val).addClass('active');

            // Aktifkan hanya input/tombol di form yang lagi tampil
            $('#section_' + val).find('input, select, textarea, button').prop('disabled', false);
        }
    });

    function hitungTotalPasca() {
        let total = 0;
        let isReimburse = false;
        $('#tablePascaTugas tbody tr').each(function() {
            let val = $(this).find('.uang-tugas').val();
            if(val === 'REIMBURSE' || val === 'REIMBURSEMENT') isReimburse = true;
            else total += (parseFloat(val) || 0);
        });
        if(isReimburse && total === 0) $('#totalPascaTugas').val('REIMBURSE');
        else if (isReimburse) $('#totalPascaTugas').val(total + ' + REIMBURSE');
        else $('#totalPascaTugas').val(total);
    }

    function hitungGrandTotalUM() {
        let grandTotal = 0;
        let isReimburse = false;
        $('.um-total, .um-total-snack').each(function() {
            let val = $(this).val();
            if(val === 'REIMBURSE' || val === 'REIMBURSEMENT') isReimburse = true;
            else grandTotal += (parseFloat(val) || 0);
        });
        if(isReimburse && grandTotal === 0) $('#grandTotalUM').val('REIMBURSE');
        else if(isReimburse) $('#grandTotalUM').val(grandTotal + ' + REIMBURSE');
        else $('#grandTotalUM').val(grandTotal);
    }

    const lockAttr = 'readonly onkeydown="return false;" autocomplete="off"';

    function tambahBaris(tableId, tipe) {
        let tbody = '';

        if(tipe === 'pra') {
            tbody = `<tr>
                        <td><input type="text" name="pra_tgl[]" ${lockAttr} class="locked-date date-single" placeholder="Pilih tgl" required></td>
                        <td><input type="text" name="pra_kegiatan[]" placeholder="Rencana aktivitas..." required></td>
                        <td><button type="button" class="btn btn-danger btn-sm btn-hapus-single-pra">Hapus</button></td>
                     </tr>`;
            $('#' + tableId + ' tbody').append(tbody);
            initDatePickerChild($('#' + tableId + ' tbody').find('tr:last'));

        } else if(tipe === 'pasca') {
            tbody = `<tr>
                        <td><input type="text" name="pasca_tgl[]" ${lockAttr} class="locked-date date-single" placeholder="Pilih tgl" required></td>
                        <td><input type="text" name="pasca_kegiatan[]" placeholder="Realisasi aktivitas..." required></td>
                        <td>
                            <select name="pasca_wilayah[]" class="row-wilayah" required><option value="" disabled selected>Pilih Wilayah</option>${optionsWilayah}</select>
                            <input type="text" name="pasca_uang[]" class="uang-tugas" readonly placeholder="Otomatis" required>
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm btn-hapus-single-pasca">Hapus</button></td>
                     </tr>`;
            $('#' + tableId + ' tbody').append(tbody);
            initDatePickerChild($('#' + tableId + ' tbody').find('tr:last'));

        } else if(tipe === 'um') {
            tbody = `<tbody class="um-group">
                        <tr>
                            <td><input type="text" name="um_ket[]" class="cell-readonly" value="Uang Makan" readonly required></td>
                            <td><input type="text" name="um_kota[]" class="input-kota-um" placeholder="Ketik kota..." required></td>
                            <td><input type="text" name="um_tgl[]" ${lockAttr} class="locked-date date-range-um" placeholder="Pilih tgl" required></td>
                            <td><input type="number" name="um_hari[]" class="um-hari-makan" readonly placeholder="0" required></td>
                            <td>
                                <select name="um_wilayah[]" class="row-wilayah" required><option value="" disabled selected>Pilih Wilayah</option>${optionsWilayah}</select>
                                <input type="text" name="um_nominal[]" class="um-nominal" readonly placeholder="Otomatis" required>
                            </td>
                            <td><input type="text" name="um_total[]" class="um-total" readonly required></td>
                        </tr>
                        <tr class="um-snack-row">
                            <td><input type="text" name="um_ket[]" class="cell-readonly" value="Uang Snack" readonly required></td>
                            <td><input type="text" name="um_kota[]" class="kota-snack cell-readonly" readonly placeholder="-" required></td>
                            <td><input type="text" name="um_tgl[]" class="tgl-snack cell-readonly" readonly placeholder="-" required></td>
                            <td><input type="number" name="um_hari[]" class="cell-readonly" value="1" readonly required></td>
                            <td><input type="number" name="um_nominal[]" class="um-nominal-snack" value="40000" readonly required></td>
                            <td><input type="text" name="um_total[]" class="um-total-snack" value="40000" readonly required></td>
                        </tr>
                     </tbody>`;
            $('#' + tableId).append(tbody);
            let newGroup = $('#' + tableId).find('tbody').last();
            initDatePickerChild(newGroup);
        }

        let globalKota = $('#kotaTujuanGlobal').val();
        if(globalKota) {
            $('#kotaTujuanGlobal').trigger('blur');
        }

        if(tipe === 'um') hitungGrandTotalUM();
    }

    // AUTO-SYNC KOTA
    $('#kotaTujuanGlobal').on('keyup blur', function() {
        let kota = $(this).val();
        let deteksiWilayah = autoDeteksiWilayah(kota);

        $('#tableUangMakan .input-kota-um').val(kota).trigger('blur');
        if(deteksiWilayah) {
            $('#tablePascaTugas .row-wilayah').val(deteksiWilayah).trigger('change');
        }
    });

    $(document).on('keyup blur', '.input-kota-um', function() {
        let group = $(this).closest('tbody');
        let kota = $(this).val();
        group.find('.kota-snack').val(kota);
        let deteksiWilayah = autoDeteksiWilayah(kota);
        if(deteksiWilayah) group.find('.row-wilayah').val(deteksiWilayah).trigger('change');
    });

    // AUTO-SYNC JABATAN
    $('#jabatanSelect').on('change', function() {
        $('.row-wilayah').trigger('change');
    });

    $(document).on('change', '.row-wilayah', function() {
        let tr = $(this).closest('tr');
        let jabatan = $('#jabatanSelect').val();
        let wilayah = $(this).val();

        if (jabatan && wilayah) {
            let tarif = tarifDinas[jabatan][wilayah];
            if (tr.closest('#tablePascaTugas').length > 0) {
                tr.find('.uang-tugas').val(tarif.ut);
                hitungTotalPasca();
            } else if (tr.closest('tbody.um-group').length > 0) {
                tr.find('.um-nominal').val(tarif.um).trigger('change');
            }
        }
    });

    $('#pilihKategoriHari').on('change', function() {
        $('#undanganUang').val($(this).val());
    });

    $(document).on('keyup change', '.um-hari-makan, .um-nominal', function() {
        let tr = $(this).closest('tr');
        let hari = parseFloat(tr.find('.um-hari-makan').val()) || 0;
        let nominalVal = tr.find('.um-nominal').val();
        if (nominalVal === 'REIMBURSE' || nominalVal === 'REIMBURSEMENT') tr.find('.um-total').val('REIMBURSE');
        else tr.find('.um-total').val(hari * (parseFloat(nominalVal) || 0));
        hitungGrandTotalUM();
    });

    $(document).on('keyup change', '.um-nominal-snack', function() {
        let tr = $(this).closest('tr');
        tr.find('.um-total-snack').val(parseFloat($(this).val()) || 0);
        hitungGrandTotalUM();
    });

    $(document).on('click', '.btn-hapus-single-pra', function() {
        if($(this).closest('tbody').find('tr').length > 1) $(this).closest('tr').remove();
    });

    $(document).on('click', '.btn-hapus-single-pasca', function() {
        if($(this).closest('tbody').find('tr').length > 1) {
            $(this).closest('tr').remove();
            hitungTotalPasca();
        }
    });

    $(document).ready(function() {
        // Trigger select jenis_form di awal buat nyembunyiin + disable semua section
        $('#jenisFormSelect').trigger('change');

        initDatePickerChild();
        tambahBaris('tablePraTugas', 'pra');
        tambahBaris('tablePascaTugas', 'pasca');
        tambahBaris('tableUangMakan', 'um');
    });
</script>
@endpush
