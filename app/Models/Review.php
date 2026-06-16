<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $primaryKey = 'id_review';

        public function getRouteKeyName()
    {
        return 'id_review';
    }

    
    protected $fillable = [
        'user_id',
        'product_id',
        'bintang',
        'komentar',
        'balas_pesan',
        'is_replied',
        'replied_at',
    ];

    protected $attributes = [
        'is_replied' => false,
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'user_id', 'id_pelanggan');
    }

    public function product()
    {
        return $this->belongsTo(Barang::class, 'product_id', 'id_barang');
    }
}
