<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Constants\RoleConstant;
use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Primary key untuk tabel users
     */
    protected $primaryKey = 'user_id';

    /**
     * Attributes yang bisa diisi secara massal
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',    // <--- Tambah ini
        'address',  // <--- Tambah ini
    ];

    /**
     * Attributes yang disembunyikan
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attributes yang perlu di-cast
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Boot method untuk mengatur default role_id
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->role_id)) {
                $user->role_id = RoleConstant::CUSTOMER; // Default role
            }
        });
    }

    /**
     * Relasi dengan tabel roles
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    /**
     * Method untuk memeriksa apakah user memiliki role tertentu
     */
    public function hasRole($role): bool
    {
        return $this->role && strtolower($this->role->role_name) === strtolower($role);
    }

    /**
     * Method untuk memeriksa apakah user adalah dealer
     */
    public function isDealer(): bool
    {
        return $this->hasRole('dealer');
    }

    /**
     * Method untuk memeriksa apakah user adalah customer
     */
    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }

    public function customer()
{
    return $this->hasOne(Customer::class, 'cust_id', 'user_id');
}

    /**
     * Kirim notifikasi reset password
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }
}