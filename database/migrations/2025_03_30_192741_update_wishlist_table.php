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
        Schema::table('wishlist', function (Blueprint $table) {
            // Tambahkan foreign key pelanggan_id jika belum ada
            if (!Schema::hasColumn('wishlist', 'pelanggan_id')) {
                $table->foreignId('pelanggan_id')->constrained('pelanggan')->onDelete('cascade');
            }

            // Tambahkan kolom kode_mobil jika belum ada
            if (!Schema::hasColumn('wishlist', 'kode_mobil')) {
                $table->string('kode_mobil');
                $table->foreign('kode_mobil')->references('kode_mobil')->on('mobil')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wishlist', function (Blueprint $table) {
            $table->dropForeign(['pelanggan_id']);
            $table->dropColumn('pelanggan_id');

            $table->dropForeign(['kode_mobil']);
            $table->dropColumn('kode_mobil');
        });
    }
};
