<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id('installment_id'); // Primary key
            $table->unsignedBigInteger('order_id'); // Foreign key ke tabel orders
            $table->date('due_date'); // Tanggal jatuh tempo cicilan
            $table->decimal('amount', 15, 2); // Jumlah cicilan
            $table->enum('status', ['unpaid', 'paid', 'late'])->default('unpaid'); // Status cicilan
            $table->timestamp('paid_at')->nullable(); // Tanggal cicilan dibayar
            $table->timestamps(); // created_at dan updated_at

            // Foreign key constraints
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade'); // Menghubungkan dengan orders
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('installments');
    }
}
