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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mobil'); // Sesuaikan dengan tipe data di tabel mobil
            $table->foreign('kode_mobil')->references('kode_mobil')->on('mobil')->onDelete('cascade');
            $table->foreignId('pembeli_id')->constrained('pembeli')->onDelete('cascade');
            $table->integer('jumlah');
            $table->string('status');
            $table->integer('total_pembayaran');
            $table->enum('metode_pembayaran', ['lunas', 'kredit']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
