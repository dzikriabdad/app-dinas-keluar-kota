<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormDinas extends Model
{
    protected $table = 'form_dinas';
    
    // Tambahkan baris ini agar semua kolom diizinkan untuk disimpan
    protected $guarded = [];

    // Auto-convert Array ke JSON untuk data tabel dinamis
    protected $casts = [
        'detail_data' => 'array', 
    ];
}