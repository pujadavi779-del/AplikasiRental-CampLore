<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price_per_day',
        'image',
        'stock',
        'body' // Tambahkan ini!
    ];
}
