<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Constants\RoleConstant;  // Import RoleConstant

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';  // Pastikan primary key menggunakan kolom 'user_id'

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Menambahkan role_id agar bisa diisi secara mass assignment
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi dengan tabel roles
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');  // 'role_id' di tabel 'users', 'id' di tabel 'roles'
    }

    /**
     * Metode untuk memeriksa apakah user memiliki role tertentu
     */
    public function hasRole($role): bool
    {
        // Periksa apakah role_id sesuai dengan konstanta RoleConstant
        return $this->role_id === $role;  // Bandingkan role_id dengan nilai dari RoleConstant
    }
}
