<?php

namespace Database\Seeders;  // Pastikan namespace ini sesuai

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Tambahkan role customer dan dealer
        Role::create(['role_name' => 'customer']);
        Role::create(['role_name' => 'dealer']);
    }
}
