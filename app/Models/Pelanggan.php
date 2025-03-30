<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pembeli extends Authenticatable
{
    use Notifiable;

    protected $guard = 'pembeli';

    protected $fillable = [
        'username', 'email', 'password',
    ];

    protected $hidden = [
        'password',
    ];
}
