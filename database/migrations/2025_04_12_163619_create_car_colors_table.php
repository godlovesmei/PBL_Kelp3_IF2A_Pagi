<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('car_colors', function (Blueprint $table) {
        $table->id();  // ID otomatis
        $table->foreignId('car_id')->constrained('cars')->onDelete('cascade'); // Relasi dengan tabel cars
        $table->string('color_name', 50);  // Nama warna mobil
        $table->string('image_path');  // Path gambar warna
        $table->timestamps();  // created_at dan updated_at
    });
}

public function down()
{
    Schema::dropIfExists('car_colors');
}

};
