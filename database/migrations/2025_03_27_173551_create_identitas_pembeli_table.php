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
        Schema::create('identitas_pembeli', function (Blueprint $table) {
            $table->foreignId('id_pembeli')->constrained('pembeli')->onDelete('cascade')->primary(); // PK & FK
            $table->string('ktp')->nullable(); // Bisa kosong
            $table->string('npwp')->nullable(); // Bisa kosong
            $table->string('slip_gaji')->nullable(); // Bisa kosong
            $table->string('kk')->nullable(); // Bisa kosong
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identitas_pembeli');
    }
};
