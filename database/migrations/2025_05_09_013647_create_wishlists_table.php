<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('cust_id'); // Foreign key ke tabel users
            $table->unsignedBigInteger('car_id');  // Foreign key ke tabel cars
            $table->timestamps(); // Timestamps (created_at dan updated_at)

            // Definisi foreign key
            $table->foreign('cust_id')->references('cust_id')->on('customers')->onDelete('cascade');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wishlists');
    }
}
