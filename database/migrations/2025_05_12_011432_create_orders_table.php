<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id'); // Primary key
            $table->unsignedBigInteger('car_id'); // Foreign key ke tabel cars
            $table->unsignedBigInteger('cust_id'); // Foreign key ke tabel customers
            $table->decimal('total_price', 10, 2); // Total harga
            $table->string('payment_method'); // Metode pembayaran
            $table->string('payment_status'); // Status pembayaran
            $table->timestamps(); // created_at dan updated_at

            // Foreign key constraints
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
            $table->foreign('cust_id')->references('cust_id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}