<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = [
        'user_id',
        'full_address',
        'city',
        'province',
        'postal_code',
        'district',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}