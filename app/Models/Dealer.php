<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;

    /**
     * Table name.
     */
    protected $table = 'dealers';

    /**
     * Primary key adalah dealer_id.
     */
    protected $primaryKey = 'dealer_id';

    /**
     * Tidak menggunakan auto increment karena dealer_id berasal dari user_id.
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'dealer_id',
        'sosmed_link',
        'logo',
    ];

    /**
     * Relasi ke tabel users.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'dealer_id', 'user_id');
    }

    /**
     * Relasi dengan mobil (satu dealer bisa memiliki banyak mobil).
     */
    public function cars()
    {
        return $this->hasMany(Car::class, 'dealer_id', 'dealer_id');
    }
}