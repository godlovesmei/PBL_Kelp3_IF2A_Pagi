<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand', 'model', 'year', 'image', 'category', 
        'specifications', 'price', 'stock', 'car_code'
    ];
    

    // Relasi ke tabel car_colors
    public function colors()
    {
        return $this->hasMany(CarColor::class);
    }

    // Event saat membuat data baru
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($car) {
            $brand = strtoupper(substr($car->brand, 0, 3)); // 3 huruf pertama brand
            $year = substr($car->year, -2); // 2 digit terakhir tahun
            $category = strtoupper(substr($car->category, 0, 3)); // 3 huruf pertama kategori

            // Ambil jumlah mobil yang ada untuk ID (dengan padding 3 digit)
            $count = Car::count() + 1;
            $id_padded = str_pad($count, 3, '0', STR_PAD_LEFT);

            $car->car_code = "{$brand}-{$year}-{$category}-{$id_padded}";
        });
    }
}
