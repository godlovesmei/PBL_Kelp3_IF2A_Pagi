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
        Schema::create('mobil', function (Blueprint $table) {
            $table->string('kode_mobil')->primary(); // Kode mobil sebaiknya string karena bisa mengandung huruf dan angka
            $table->string('merek'); // Nama merek tetap string
            $table->string('model'); // Nama model tetap string
            $table->year('tahun'); // Menggunakan tipe year untuk tahun produksi
            $table->string('gambar'); // URL atau path gambar tetap string
            $table->enum('kategori', ['SUV', 'Sedan', 'Hatchback', 'MPV', 'Convertible'])->nullable();
            $table->text('spesifikasi'); // Menggunakan text karena bisa berisi banyak detail
            $table->string('warna'); // Warna tetap string
            $table->decimal('harga', 15, 2); // Harga lebih baik menggunakan decimal untuk menyimpan angka desimal dengan presisi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};
