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
    Schema::create('gallery', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('car_id'); // Menyimpan ID mobil yang berelasi
        $table->string('image_path'); // Menyimpan path gambar
        $table->string('caption')->nullable(); // Menyimpan caption gambar (opsional)
        $table->timestamps();

        // Foreign key constraint to cars table
        $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('gallery');
}

};
