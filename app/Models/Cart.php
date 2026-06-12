<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;

class Cart extends Model
{
protected $table = 'keranjang';    
protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Barang::class);
    }

    public function getDaysAttribute(): int
    {
        if (!$this->start_date || !$this->end_date) return 1;
        return max(1, $this->start_date->diffInDays($this->end_date));
    }

    public function getSubtotalAttribute(): int
    {
        if (!$this->product) return 0;

        return $this->product->harga_per_hari
            * $this->days
            * $this->quantity;
    }
}
