<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'orders'; // ⬅ arahkan ke tabel yang benar

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'car_id',
        'cust_id',
        'total_price',
        'payment_method',
        'payment_status',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id');
    }
}