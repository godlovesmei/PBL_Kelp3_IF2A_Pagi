<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'image_path',
        'caption',
        'type',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id', 'id');
    }
}

