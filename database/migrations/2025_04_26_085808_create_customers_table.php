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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('cust_id'); // Primary key untuk CUSTOMERS
            $table->string('salary'); // Path atau URL foto slip gaji (opsional)
            $table->string('ktp'); // Path atau URL foto KTP (opsional)
            $table->string('npwp'); // Path atau URL foto NPWP (opsional)
            $table->unsignedBigInteger('user_id'); // Foreign key ke tabel USERS
            $table->timestamps();

            // Definisi foreign key
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};