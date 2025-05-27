<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand', 'model', 'year', 'image', 'category', 
        'specifications', 'price', 'stock', 'car_code', 
        'dealer_id',
    ];

    public function colors()
    {
        return $this->hasMany(CarColor::class);
    }

    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($car) {
            $brand = strtoupper(substr($car->brand, 0, 3));
            $year = substr($car->year, -2);
            $category = strtoupper(substr($car->category, 0, 3));
            $count = Car::count() + 1;
            $id_padded = str_pad($count, 3, '0', STR_PAD_LEFT);
            $car->car_code = "{$brand}-{$year}-{$category}-{$id_padded}";
        });
    }

    public function wishlists()
{
    return $this->hasMany(Wishlist::class, 'car_id', 'car_id');
}
}