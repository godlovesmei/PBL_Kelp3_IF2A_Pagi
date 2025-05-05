<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHexToCarColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_colors', function (Blueprint $table) {
            $table->string('hex', 7)->nullable()->after('color_name'); // Tambahkan kolom 'hex'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_colors', function (Blueprint $table) {
            $table->dropColumn('hex'); // Hapus kolom 'hex' jika rollback
        });
    }
}