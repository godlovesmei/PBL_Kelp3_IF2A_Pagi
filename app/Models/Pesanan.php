<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_mobil',
        'pembeli_id',
        'jumlah',
        'status',
        'total_pembayaran',
        'metode_pembayaran'
    ];

    protected $casts = [
        'metode_pembayaran' => 'string'
    ];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    public static function rules()
    {
        return [
            'metode_pembayaran' => 'required|in:lunas,kredit'
        ];
    }
}
