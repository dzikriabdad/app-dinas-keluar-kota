<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DinasController;

// Halaman Form Input, Preview & Simpan
Route::get('/', [DinasController::class, 'create'])->name('dinas.create');
Route::post('/preview', [DinasController::class, 'preview'])->name('dinas.preview');
Route::post('/simpan-cetak', [DinasController::class, 'store'])->name('dinas.store');

// Fitur Login Admin
Route::get('/admin/login', [DinasController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [DinasController::class, 'prosesLogin'])->name('admin.proses_login');
Route::get('/admin/logout', [DinasController::class, 'logout'])->name('admin.logout');

// Halaman Admin (Dilindungi Password)
Route::get('/admin', [DinasController::class, 'index'])->name('admin.dinas');
Route::delete('/admin/hapus/{id}', [DinasController::class, 'destroy'])->name('admin.hapus');
Route::get('/admin/export', [DinasController::class, 'export'])->name('admin.export');