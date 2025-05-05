<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Menyatakan kolom yang bisa diisi (mass-assignment)
    protected $fillable = ['role_name'];  // Kolom 'name' untuk nama role seperti 'admin', 'user', dll

    /**
     * Relasi dengan tabel users
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');  // Relasi satu ke banyak (1 ke banyak)
    }
}
