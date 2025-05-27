<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cust_id',
        'car_id',
    ];

    /**
     * Relasi ke model Customer.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'cust_id');
    }

    /**
     * Relasi ke model Car.
     */
    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id', 'id');
    }
}