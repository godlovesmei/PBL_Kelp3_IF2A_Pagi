<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('mobil', function (Blueprint $table) {
            $table->string('stok', 100)->after('harga'); // Tambah kolom setelah 'harga'
        });
    }

    public function down()
    {
        Schema::table('mobil', function (Blueprint $table) {
            $table->dropColumn('stok'); // Hapus kolom saat rollback
        });
    }
};
