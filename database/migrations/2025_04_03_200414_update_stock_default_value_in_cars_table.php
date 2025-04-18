<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStockDefaultValueInCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            // Mengubah kolom 'stock' agar tidak memiliki default value
            $table->integer('stock')->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            // Mengembalikan kolom 'stock' ke default value 0 jika rollback
            $table->integer('stock')->default(null)->change();
        });
    }
} 
