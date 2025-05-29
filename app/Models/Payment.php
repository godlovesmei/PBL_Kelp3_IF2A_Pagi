<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_id'; // Menetapkan primary key untuk tabel payments

    protected $fillable = [
        'order_id',
        'installment_id',
        'amount',
        'payment_date',
        'payment_method',
        'payment_proof',
    ];

    // Relasi dengan Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Relasi dengan Installment
    public function installment()
    {
        return $this->belongsTo(Installment::class, 'installment_id');
    }
}
// This model represents a Payment in the system, including relationships with Order and Installment models.
