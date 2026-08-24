<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengisian Form Dinas - PT Sukun Wartono Indonesia</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Flatpickr (Untuk Kalender Range Tanggal) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <style>
        body { background-color: #f4f6f9; }
        .card { box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; }
        .form-section { display: none; }
        .form-section.active { display: block; }
        .uang-tugas, .um-nominal, .um-total, .um-total-snack { font-weight: bold; }
        .bg-snack { background-color: #fdfdfd; }
        
        /* Gembok Panah Naik-Turun Number */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] { -moz-appearance: textfield; }
        
        /* Anti-Ketik Kursor Tanggal */
        .locked-date {
            caret-color: transparent !important;
            cursor: pointer !important;
        }
    </style>
</head>
<body class="py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <h2 class="text-center fw-bold mb-4">Aplikasi Form Dinas Keluar Kota</h2>
            <h3 class="text-center fw-bold mb-4">PT. Sukun Wartono Indonesia</h3>
           <form action="{{ route('dinas.preview') }}" method="POST" id="formDinas">
                @csrf
                
                <!-- 1. Data Umum Pegawai -->
                <div class="card mb-4 border-0">
                    <div class="card-header bg-primary text-white fw-bold">Data Pegawai & Dokumen</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Nama Pegawai</label>
                                <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Divisi</label>
                                <input type="text" name="divisi" class="form-control" required placeholder="Contoh: IT / Marketing">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-primary fw-bold">Jabatan (Penting)</label>
                                <select name="jabatan" id="jabatanSelect" class="form-select border-primary" required>
                                    <option value="" disabled selected>-- Pilih Jabatan --</option>
                                    <option value="Sopir">Sopir</option>
                                    <option value="Pelaksana">Pelaksana</option>
                                    <option value="Kapel">Kapel</option>
                                    <option value="Kasie">Kasie</option>
                                    <option value="Kabag">Kabag</option>
                                    <option value="Manager">Manager</option>
                                </select>
                            </div>
                            
                            <!-- TANGGAL DOKUMEN UTAMA (Kunci Kalender) -->
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Form <small class="text-muted">(Bisa Range)</small></label>
                                <input type="text" name="tanggal_dokumen" id="tanggalDokumen" class="form-control fw-bold text-primary border-primary bg-white locked-date" required placeholder="Pilih tanggal pelaksanaan" readonly onkeydown="return false;">
                            </div>
                            
                            <!-- KOTA TUJUAN UMUM -->
                            <div class="col-md-6">
                                <label class="form-label">Kota Tujuan <small class="text-success fw-bold">(Auto-Detect Wilayah)</small></label>
                                <input type="text" name="kota_tujuan" id="kotaTujuanGlobal" class="form-control border-success" required placeholder="Ketik nama kota (misal: Bandung / Semarang)">
                            </div>

                            <div class="col-md-12 mt-4">
                                <label class="form-label fw-bold text-primary">Pilih Jenis Form yang Akan Dibuat:</label>
                                <select class="form-select form-select-lg" name="jenis_form" id="jenisFormSelect" required>
                                    <option value="" selected disabled>-- Pilih Form Dinas --</option>
                                    <option value="pra_tugas">1. Form Pra Tugas Dinas</option>
                                    <option value="pasca_tugas">2. Form Pasca Tugas Dinas</option>
                                    <option value="uang_makan">3. Form Uang Makan</option>
                                    <option value="undangan_dinas">4. Form Pasca Undangan Dinas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2A. Detail Form Pra Tugas -->
                <div class="card mb-4 form-section" id="section_pra_tugas">
                    <div class="card-header bg-success text-white fw-bold">Rencana Kegiatan (Pra Tugas)</div>
                    <div class="card-body">
                        <table class="table table-bordered" id="tablePraTugas">
                            <thead class="table-light">
                                <tr>
                                    <th width="25%">Tanggal (Harian)</th>
                                    <th>Rencana Kegiatan</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                      <!-- UBAH INI -->
<button type="submit" class="btn btn-primary px-5 fw-bold">Lihat Preview Form</button>
                    </div>
                </div>

                <!-- 2B. Detail Form Pasca Tugas -->
                <div class="card mb-4 form-section" id="section_pasca_tugas">
                    <div class="card-header bg-info text-dark fw-bold">Realisasi Kegiatan (Pasca Tugas)</div>
                    <div class="card-body">
                        <table class="table table-bordered mb-0" id="tablePascaTugas">
                            <thead class="table-light">
                                <tr>
                                    <th width="20%">Tanggal (Harian)</th>
                                    <th>Realisasi Kegiatan</th>
                                    <th width="20%">Uang Tugas <small class="text-success">(Auto)</small></th>
                                    <th width="8%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-end fw-bold align-middle">TOTAL UANG TUGAS:</td>
                                    <td><input type="text" id="totalPascaTugas" class="form-control text-primary fw-bold bg-light" readonly placeholder="Rp 0"></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="mt-3">
                            <button type="button" class="btn btn-outline-info btn-sm" onclick="tambahBaris('tablePascaTugas', 'pasca')">+ Tambah Baris</button>
                        </div>
                    </div>
                </div>

                <!-- 2C. Detail Form Uang Makan -->
                <div class="card mb-4 form-section" id="section_uang_makan">
                    <div class="card-header bg-warning text-dark fw-bold">Rincian Uang Makan & Snack</div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0" id="tableUangMakan">
                            <thead class="table-light text-center">
                                <tr>
                                    <th width="15%">Keterangan</th>
                                    <th width="15%">Kota <small class="text-success">(Auto)</small></th>
                                    <th>Tanggal</th>
                                    <th width="8%">Hari</th>
                                    <th width="15%">Nominal</th>
                                    <th width="15%">Total (Rp)</th>
                                    <!-- Kolom Aksi sudah dihapus dari sini -->
                                </tr>
                            </thead>
                            <!-- Tbody Grup -->
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end fw-bold align-middle">GRAND TOTAL MAKAN & SNACK:</td>
                                    <td><input type="text" id="grandTotalUM" class="form-control text-primary fw-bold bg-light" readonly placeholder="Rp 0"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- 2D. Detail Form Pasca Undangan Dinas -->
                <div class="card mb-4 form-section" id="section_undangan_dinas">
                    <div class="card-header bg-secondary text-white fw-bold">Realisasi Kegiatan (Undangan Dinas Khusus)</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Pelaksanaan</label>
                                <input type="text" name="undangan_tgl" class="form-control date-range-undangan bg-white locked-date" placeholder="Misal: 15-16 Ags" readonly onkeydown="return false;">
                            </div>
                            <div class="col-md-8">
                                <!-- DROPDOWN PINTAR KALENDER PABRIK -->
                                <label class="form-label fw-bold text-primary">Kategori Hari Pelaksanaan</label>
                                <select id="pilihKategoriHari" class="form-select border-primary">
                                    <option value="" disabled selected>-- Pilih Jenis Hari --</option>
                                    <option value="200000">Hari Kerja (Biasa / Jumat Pas Masuk)</option>
                                    <option value="300000">Hari Libur (Jumat Normal / Rabu Kliwon / Kamis Pon)</option>
                                </select>
                                <small class="text-danger fw-bold">*Kerja = Rp 200.000 flat | Libur = Rp 300.000 flat</small>
                            </div>
                            
                            <div class="col-md-8">
                                <label class="form-label">Realisasi Kegiatan</label>
                                <textarea name="undangan_kegiatan" class="form-control" rows="3" placeholder="Tulis rincian kegiatan..."></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Uang Tugas (Terisi Otomatis)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <!-- Input ini di-readonly biar nggak bisa diakali petugas -->
                                    <input type="number" name="undangan_uang" id="undanganUang" class="form-control fw-bold text-success bg-light" readonly placeholder="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="reset" class="btn btn-light me-md-2 border">Reset Form</button>
                    <button type="submit" class="btn btn-primary px-5 fw-bold">Simpan Data & Cetak Form</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
    

   // DETEKSI KOTA -> WILAYAH (100% SESUAI ATURAN COVERAGE AREA KANTOR)
    function autoDeteksiWilayah(kotaInput) {
        let k = kotaInput.toLowerCase();
        
        // 1. KUDUS
        if (k.includes('kudus')) return 'Kudus';
        
        // 2. KARESIDENAN PATI
        let karsPati = ['jepara', 'pati', 'rembang', 'blora'];
        if (karsPati.some(c => k.includes(c))) return 'Kars. Pati';
        
        // 3. JATENG & DIY (Termasuk Pacitan yang masuk coverage Jateng 3)
        let jatengDiy = [
            'demak', 'grobogan', 'purwodadi', 'semarang', 'salatiga', 'kendal', 
            'batang', 'pekalongan', 'tegal', 'brebes', 'pemalang', 'banyumas', 
            'purwokerto', 'purbalingga', 'cilacap', 'kebumen', 'temanggung', 
            'wonosobo', 'banjarnegara', 'surakarta', 'solo', 'karanganyar', 
            'sragen', 'boyolali', 'klaten', 'sukoharjo', 'magelang', 'purworejo', 
            'yogjakarta', 'yogyakarta', 'jogja', 'bantul', 'sleman', 'kulon progo', 
            'wonogiri', 'gunung kidul', 'pacitan'
        ];
        if (jatengDiy.some(c => k.includes(c))) return 'Jateng & DIY';
        
        // 4. JATIM & MADURA
        let jatim = [
            'malang', 'batu', 'pasuruan', 'lumajang', 'probolinggo', 'jember', 
            'bondowoso', 'situbondo', 'banyuwangi', 'sampang', 'pamekasan', 
            'sumenep', 'bangkalan', 'sidoarjo', 'surabaya', 'gresik', 'jombang', 
            'mojokerto', 'lamongan', 'babat', 'bojonegoro', 'tuban', 'nganjuk', 
            'kediri', 'tulungagung', 'blitar', 'trenggalek', 'madiun', 'ponorogo', 
            'ngawi', 'magetan'
        ];
        if (jatim.some(c => k.includes(c))) return 'Jatim & Madura';
        
        // 5. JABAR & DKI (DKI 1 & DKI 2)
        let jabarDki = [
            'jakarta', 'seribu', 'depok', 'bekasi', 'bogor', 'pandeglang', 'serang', 
            'cilegon', 'karawang', 'tangerang', 'bandung', 'cimahi', 'garut', 
            'sumedang', 'ciamis', 'pangandaran', 'tasikmalaya', 'banjar', 'cianjur', 
            'sukabumi', 'cirebon', 'kuningan', 'majalengka', 'indramayu', 'purwakarta', 'subang'
        ];
        if (jabarDki.some(c => k.includes(c))) return 'Jabar & DKI';
        
        // 6. LUAR JAWA (Data Kantor + Backup Umum)
        let luarJawa = [
            // Dari List Kantor
            'banjarmasin', 'tanah laut', 'pangkalan bun', 'kotawari', 'bali', 
            'denpasar', 'lombok', 'lampung', 'jambi', 'sarolangun', 'pekanbaru', 
            'rokanhilir', 'indragiri hulu', 'indragiri hilir', 
            // Backup Kota Luar Jawa Lainnya biar tetep aman
            'medan', 'padang', 'palembang', 'batam', 'bengkulu', 'aceh', 
            'pangkalpinang', 'tanjungpinang', 'dumai', 'bukittinggi', 'lubuklinggau', 
            'pontianak', 'samarinda', 'balikpapan', 'palangkaraya', 'tarakan', 
            'banjarbaru', 'singkawang', 'bontang', 'makassar', 'manado', 'palu', 
            'kendari', 'bitung', 'gorontalo', 'palopo', 'baubau', 'parepare', 
            'mataram', 'kupang', 'bima', 'ambon', 'ternate', 'jayapura', 'sorong', 
            'manokwari', 'papua', 'maluku', 'sumatera', 'kalimantan', 'sulawesi', 'riau'
        ];
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
        dateFormat: "d M Y", 
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
            
            // Opsional: Otomatis isi tanggal di Form Uang Makan
            $('.date-range-um').val(dateStr);
            if(selectedDates.length === 2) {
                let diffTime = Math.abs(selectedDates[1] - selectedDates[0]);
                let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                $('.um-hari-makan').val(diffDays).trigger('change');
            } else if (selectedDates.length === 1) {
                $('.um-hari-makan').val(1).trigger('change');
            }
            $('.tgl-snack').val(dateStr);
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

    $('#jenisFormSelect').on('change', function() {
        $('.form-section').removeClass('active');
        let val = $(this).val();
        if(val) $('#section_' + val).addClass('active');
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

    const lockAttr = 'readonly onkeydown="return false;" autocomplete="off" class="form-control locked-date bg-white';

    function tambahBaris(tableId, tipe) {
        let tbody = '';
        if(tipe === 'pra') {
            tbody = `<tr>
                        <td><input type="text" name="pra_tgl[]" ${lockAttr} date-single" placeholder="Pilih tgl"></td>
                        <td><input type="text" name="pra_kegiatan[]" class="form-control" placeholder="Rencana aktivitas..."></td>
                        <td class="align-middle"><button type="button" class="btn btn-danger btn-sm w-100 btn-hapus-single-pra">Hapus</button></td>
                     </tr>`;
            $('#' + tableId + ' tbody').append(tbody);
            initDatePickerChild($('#' + tableId + ' tbody').find('tr:last'));
        
        } else if(tipe === 'pasca') {
            tbody = `<tr>
                        <td><input type="text" name="pasca_tgl[]" ${lockAttr} date-single" placeholder="Pilih tgl"></td>
                        <td><input type="text" name="pasca_kegiatan[]" class="form-control" placeholder="Realisasi aktivitas..."></td>
                        <td>
                            <!-- d-none dihapus agar dropdown terlihat -->
                            <select class="form-select form-select-sm mb-1 row-wilayah text-primary fw-bold"><option value="" disabled selected>Pilih Wilayah</option>${optionsWilayah}</select>
                            <input type="text" name="pasca_uang[]" class="form-control uang-tugas text-success px-2 bg-light fw-bold" readonly placeholder="Auto">
                        </td>
                        <td class="align-middle"><button type="button" class="btn btn-danger btn-sm w-100 btn-hapus-single-pasca">Hapus</button></td>
                     </tr>`;
            $('#' + tableId + ' tbody').append(tbody);
            initDatePickerChild($('#' + tableId + ' tbody').find('tr:last'));
        
        } else if(tipe === 'um') {
            tbody = `<tbody class="um-group border-bottom border-dark">
                        <tr>
                            <td><input type="text" name="um_ket[]" class="form-control fw-bold border-0 bg-transparent px-1" value="Uang Makan" readonly></td>
                            <td><input type="text" name="um_kota[]" class="form-control input-kota-um px-1 border-primary" placeholder="Ketik Kota..."></td>
                            <td><input type="text" name="um_tgl[]" ${lockAttr} date-range-um px-1" placeholder="Pilih tgl"></td>
                            <td><input type="number" name="um_hari[]" class="form-control um-hari-makan text-center px-1 fw-bold bg-light" readonly placeholder="0"></td>
                            <td>
                                <!-- d-none dihapus agar dropdown terlihat -->
                                <select class="form-select form-select-sm mb-1 row-wilayah text-primary fw-bold"><option value="" disabled selected>Pilih Wilayah</option>${optionsWilayah}</select>
                                <input type="text" name="um_nominal[]" class="form-control um-nominal text-success fw-bold bg-light px-1" readonly placeholder="Auto">
                            </td>
                            <td class="align-middle"><input type="text" name="um_total[]" class="form-control um-total fw-bold bg-light px-1 text-primary" readonly></td>
                        </tr>
                        <tr class="bg-snack">
                            <td><input type="text" name="um_ket[]" class="form-control fw-bold border-0 bg-transparent text-secondary px-1" value="Uang Snack" readonly></td>
                            <td><input type="text" name="um_kota[]" class="form-control kota-snack border-0 bg-transparent text-secondary px-1" readonly placeholder="-"></td>
                            <td><input type="text" name="um_tgl[]" class="form-control tgl-snack border-0 bg-transparent text-secondary px-1" readonly placeholder="-"></td>
                            <td><input type="number" name="um_hari[]" class="form-control text-center border-0 bg-transparent text-secondary px-1" value="1" readonly></td>
                            <td><input type="number" name="um_nominal[]" class="form-control um-nominal-snack fw-bold text-success bg-light px-1" value="40000" readonly></td>
                            <td class="align-middle"><input type="text" name="um_total[]" class="form-control um-total-snack fw-bold border-0 bg-transparent px-1 text-primary" value="40000" readonly></td>
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

    // ===============================================
    // FITUR BARU: AUTO-SYNC KOTA (TANPA REFRESH)
    // ===============================================
    $('#kotaTujuanGlobal').on('keyup blur', function() {
        let kota = $(this).val();
        let deteksiWilayah = autoDeteksiWilayah(kota);
        
        // 1. Paksa timpa nama kota di tabel Uang Makan
        $('#tableUangMakan .input-kota-um').val(kota).trigger('blur');
        
        // 2. Paksa update wilayah di Pasca Tugas
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

    // ===============================================
    // FITUR BARU: AUTO-SYNC JABATAN (TANPA REFRESH)
    // ===============================================
    $('#jabatanSelect').on('change', function() {
        // Saat jabatan diganti, pancing ulang kolom wilayah biar nominalnya dikalkulasi ulang!
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
        initDatePickerChild(); 
        tambahBaris('tablePraTugas', 'pra');
        tambahBaris('tablePascaTugas', 'pasca');
        tambahBaris('tableUangMakan', 'um');
    });
</script>
</body>
</html>