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
        Schema::table('wishlist', function (Blueprint $table) {
            if (Schema::hasColumn('wishlist', 'pembeli_id')) {
                $table->dropForeign(['pembeli_id']);
                $table->dropColumn('pembeli_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wishlist', function (Blueprint $table) {
            $table->foreignId('pembeli_id')->constrained('pembeli')->onDelete('cascade');
        });
    }
};