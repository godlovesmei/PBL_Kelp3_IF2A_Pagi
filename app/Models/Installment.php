<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $primaryKey = 'installment_id'; // Menetapkan primary key untuk tabel installments

    protected $fillable = [
        'order_id',
        'due_date',
        'amount',
        'status',
        'paid_at',
    ];

    // Relasi dengan Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Relasi dengan Payment
    public function payments()
    {
        return $this->hasMany(Payment::class, 'installment_id');
    }
}
// This model represents an Installment in the system, including relationships with Order and Payment models.
