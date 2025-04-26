<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->primary(); // Primary Key dan Foreign Key
            $table->string('phone', 20)->nullable(); // Nomor telepon
            $table->text('address')->nullable(); // Alamat
            $table->string('photo')->nullable(); // Foto profil (nama file)
            $table->string('ktp_file')->nullable(); // File KTP (nama file)
            $table->string('npwp_file')->nullable(); // File NPWP (nama file)
            $table->string('kk_file')->nullable(); // File KK (nama file)
            $table->string('salary_slip_file')->nullable(); // File slip gaji (nama file)
            $table->timestamps(); // Kolom created_at dan updated_at

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_documents');
    }
}