<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Dinas Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5 bg-light">
    <div class="container bg-white p-4 shadow-sm rounded">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0">Rekapitulasi Dinas Keluar Kota</h3>
            <a href="{{ route('admin.logout') }}" class="btn btn-danger btn-sm fw-bold"> Logout Admin</a>
        </div>

        <!-- Alert kalau sukses hapus data -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-3 d-flex gap-2">
            <a href="{{ route('dinas.create') }}" class="btn btn-outline-primary fw-bold">➕ Buat Form Baru</a>
            <a href="{{ route('admin.export') }}" class="btn btn-success fw-bold"> Download Excel (CSV)</a>
        </div>
        
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Nama Pegawai</th>
                    <th width="15%">Jabatan</th>
                    <th width="15%">Kota Tujuan</th>
                    <th width="15%">Tanggal Pelaksanaan</th>
                    <th width="15%">Jenis Form</th>
                    <th width="20%">Aksi</th> <!-- INI KOLOM TOMBOL HAPUSNYA -->
                </tr>
            </thead>
            <tbody>
                @forelse($dataDinas as $key => $d)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="fw-bold">{{ $d->nama }}</td>
                    <td>{{ $d->divisi }} - {{ $d->jabatan }}</td>
                    <td>{{ $d->kota_tujuan }}</td>
                    <td>{{ $d->tanggal_dokumen }}</td>
                    <td class="text-center">
                        <span class="badge bg-secondary">{{ strtoupper(str_replace('_', ' ', $d->jenis_form)) }}</span>
                    </td>
                    <td class="text-center">
                        <!-- INI TOMBOL HAPUSNYA -->
                        <form action="{{ route('admin.hapus', $d->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus form milik {{ $d->nama }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm fw-bold w-100">🗑️ Hapus Data</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted fw-bold">Belum ada data dinas yang tersimpan bulan ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Script untuk alert close -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>