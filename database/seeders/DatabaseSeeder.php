<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Memanggil RoleSeeder untuk menambahkan roles
        $this->call(RoleSeeder::class);
    }
}