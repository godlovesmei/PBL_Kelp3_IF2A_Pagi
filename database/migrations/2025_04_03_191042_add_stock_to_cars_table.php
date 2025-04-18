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
        Schema::table('cars', function (Blueprint $table) {
            // Menambahkan kolom stock setelah kolom price
            $table->integer('stock')->default(0)->after('price'); // Kolom stock setelah price
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // Menghapus kolom stock
            $table->dropColumn('stock');
        });
    }
};
