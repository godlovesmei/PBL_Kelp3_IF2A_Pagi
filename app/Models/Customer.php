<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * Table name.
     */
    protected $table = 'customers';

    /**
     * Primary key adalah cust_id.
     */
    protected $primaryKey = 'cust_id';

    /**
     * Tidak menggunakan auto increment karena cust_id berasal dari user_id.
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cust_id',
        'salary_doc',
        'ktp_doc',
        'npwp_doc',
    ];

    /**
     * Relasi ke tabel users.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'cust_id', 'user_id');
    }

    public function wishlists()
{
    return $this->hasMany(Wishlist::class, 'cust_id', 'cust_id');
}
}