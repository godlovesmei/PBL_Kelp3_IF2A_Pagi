<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $fillable = ['model', 'harga', 'stok'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
