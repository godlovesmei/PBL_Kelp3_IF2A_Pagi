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
        Schema::create('identitas_pelanggan', function (Blueprint $table) {
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->onDelete('cascade')->primary(); // PK & FK
            $table->string('ktp')->nullable();
            $table->string('npwp')->nullable();
            $table->string('slip_gaji')->nullable();
            $table->string('kk')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identitas_pelanggan');
    }
};
