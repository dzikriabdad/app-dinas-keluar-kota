<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormDinas;
use Illuminate\Support\Facades\Auth; 

class DinasController extends Controller
{
    // 1. Tampilkan form input
    public function create() { 
        return view('dinas.input'); 
    }

    // 2. Tampilkan halaman Preview (Data belum masuk DB)
    public function preview(Request $request) {
        $dataUtama = $request->only(['nama', 'divisi', 'jabatan', 'tanggal_dokumen', 'kota_tujuan', 'jenis_form']);
        $dataDetail = $request->except(['_token', 'nama', 'divisi', 'jabatan', 'tanggal_dokumen', 'kota_tujuan', 'jenis_form']);

        // Bikin object sementara biar terbaca sama komponen cetak
        $dinas = (object) $dataUtama;
        $dinas->detail_data = $dataDetail;

        // Ambil data mentah untuk dikirim ulang form
        $rawData = $request->all();

        return view('dinas.preview', compact('dinas', 'rawData'));
    }

    // 3. Simpan ke DB & Tampilkan Cetak
    public function store(Request $request) {
        $dataUtama = $request->only(['nama', 'divisi', 'jabatan', 'tanggal_dokumen', 'kota_tujuan', 'jenis_form']);
        $dataDetail = $request->except(['_token', 'nama', 'divisi', 'jabatan', 'tanggal_dokumen', 'kota_tujuan', 'jenis_form']);

        $dinas = FormDinas::create([
            'nama'            => $dataUtama['nama'],
            'divisi'          => $dataUtama['divisi'],
            'jabatan'         => $dataUtama['jabatan'],
            'tanggal_dokumen' => $dataUtama['tanggal_dokumen'],
            'kota_tujuan'     => $dataUtama['kota_tujuan'],
            'jenis_form'      => $dataUtama['jenis_form'],
            'detail_data'     => $dataDetail,
        ]);
        
        return view('dinas.cetak', compact('dinas'));
    }

    // ==========================================
    // BAGIAN LOGIN & LOGOUT 
    // ==========================================
    public function login() {
        if(Auth::check()) return redirect()->route('admin.dinas');
        return view('dinas.login');
    }

    public function prosesLogin(Request $request) {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dinas');
        }
        return back()->with('error', 'Email atau Password Salah!');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    // ==========================================
    // BAGIAN FITUR ADMIN 
    // ==========================================
    public function index() {
        if(!Auth::check()) return redirect()->route('admin.login');
        
        $dataDinas = FormDinas::orderBy('created_at', 'desc')->get();
        return view('dinas.admin_rekap', compact('dataDinas'));
    }

    public function destroy($id) {
        if(!Auth::check()) return redirect()->route('admin.login');
        
        FormDinas::find($id)->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }

    public function export() {
        if(!Auth::check()) return redirect()->route('admin.login');

        $data = FormDinas::orderBy('created_at', 'desc')->get();
        $filename = "Rekap_Dinas_" . date('Y-m-d') . ".csv";
        
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $handle = fopen('php://output', 'w');
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
        
        $pemisah = ';'; 
        fputcsv($handle, ['No', 'Nama Pegawai', 'Divisi', 'Jabatan', 'Kota Tujuan', 'Tgl Pelaksanaan', 'Jenis Form', 'Waktu Submit'], $pemisah);
        
        $no = 1;
        foreach($data as $d) {
            fputcsv($handle, [
                $no++, $d->nama, $d->divisi, $d->jabatan, $d->kota_tujuan, $d->tanggal_dokumen, 
                strtoupper(str_replace('_', ' ', $d->jenis_form)), $d->created_at->format('d M Y H:i')
            ], $pemisah);
        }
        fclose($handle);
        exit;
    }
}