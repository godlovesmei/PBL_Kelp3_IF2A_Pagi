<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembeli', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('nama');
            $table->string('username');
            $table->string('password');
            $table->string('no_hp'); // Perbaikan tipe data
            $table->string('alamat');
            $table->string('foto_profil');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembeli');
    }
};
