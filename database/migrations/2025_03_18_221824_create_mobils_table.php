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
        Schema::create('mobils', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mobil'); // Nama mobil
            $table->integer('tahun'); // Tahun produksi
            $table->decimal('harga', 15, 2); // Harga mobil (max 15 digit, 2 desimal)
            $table->text('deskripsi')->nullable(); // Deskripsi opsional
            $table->string('gambar')->nullable(); // URL gambar mobil (opsional)
            $table->enum('status', ['tersedia', 'terjual'])->default('tersedia'); // Status mobil
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};
