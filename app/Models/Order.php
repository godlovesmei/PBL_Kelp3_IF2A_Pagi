<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id'; // Menetapkan primary key untuk tabel orders

    protected $fillable = [
        'car_id',
        'cust_id',
        'total_price',
        'payment_method',
        'payment_status',
        'order_status',
    ];

    // Relasi dengan Installment
    public function installments()
    {
        return $this->hasMany(Installment::class, 'order_id');
    }

    // Relasi dengan Payment
    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id');
    }

    // Relasi dengan Car (menghubungkan dengan tabel cars)
    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    // Relasi dengan Customer (menghubungkan dengan tabel customers)
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id');
    }
}
// This model represents an Order in the system, including relationships with Installments, Payments, Car, and Customer models.
