<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropForeign(['pembeli_id']); // Hapus foreign key lama
            $table->renameColumn('pembeli_id', 'pelanggan_id'); // Ubah nama kolom
            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade'); // Tambahkan foreign key baru
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropForeign(['pelanggan_id']); // Hapus foreign key baru
            $table->renameColumn('pelanggan_id', 'pembeli_id'); // Ubah kembali ke nama lama
            $table->foreign('pembeli_id')->references('id')->on('pembeli')->onDelete('cascade'); // Tambahkan foreign key lama
        });
    }
};
