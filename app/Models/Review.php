<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'bintang',
        'komentar',
        'balas_pesan',
        'is_replied',
        'replied_at',
    ];

    protected $casts = [
        'is_replied' => 'boolean',
        'replied_at' => 'datetime',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Barang::class, 'product_id');
    }
}