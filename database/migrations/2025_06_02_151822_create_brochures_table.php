<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brochures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dealer_id')->nullable();
            $table->string('title');
            $table->string('pdf_path');
            $table->string('image_path')->nullable();
            $table->decimal('size', 8, 2)->nullable();
            $table->timestamps();

            $table->foreign('dealer_id')->references('dealer_id')->on('dealers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brochures');
    }
};
