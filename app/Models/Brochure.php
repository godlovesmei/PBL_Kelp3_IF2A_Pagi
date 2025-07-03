<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brochure extends Model
{
    protected $fillable = [
        'dealer_id',  // tambah dealer_id
        'title',
        'month',
        'year',
        'pdf_path',
        'image_path',
        'size',
    ];

    public function dealer()
    {
        return $this->belongsTo(Dealer::class, 'dealer_id', 'dealer_id');
    }
}
