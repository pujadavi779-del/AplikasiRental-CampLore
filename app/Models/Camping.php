<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camping extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock'
    ];
}