<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id', // Sesuaikan dengan kolom car_id di tabel
        'cust_id', // Sesuaikan dengan kolom cust_id di tabel
        'total_price', // Sesuaikan dengan kolom total_price di tabel
        'payment_method', // Sesuaikan dengan kolom payment_method di tabel
        'order_status', // Sesuaikan dengan kolom payment_status di tabel
        'created_at', // Sesuaikan dengan kolom created_at di tabel
        'updated_at', // Sesuaikan dengan kolom updated_at di tabel
    ];
}
