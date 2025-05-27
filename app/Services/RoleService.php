<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    /**
     * Mendapatkan semua role
     */
    public function getAllRoles()
    {
        return Role::all();
    }

    /**
     * Mendapatkan role berdasarkan ID
     */
    public function getRoleById($id)
    {
        return Role::find($id);
    }
}