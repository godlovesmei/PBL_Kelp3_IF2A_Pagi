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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id'); // Primary key untuk users
            $table->string('name'); // Nama user
            $table->string('email')->unique(); // Email user (unik)
            $table->string('password'); // Password user
            $table->string('phone')->nullable(); // Nomor telepon (opsional)
            $table->text('address')->nullable(); // Alamat user (opsional)
            $table->unsignedBigInteger('role_id'); // Foreign key ke tabel roles
            $table->timestamps();

            // Definisi foreign key
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};