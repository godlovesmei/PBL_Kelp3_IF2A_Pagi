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
            $table->decimal('total_price', 15, 2); // Total harga mobil
            $table->enum('payment_method', ['cash', 'credit'])->default('cash'); // Metode pembayaran
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid'); // Status pembayaran
            $table->enum('order_status', ['pending', 'approved', 'processing', 'shipped', 'completed'])->default('pending'); // Status pesanan
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