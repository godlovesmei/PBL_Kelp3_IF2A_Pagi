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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id'); // Primary key untuk payments
            $table->unsignedBigInteger('order_id'); // Foreign key ke tabel orders
            $table->unsignedBigInteger('installment_id')->nullable(); // Foreign key ke tabel installments (nullable jika cash)
            $table->decimal('amount', 15, 2); // Jumlah pembayaran
            $table->date('payment_date'); // Tanggal pembayaran
            $table->string('payment_method'); // Metode pembayaran (transfer, cash, e-wallet, dll)
            $table->string('payment_proof')->nullable(); // Path bukti pembayaran (gambar atau PDF)
            $table->timestamps(); // created_at dan updated_at

            // Foreign key constraints
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade'); // Menghubungkan dengan tabel orders
            $table->foreign('installment_id')->references('installment_id')->on('installments')->onDelete('cascade'); // Menghubungkan dengan tabel installments (nullable jika cash)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
