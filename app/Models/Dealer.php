<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;

    // Relasi dengan cars (satu dealer bisa memiliki banyak mobil)
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}