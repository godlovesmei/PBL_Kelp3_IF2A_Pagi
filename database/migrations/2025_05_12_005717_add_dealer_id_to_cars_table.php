<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDealerIdToCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            // Tambahkan kolom dealer_id
            $table->unsignedBigInteger('dealer_id')->after('id')->nullable();

            // Tambahkan foreign key yang menghubungkan dealer_id ke dealers.dealer_id
            $table->foreign('dealer_id')->references('dealer_id')->on('dealers')->onDelete('cascade');
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
            // Hapus foreign key terlebih dahulu
            $table->dropForeign(['dealer_id']);

            // Hapus kolom dealer_id
            $table->dropColumn('dealer_id');
        });
    }
}