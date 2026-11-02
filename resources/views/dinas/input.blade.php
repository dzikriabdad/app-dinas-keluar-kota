@extends('layouts.portal')

@section('title', 'Form Perjalanan Dinas')
@section('brand-title', 'Form Perjalanan Dinas')
@section('brand-subtitle', 'PT. Sukun Wartono Indonesia')

@section('topbar-action')
  <a class="topbar-back" href="{{ route('home') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="M19 12H5M11 18l-6-6 6-6"/>
    </svg>
    <span>Menu utama</span>
  </a>
@endsection

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <style>
    #formDinas .form-section {
      display: none;
    }

    #formDinas .form-section.active {
      display: block;
    }

    #formDinas .uang-tugas {
      margin-top: 8px;
    }

    #formDinas .uang-tugas:not([readonly]) {
      background: #fff;
      border-color: #2563eb;
      color: #0f172a;
    }

    #formDinas .manual-rupiah-note {
      display: none;
      margin: 6px 0 0;
      color: #475569;
      font-size: 12px;
      line-height: 1.5;
    }

    #formDinas .manual-rupiah-note.is-visible {
      display: block;
    }
  </style>
@endpush

@section('content')
  <div class="page-head">
    <h1>Aplikasi Form Dinas Keluar Kota</h1>
    <p>Lengkapi data pegawai, pilih jenis form, lalu isi rincian kegiatan. Tarif domestik dihitung otomatis berdasarkan jabatan dan wilayah tujuan. Uang tugas Luar Negeri diisi manual dalam rupiah.</p>
    <div class="rule"></div>
  </div>

  <form action="{{ route('dinas.preview') }}" method="POST" id="formDinas">
    @csrf

    {{-- DATA PEGAWAI DAN DOKUMEN --}}
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
            <label for="kotaTujuanGlobal">Kota Tujuan <span class="hint">(wilayah domestik terdeteksi otomatis)</span></label>
            <input type="text" name="kota_tujuan" id="kotaTujuanGlobal"
                   placeholder="Ketik nama kota, misal: Bandung / Tokyo" required>
            <p class="field-note">Untuk perjalanan luar negeri, pilih wilayah Luar Negeri secara manual pada rincian Pasca Tugas.</p>
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

    {{-- PRA TUGAS --}}
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

    {{-- PASCA TUGAS --}}
    <div class="card form-section" id="section_pasca_tugas">
      <div class="card-head">Realisasi Kegiatan — Pasca Tugas</div>
      <div class="card-body">
        <p class="field-note">Uang tugas wilayah domestik terisi otomatis. Untuk Luar Negeri, masukkan nominal rupiah tanpa titik atau koma, misalnya 500000.</p>

        <div class="table-wrap">
          <div class="table-scroll">
            <table class="table" id="tablePascaTugas">
              <thead>
                <tr>
                  <th style="width:20%">Tanggal (Harian)</th>
                  <th>Realisasi Kegiatan</th>
                  <th style="width:22%">Wilayah &amp; Uang Tugas <span class="hint">(Rp)</span></th>
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

    {{-- UANG MAKAN --}}
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

    {{-- UNDANGAN DINAS --}}
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
    let globalMinDate = null;
    let globalMaxDate = null;

    const tarifDinas = {
        "Sopir": {
            "Kudus": {ut: 0, um: 0},
            "Kars. Pati": {ut: 15000, um: 30000},
            "Jateng & DIY": {ut: 25000, um: 40000},
            "Jatim & Madura": {ut: 30000, um: 40000},
            "Jabar & DKI": {ut: 40000, um: 50000},
            "Luar Jawa": {ut: 40000, um: 60000}
        },
        "Pelaksana": {
            "Kudus": {ut: 0, um: 15000},
            "Kars. Pati": {ut: 20000, um: 45000},
            "Jateng & DIY": {ut: 50000, um: 50000},
            "Jatim & Madura": {ut: 75000, um: 50000},
            "Jabar & DKI": {ut: 75000, um: 60000},
            "Luar Jawa": {ut: 100000, um: 75000}
        },
        "Kapel": {
            "Kudus": {ut: 0, um: 20000},
            "Kars. Pati": {ut: 25000, um: 50000},
            "Jateng & DIY": {ut: 75000, um: 50000},
            "Jatim & Madura": {ut: 75000, um: 75000},
            "Jabar & DKI": {ut: 75000, um: 75000},
            "Luar Jawa": {ut: 100000, um: 100000}
        },
        "Kasie": {
            "Kudus": {ut: 0, um: 25000},
            "Kars. Pati": {ut: 50000, um: 75000},
            "Jateng & DIY": {ut: 75000, um: 75000},
            "Jatim & Madura": {ut: 100000, um: 75000},
            "Jabar & DKI": {ut: 100000, um: 75000},
            "Luar Jawa": {ut: 125000, um: 100000}
        },
        "Kabag": {
            "Kudus": {ut: 0, um: 0},
            "Kars. Pati": {ut: 75000, um: 'REIMBURSE'},
            "Jateng & DIY": {ut: 100000, um: 'REIMBURSE'},
            "Jatim & Madura": {ut: 125000, um: 'REIMBURSE'},
            "Jabar & DKI": {ut: 125000, um: 'REIMBURSE'},
            "Luar Jawa": {ut: 150000, um: 'REIMBURSE'}
        },
        "Manager": {
            "Kudus": {ut: 0, um: 0},
            "Kars. Pati": {ut: 150000, um: 'REIMBURSE'},
            "Jateng & DIY": {ut: 200000, um: 'REIMBURSE'},
            "Jatim & Madura": {ut: 250000, um: 'REIMBURSE'},
            "Jabar & DKI": {ut: 300000, um: 'REIMBURSE'},
            "Luar Jawa": {ut: 400000, um: 'REIMBURSE'}
        }
    };

    const optionsWilayahDomestik = `
        <option value="Kudus">Kudus</option>
        <option value="Kars. Pati">Kars. Pati</option>
        <option value="Jateng & DIY">Jateng & DIY</option>
        <option value="Jatim & Madura">Jatim & Madura</option>
        <option value="Jabar & DKI">Jabar & DKI</option>
        <option value="Luar Jawa">Luar Jawa</option>
    `;

    const optionsWilayah = optionsWilayahDomestik + `
        <option value="Luar Negeri">Luar Negeri</option>
    `;

    const lockAttr = 'readonly onkeydown="return false;" autocomplete="off"';

    $('#formDinas').on('keypress', function(e) {
        if (e.target.tagName.toLowerCase() === 'textarea') return true;

        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    function autoDeteksiWilayah(kotaInput) {
        const k = String(kotaInput || '').toLowerCase();

        if (k.includes('kudus')) return 'Kudus';

        const karsPati = ['jepara', 'pati', 'rembang', 'blora'];
        if (karsPati.some(c => k.includes(c))) return 'Kars. Pati';

        const jatengDiy = ['demak', 'grobogan', 'purwodadi', 'semarang', 'salatiga', 'kendal', 'batang', 'pekalongan', 'tegal', 'brebes', 'pemalang', 'banyumas', 'purwokerto', 'purbalingga', 'cilacap', 'kebumen', 'temanggung', 'wonosobo', 'banjarnegara', 'surakarta', 'solo', 'karanganyar', 'sragen', 'boyolali', 'klaten', 'sukoharjo', 'magelang', 'purworejo', 'yogjakarta', 'yogyakarta', 'jogja', 'bantul', 'sleman', 'kulon progo', 'wonogiri', 'gunung kidul', 'pacitan'];
        if (jatengDiy.some(c => k.includes(c))) return 'Jateng & DIY';

        const jatim = ['malang', 'batu', 'pasuruan', 'lumajang', 'probolinggo', 'jember', 'bondowoso', 'situbondo', 'banyuwangi', 'sampang', 'pamekasan', 'sumenep', 'bangkalan', 'sidoarjo', 'surabaya', 'gresik', 'jombang', 'mojokerto', 'lamongan', 'babat', 'bojonegoro', 'tuban', 'nganjuk', 'kediri', 'tulungagung', 'blitar', 'trenggalek', 'madiun', 'ponorogo', 'ngawi', 'magetan'];
        if (jatim.some(c => k.includes(c))) return 'Jatim & Madura';

        // Cek Luar Jawa sebelum Jabar agar "Banjarmasin" tidak cocok dengan "Banjar".
        const luarJawa = ['banjarmasin', 'tanah laut', 'pangkalan bun', 'kotawari', 'bali', 'denpasar', 'lombok', 'lampung', 'jambi', 'sarolangun', 'pekanbaru', 'rokanhilir', 'indragiri hulu', 'indragiri hilir', 'medan', 'padang', 'palembang', 'batam', 'bengkulu', 'aceh', 'pangkalpinang', 'tanjungpinang', 'dumai', 'bukittinggi', 'lubuklinggau', 'pontianak', 'samarinda', 'balikpapan', 'palangkaraya', 'tarakan', 'banjarbaru', 'singkawang', 'bontang', 'makassar', 'manado', 'palu', 'kendari', 'bitung', 'gorontalo', 'palopo', 'baubau', 'parepare', 'mataram', 'kupang', 'bima', 'ambon', 'ternate', 'jayapura', 'sorong', 'manokwari', 'papua', 'maluku', 'sumatera', 'kalimantan', 'sulawesi', 'riau'];
        if (luarJawa.some(c => k.includes(c))) return 'Luar Jawa';

        const jabarDki = ['jakarta', 'seribu', 'depok', 'bekasi', 'bogor', 'pandeglang', 'serang', 'cilegon', 'karawang', 'tangerang', 'bandung', 'cimahi', 'garut', 'sumedang', 'ciamis', 'pangandaran', 'tasikmalaya', 'banjar', 'cianjur', 'sukabumi', 'cirebon', 'kuningan', 'majalengka', 'indramayu', 'purwakarta', 'subang'];
        if (jabarDki.some(c => k.includes(c))) return 'Jabar & DKI';

        return '';
    }

    function jumlahHari(selectedDates) {
        if (!selectedDates.length) return 0;
        if (selectedDates.length === 1) return 1;

        const awal = selectedDates[0];
        const akhir = selectedDates[selectedDates.length - 1];
        const mulai = Date.UTC(awal.getFullYear(), awal.getMonth(), awal.getDate());
        const selesai = Date.UTC(akhir.getFullYear(), akhir.getMonth(), akhir.getDate());

        return Math.round(Math.abs(selesai - mulai) / 86400000) + 1;
    }

    function sinkronTanggalUM(instance) {
        const group = $(instance.element).closest('tbody');
        group.find('.tgl-snack').val(instance.input.value);
        group.find('.um-hari-makan')
            .val(jumlahHari(instance.selectedDates))
            .trigger('change');
    }

    function applyDateRestrictions() {
        document.querySelectorAll('.date-single, .date-range-um, .date-range-undangan').forEach(el => {
            if (!el._flatpickr) return;

            const fp = el._flatpickr;
            const tanggalLama = fp.selectedDates.slice();

            fp.set('minDate', globalMinDate);
            fp.set('maxDate', globalMaxDate);

            const diLuarRentang = tanggalLama.some(date => {
                return (globalMinDate && date.getTime() < globalMinDate.getTime()) ||
                       (globalMaxDate && date.getTime() > globalMaxDate.getTime());
            });

            if (diLuarRentang) fp.clear();

            if ($(el).hasClass('date-range-um')) {
                sinkronTanggalUM(fp);
            }
        });
    }

    const kalenderUtama = flatpickr('#tanggalDokumen', {
        mode: 'range',
        dateFormat: 'd F Y',
        locale: 'id',
        disableMobile: true,
        allowInput: false,
        onChange: function(selectedDates) {
            if (selectedDates.length) {
                globalMinDate = new Date(selectedDates[0]);
                globalMinDate.setHours(0, 0, 0, 0);

                globalMaxDate = new Date(selectedDates[selectedDates.length - 1]);
                globalMaxDate.setHours(23, 59, 59, 999);
            } else {
                globalMinDate = null;
                globalMaxDate = null;
            }

            applyDateRestrictions();

            document.querySelectorAll('.date-range-um').forEach(el => {
                if (el._flatpickr) {
                    el._flatpickr.setDate(selectedDates, false);
                    sinkronTanggalUM(el._flatpickr);
                }
            });

            document.querySelectorAll('.date-range-undangan').forEach(el => {
                if (el._flatpickr) {
                    el._flatpickr.setDate(selectedDates, false);
                }
            });
        }
    });

    function initDatePickerChild(container) {
        const scope = container ? $(container) : $('#formDinas');
        const baseOptions = {
            dateFormat: 'd M Y',
            locale: 'id',
            disableMobile: true,
            allowInput: false,
            minDate: globalMinDate,
            maxDate: globalMaxDate
        };

        scope.find('.date-single').each(function() {
            if (!this._flatpickr) flatpickr(this, Object.assign({}, baseOptions));
        });

        scope.find('.date-range-undangan').each(function() {
            if (this._flatpickr) return;

            const fp = flatpickr(this, Object.assign({}, baseOptions, {
                mode: 'range'
            }));

            if (kalenderUtama.selectedDates.length) {
                fp.setDate(kalenderUtama.selectedDates, false);
            }
        });

        scope.find('.date-range-um').each(function() {
            if (this._flatpickr) return;

            const fp = flatpickr(this, Object.assign({}, baseOptions, {
                mode: 'range',
                onChange: function(selectedDates, dateStr, instance) {
                    sinkronTanggalUM(instance);
                }
            }));

            if (kalenderUtama.selectedDates.length) {
                fp.setDate(kalenderUtama.selectedDates, false);
            }

            sinkronTanggalUM(fp);
        });
    }

    function aturSectionAktif() {
        $('.form-section')
            .removeClass('active')
            .find('input, select, textarea, button')
            .prop('disabled', true);

        const jenis = $('#jenisFormSelect').val();

        if (jenis) {
            $('#section_' + jenis)
                .addClass('active')
                .find('input, select, textarea, button')
                .prop('disabled', false);
        }
    }

    $('#jenisFormSelect').on('change', aturSectionAktif);

    function hitungTotalPasca() {
        let total = 0;

        $('#tablePascaTugas .uang-tugas').each(function() {
            total += parseFloat($(this).val()) || 0;
        });

        $('#totalPascaTugas').val('Rp ' + total.toLocaleString('id-ID'));
    }

    function hitungGrandTotalUM() {
        let grandTotal = 0;
        let isReimburse = false;

        $('#tableUangMakan .um-total, #tableUangMakan .um-total-snack').each(function() {
            const val = $(this).val();

            if (val === 'REIMBURSE' || val === 'REIMBURSEMENT') {
                isReimburse = true;
            } else {
                grandTotal += parseFloat(val) || 0;
            }
        });

        if (isReimburse && grandTotal === 0) {
            $('#grandTotalUM').val('REIMBURSE');
        } else if (isReimburse) {
            $('#grandTotalUM').val(grandTotal + ' + REIMBURSE');
        } else {
            $('#grandTotalUM').val(grandTotal);
        }
    }

    function tambahBaris(tableId, tipe) {
        let html = '';
        let newContainer = null;

        if (tipe === 'pra') {
            html = `
                <tr>
                    <td>
                        <input type="text" name="pra_tgl[]" ${lockAttr}
                               class="locked-date date-single" placeholder="Pilih tgl" required>
                    </td>
                    <td>
                        <input type="text" name="pra_kegiatan[]" placeholder="Rencana aktivitas..." required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm btn-hapus-single-pra">Hapus</button>
                    </td>
                </tr>
            `;

            $('#' + tableId + ' tbody').append(html);
            newContainer = $('#' + tableId + ' tbody tr').last();
            initDatePickerChild(newContainer);

        } else if (tipe === 'pasca') {
            html = `
                <tr>
                    <td>
                        <input type="text" name="pasca_tgl[]" ${lockAttr}
                               class="locked-date date-single" placeholder="Pilih tgl" required>
                    </td>
                    <td>
                        <input type="text" name="pasca_kegiatan[]" placeholder="Realisasi aktivitas..." required>
                    </td>
                    <td>
                        <select name="pasca_wilayah[]" class="row-wilayah" required>
                            <option value="" disabled selected>Pilih Wilayah</option>
                            ${optionsWilayah}
                        </select>
                        <input type="number" name="pasca_uang[]" class="uang-tugas"
                               min="0" step="1" inputmode="numeric"
                               readonly placeholder="Otomatis" aria-label="Uang tugas dalam rupiah" required>
                        <p class="manual-rupiah-note">Isi rupiah tanpa titik atau koma. Contoh: 500000.</p>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm btn-hapus-single-pasca">Hapus</button>
                    </td>
                </tr>
            `;

            $('#' + tableId + ' tbody').append(html);
            newContainer = $('#' + tableId + ' tbody tr').last();
            initDatePickerChild(newContainer);

            const wilayah = autoDeteksiWilayah($('#kotaTujuanGlobal').val());

            if (wilayah) {
                newContainer.find('.row-wilayah').val(wilayah).trigger('change');
            }

            hitungTotalPasca();

        } else if (tipe === 'um') {
            html = `
                <tbody class="um-group">
                    <tr>
                        <td>
                            <input type="text" name="um_ket[]" class="cell-readonly"
                                   value="Uang Makan" readonly required>
                        </td>
                        <td>
                            <input type="text" name="um_kota[]" class="input-kota-um"
                                   placeholder="Ketik kota..." required>
                        </td>
                        <td>
                            <input type="text" name="um_tgl[]" ${lockAttr}
                                   class="locked-date date-range-um" placeholder="Pilih tgl" required>
                        </td>
                        <td>
                            <input type="number" name="um_hari[]" class="um-hari-makan"
                                   readonly placeholder="0" required>
                        </td>
                        <td>
                            <select name="um_wilayah[]" class="row-wilayah" required>
                                <option value="" disabled selected>Pilih Wilayah</option>
                                ${optionsWilayahDomestik}
                            </select>
                            <input type="text" name="um_nominal[]" class="um-nominal"
                                   readonly placeholder="Otomatis" required>
                        </td>
                        <td>
                            <input type="text" name="um_total[]" class="um-total" readonly required>
                        </td>
                    </tr>
                    <tr class="um-snack-row">
                        <td>
                            <input type="text" name="um_ket[]" class="cell-readonly"
                                   value="Uang Snack" readonly required>
                        </td>
                        <td>
                            <input type="text" name="um_kota[]" class="kota-snack cell-readonly"
                                   readonly placeholder="-" required>
                        </td>
                        <td>
                            <input type="text" name="um_tgl[]" class="tgl-snack cell-readonly"
                                   readonly placeholder="-" required>
                        </td>
                        <td>
                            <input type="number" name="um_hari[]" class="cell-readonly"
                                   value="1" readonly required>
                        </td>
                        <td>
                            <input type="number" name="um_nominal[]" class="um-nominal-snack"
                                   value="40000" readonly required>
                        </td>
                        <td>
                            <input type="text" name="um_total[]" class="um-total-snack"
                                   value="40000" readonly required>
                        </td>
                    </tr>
                </tbody>
            `;

            $('#' + tableId + ' tfoot').before(html);
            newContainer = $('#' + tableId + ' tbody.um-group').last();

            initDatePickerChild(newContainer);

            newContainer.find('.input-kota-um')
                .val($('#kotaTujuanGlobal').val())
                .trigger('blur');

            hitungGrandTotalUM();
        }

        // Input baru di bagian tersembunyi juga harus dinonaktifkan.
        aturSectionAktif();
    }

    $('#kotaTujuanGlobal').on('input blur', function() {
        const kota = $(this).val();
        const wilayah = autoDeteksiWilayah(kota);

        $('#tableUangMakan .input-kota-um').val(kota).trigger('blur');

        if (wilayah) {
            $('#tablePascaTugas .row-wilayah').each(function() {
                // Jangan menimpa wilayah dan nominal Luar Negeri yang dipilih manual.
                if ($(this).val() !== 'Luar Negeri') {
                    $(this).val(wilayah).trigger('change');
                }
            });
        }
    });

    $(document).on('input blur', '.input-kota-um', function() {
        const group = $(this).closest('tbody');
        const kota = $(this).val();

        group.find('.kota-snack').val(kota);

        const wilayah = autoDeteksiWilayah(kota);

        if (wilayah) {
            group.find('.row-wilayah').val(wilayah).trigger('change');
        }
    });

    $('#jabatanSelect').on('change', function() {
        $('.row-wilayah').trigger('change');
    });

    $(document).on('change', '.row-wilayah', function() {
        const tr = $(this).closest('tr');
        const jabatan = $('#jabatanSelect').val();
        const wilayah = $(this).val();
        const tarif = tarifDinas[jabatan]?.[wilayah];

        if (tr.closest('#tablePascaTugas').length) {
            const inputUang = tr.find('.uang-tugas');
            const catatan = tr.find('.manual-rupiah-note');

            if (wilayah === 'Luar Negeri') {
                // Hapus tarif domestik hanya saat pertama beralih ke mode manual.
                if (inputUang.prop('readonly')) {
                    inputUang.val('');
                }

                inputUang
                    .prop('readonly', false)
                    .attr('placeholder', 'Isi nominal Rupiah');

                catatan.addClass('is-visible');
            } else {
                inputUang
                    .prop('readonly', true)
                    .attr('placeholder', 'Otomatis')
                    .val(tarif ? tarif.ut : '');

                catatan.removeClass('is-visible');
            }

            hitungTotalPasca();
            return;
        }

        if (tr.closest('tbody.um-group').length) {
            tr.find('.um-nominal')
                .val(tarif ? tarif.um : '')
                .trigger('change');
        }
    });

    $(document).on('input change', '.uang-tugas', function() {
        hitungTotalPasca();
    });

    $('#pilihKategoriHari').on('change', function() {
        $('#undanganUang').val($(this).val());
    });

    $(document).on('input change', '.um-hari-makan, .um-nominal', function() {
        const tr = $(this).closest('tr');
        const hari = parseFloat(tr.find('.um-hari-makan').val()) || 0;
        const nominal = tr.find('.um-nominal').val();

        if (nominal === 'REIMBURSE' || nominal === 'REIMBURSEMENT') {
            tr.find('.um-total').val('REIMBURSE');
        } else {
            tr.find('.um-total').val(hari * (parseFloat(nominal) || 0));
        }

        hitungGrandTotalUM();
    });

    $(document).on('input change', '.um-nominal-snack', function() {
        $(this).closest('tr')
            .find('.um-total-snack')
            .val(parseFloat($(this).val()) || 0);

        hitungGrandTotalUM();
    });

    function hapusBarisDenganKalender(row) {
        row.find('input').each(function() {
            if (this._flatpickr) this._flatpickr.destroy();
        });

        row.remove();
    }

    $(document).on('click', '.btn-hapus-single-pra', function() {
        const row = $(this).closest('tr');

        if (row.closest('tbody').find('tr').length > 1) {
            hapusBarisDenganKalender(row);
        }
    });

    $(document).on('click', '.btn-hapus-single-pasca', function() {
        const row = $(this).closest('tr');

        if (row.closest('tbody').find('tr').length > 1) {
            hapusBarisDenganKalender(row);
            hitungTotalPasca();
        }
    });

    $('#formDinas').on('reset', function() {
        // Jalankan setelah browser menyelesaikan reset nilai bawaan.
        window.setTimeout(function() {
            kalenderUtama.clear(false);
            globalMinDate = null;
            globalMaxDate = null;

            $('.form-section input').each(function() {
                if (this._flatpickr) this._flatpickr.destroy();
            });

            $('#tablePraTugas tbody').empty();
            $('#tablePascaTugas tbody').empty();
            $('#tableUangMakan tbody').remove();

            $('#undanganTgl').val('');
            $('#undanganUang').val('');

            initDatePickerChild();
            tambahBaris('tablePraTugas', 'pra');
            tambahBaris('tablePascaTugas', 'pasca');
            tambahBaris('tableUangMakan', 'um');

            hitungTotalPasca();
            hitungGrandTotalUM();
            aturSectionAktif();
        }, 0);
    });

    $(document).ready(function() {
        initDatePickerChild();

        tambahBaris('tablePraTugas', 'pra');
        tambahBaris('tablePascaTugas', 'pasca');
        tambahBaris('tableUangMakan', 'um');

        hitungTotalPasca();
        hitungGrandTotalUM();
        aturSectionAktif();
    });
</script>
@endpush
