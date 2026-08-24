<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('form_dinas', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('divisi');
        $table->string('jabatan');
        $table->string('tanggal_dokumen'); // Untuk range tanggal utama
        $table->string('kota_tujuan');
        $table->string('jenis_form');
        $table->json('detail_data')->nullable(); // Untuk nyimpan tabel array dinamis
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_dinas');
    }
};
