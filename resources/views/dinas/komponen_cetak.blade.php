<!-- JUDUL OTOMATIS -->
<div class="form-title">
    @if($dinas->jenis_form == 'pra_tugas') FORM PRA TUGAS DINAS LUAR KOTA 
    @elseif($dinas->jenis_form == 'pasca_tugas') FORM PASCA TUGAS DINAS LUAR KOTA
    @elseif($dinas->jenis_form == 'uang_makan') FORM UANG MAKAN TUGAS LUAR KOTA
    @elseif($dinas->jenis_form == 'undangan_dinas') FORM PASCA UNDANGAN DINAS
    @endif
</div>

<!-- HEADER BIODATA -->
<table class="meta-info">
    <tr>
        <td style="width: 70px;">Nama</td>
        <td style="width: 15px;">:</td>
        <td class="meta-val" style="width: 300px;">{{ $dinas->nama }}</td>
        <td style="width: 70px;"></td>
        <td style="width: 15px;"></td>
        <td class="meta-val"></td>
    </tr>
    <tr>
        <td>Divisi</td>
        <td>:</td>
        <td class="meta-val">{{ $dinas->divisi }}</td>
        <td>Tanggal</td>
        <td>:</td>
        <td class="meta-val">{{ $dinas->tanggal_dokumen }}</td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td class="meta-val">{{ $dinas->jabatan }}</td>
        <td>Kota</td>
        <td>:</td>
        <td class="meta-val">{{ $dinas->kota_tujuan }}</td>
    </tr>
</table>

@php $data = is_array($dinas->detail_data) ? $dinas->detail_data : (array) $dinas->detail_data; @endphp

<!-- 1. TABEL PRA TUGAS -->
@if($dinas->jenis_form == 'pra_tugas')
<table class="data-table">
    <thead>
        <tr><th style="width: 5%;">NO</th><th style="width: 20%;">TANGGAL</th><th style="width: 75%;">RENCANA KEGIATAN</th></tr>
    </thead>
    <tbody>
        @if(isset($data['pra_tgl']))
            @foreach($data['pra_tgl'] as $index => $tgl)
            <tr>
                <td class="align-top" style="height: 32px;">{{ $index + 1 }}</td>
                <td class="align-top">{{ $tgl }}</td>
                <td class="text-left align-top">{{ $data['pra_kegiatan'][$index] ?? '-' }}</td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>

<!-- 2. TABEL PASCA TUGAS -->
@elseif($dinas->jenis_form == 'pasca_tugas')
<table class="data-table">
    <thead>
        <tr><th style="width: 5%;">NO</th><th style="width: 15%;">TANGGAL</th><th style="width: 55%;">REALISASI KEGIATAN</th><th style="width: 25%;">UANG TUGAS</th></tr>
    </thead>
    <tbody>
        @php $totalPasca = 0; @endphp
        @if(isset($data['pasca_tgl']))
            @foreach($data['pasca_tgl'] as $index => $tgl)
            @php $totalPasca += (float) ($data['pasca_uang'][$index] ?? 0); @endphp
            <tr>
                <td class="align-top" style="height: 32px;">{{ $index + 1 }}</td>
                <td class="align-top">{{ $tgl }}</td>
                <td class="text-left align-top">{{ $data['pasca_kegiatan'][$index] ?? '-' }}</td>
                <td class="align-top" style="text-align: left; padding-left: 8px;">Rp {{ number_format((float)($data['pasca_uang'][$index] ?? 0), 0, ',', '.') }}</td>
            </tr>
            @endforeach
        @endif
        <tr>
            <td colspan="3" style="text-align: center; font-weight: bold; height: 32px;">TOTAL</td>
            <td style="text-align: left; padding-left: 8px; font-weight:bold;">Rp {{ number_format($totalPasca, 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>
<div class="note">*Kolom kegiatan meliputi rincian kegiatan perhari dan dilampiri foto</div>

<!-- 3. TABEL UANG MAKAN -->
@elseif($dinas->jenis_form == 'uang_makan')
<table class="data-table">
    <thead>
        <tr><th style="width: 5%;">NO</th><th style="width: 25%;">KETERANGAN</th><th style="width: 15%;">KOTA</th><th style="width: 15%;">TANGGAL</th><th style="width: 10%;">JUMLAH<br>HARI</th><th style="width: 15%;">NOMINAL</th><th style="width: 15%;">TOTAL</th></tr>
    </thead>
    <tbody>
        @php $grandTotal = 0; @endphp
        @if(isset($data['um_tgl']))
            @foreach($data['um_tgl'] as $index => $tgl)
            @php $grandTotal += (float) ($data['um_total'][$index] ?? 0); @endphp
            <tr>
                <td class="align-top" style="height: 38px;">{{ $index + 1 }}</td>
                <td class="text-left align-top">{{ $data['um_ket'][$index] ?? '-' }}</td>
                <td class="text-left align-top">{{ $data['um_kota'][$index] ?? '-' }}</td>
                <td class="align-top">{{ $tgl }}</td>
                <td class="align-top">{{ $data['um_hari'][$index] ?? '-' }}</td>
                <td class="align-top" style="text-align: left; padding-left: 8px;">Rp {{ number_format((float)($data['um_nominal'][$index] ?? 0), 0, ',', '.') }}</td>
                <td class="align-top" style="text-align: left; padding-left: 8px;">Rp {{ number_format((float)($data['um_total'][$index] ?? 0), 0, ',', '.') }}</td>
            </tr>
            @endforeach
        @endif
        <tr>
            <td colspan="6" style="text-align: center; font-weight: bold; height: 38px;">TOTAL</td>
            <td style="text-align: left; padding-left: 8px; font-weight:bold;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>
<div class="note">*Kolom keterangan diisi uang makan dan uang snack</div>

<!-- 4. TABEL UNDANGAN DINAS -->
@elseif($dinas->jenis_form == 'undangan_dinas')
<table class="data-table">
    <thead>
        <tr><th style="width: 15%;">TANGGAL</th><th style="width: 60%;">REALISASI KEGIATAN</th><th style="width: 25%;">UANG TUGAS</th></tr>
    </thead>
    <tbody>
        <tr>
            <td class="align-top" style="height: 60px;">{{ $data['undangan_tgl'] ?? '-' }}</td>
            <td class="text-left align-top">{{ $data['undangan_kegiatan'] ?? '-' }}</td>
            <td class="align-top" style="text-align: left; padding-left: 8px;">Rp {{ number_format((float)($data['undangan_uang'] ?? 0), 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>
<div class="note">*Kolom kegiatan meliputi rincian kegiatan dan dilampiri foto</div>
@endif

<!-- TANDA TANGAN (Otomatis Hilang Kiri untuk Uang Makan) -->
<div class="signature-table">
    <div class="sig-cell">
        @if($dinas->jenis_form != 'uang_makan')
        <div class="sig-box">
            <div class="sig-date"></div>
            <div class="sig-title">Manager / Kabag /<br>Kasi / Kapel</div>
            <div class="sig-space"></div>
            <div class="sig-line"></div>
        </div>
        @endif
    </div>
    <div class="sig-cell">
        <div class="sig-box">
            <div class="sig-date">Kudus, {{ date('d F Y') }}</div>
            <div class="sig-title">Petugas</div>
            <div class="sig-space"></div>
            <div class="sig-line"></div>
            <div style="margin-top: 5px; font-weight: normal;">({{ $dinas->nama }})</div>
        </div>
    </div>
</div>