<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;

    protected $table = 'dealer';
    protected $primaryKey = 'id';
    protected $fillable = ['username', 'email', 'password'];

    public function mobil()
    {
        return $this->hasMany(Mobil::class, 'dealer_id');
    }
}
