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
        // Menambahkan kolom dealer_id sebagai foreign key
        $table->unsignedBigInteger('dealer_id')->nullable();

        // Menambahkan kolom slug
        $table->string('slug')->unique()->nullable();

        // Menambahkan foreign key constraint untuk dealer_id
        $table->foreign('dealer_id')->references('id')->on('dealers')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('cars', function (Blueprint $table) {
        // Menghapus foreign key dan kolom
        $table->dropForeign(['dealer_id']);
        $table->dropColumn(['dealer_id', 'slug']);
    });
}
};