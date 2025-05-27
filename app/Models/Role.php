<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    /**
     * Primary key untuk tabel roles
     */
    protected $primaryKey = 'role_id';

    /**
     * Columns yang bisa diisi secara massal
     */
    protected $fillable = ['role_name'];

    /**
     * Relasi dengan tabel users
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }
}