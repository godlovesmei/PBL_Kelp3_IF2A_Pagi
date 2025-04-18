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
        Schema::create('cars', function (Blueprint $table) {
            $table->id(); // Default auto-increment ID sebagai primary key
            $table->string('car_code')->unique(); // Kode mobil sebagai unique key
            $table->string('brand'); // Merek mobil
            $table->string('model'); // Model mobil
            $table->year('year'); // Tahun produksi
            $table->string('image'); // Gambar mobil
            $table->enum('category', ['City Car & Hatchback', 'MPV', 'Sedan', 'Sports', 'SUV']); // Kategori mobil
            $table->text('specifications'); // Spesifikasi mobil
            $table->string('color'); // Warna mobil
            $table->decimal('price', 15, 2); // Harga mobil
            $table->integer('stock')->default(0);
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
