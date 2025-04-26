<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDocument extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer_documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'phone',
        'address',
        'photo',
        'ktp_file',
        'npwp_file',
        'kk_file',
        'salary_slip_file',
    ];

    /**
     * Get the customer that owns the document.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}