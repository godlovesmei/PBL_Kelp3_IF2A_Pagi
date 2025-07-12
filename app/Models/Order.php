<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
         'car_id',
         'cust_id',
         'total_price',
         'down_payment',
         'tenor',
         'amount_financed',
         'monthly_installment',
         'payment_method',
         'payment_status',
         'order_status',
    ];

    protected $casts = [
    'total_price' => 'float',
    'down_payment' => 'float',
    'amount_financed' => 'float',
    'monthly_installment' => 'float',
    'tenor' => 'integer',
    ];

    // Relasi untuk cash payment
public function cashPayment()
{
    return $this->hasOne(Payment::class, 'order_id', 'order_id')
                ->where('payment_method', 'cash');
}

// Accessor untuk total pembayaran
public function getTotalPaymentAttribute()
{
    if ($this->payment_method === 'cash') {
        return $this->cashPayment?->amount ?? $this->total_price;
    }

    if ($this->payment_method === 'credit') {
        $dp = $this->down_payment ?? 0;
        $monthly = $this->monthly_installment ?? 0;
        $tenor = $this->tenor ?? 0;
        return $dp + ($monthly * $tenor);
    }

    return 0;
}




    public function getRouteKeyName()
    {
        return 'order_id';
    }

    public function installments()
    {
        return $this->hasMany(Installment::class, 'order_id', 'order_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id', 'order_id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'cust_id');
    }

}
