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
            $table->id(); // Kolom id (Primary Key dengan AUTO_INCREMENT)
            $table->unsignedBigInteger('customer_id'); // Kolom customer_id (Foreign Key)
            $table->unsignedBigInteger('car_id'); // Kolom car_id (Foreign Key)
            $table->timestamps(); // Kolom created_at dan updated_at

            // Menambahkan index
            $table->index('customer_id'); // Index untuk customer_id
            $table->index('car_id'); // Index untuk car_id
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