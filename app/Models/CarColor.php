<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarColor extends Model
{
    use HasFactory;

    protected $fillable = ['car_id', 'color_name', 'hex', 'alt_hex', 'image_path']; // Sesuaikan dengan kolom tabel car_colors

    // Relasi banyak ke satu dengan mobil
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
