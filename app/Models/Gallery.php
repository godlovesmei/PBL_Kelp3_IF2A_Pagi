<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    // Definisikan relasi many-to-one dengan tabel cars
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
