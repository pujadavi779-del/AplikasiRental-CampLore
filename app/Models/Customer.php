<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'name',
        'phone',
        'address',
        'customer_type',
        'gender',
        'is_member',
        'discount',
        'document_type',
        'document',
        'agreement',
        'photo',
        'status',
    ];

    protected $casts = [
        'is_member' => 'boolean',
        'discount'  => 'float',
    ];

    // Relasi ke tabel rentals (sesuaikan nama model kamu)
    public function rentals()
    {
        return $this->hasMany(Rental::class);
        return $this->hasMany(\App\Models\Rental::class);
    }

    
  

}