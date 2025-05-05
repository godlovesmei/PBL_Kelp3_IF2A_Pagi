<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAltHexToCarColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_colors', function (Blueprint $table) {
            $table->string('alt_hex', 7)->nullable()->after('hex'); // Tambahkan kolom 'alt_hex'
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
            $table->dropColumn('alt_hex'); // Hapus kolom 'alt_hex' jika rollback
        });
    }
}