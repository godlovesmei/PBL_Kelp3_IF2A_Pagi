<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('pembeli', function (Blueprint $table) {
            $table->string('no_hp')->nullable()->change();
            $table->string('alamat')->nullable()->change();
            $table->string('foto_profil')->nullable()->change();
        });
    }

    public function down(): void {
        Schema::table('pembeli', function (Blueprint $table) {
            $table->string('no_hp')->nullable(false)->change();
            $table->string('alamat')->nullable(false)->change();
            $table->string('foto_profil')->nullable(false)->change();
        });
    }
};