<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_category_id',
        'brand_category_id',
        'name',
        'category',
        'price_per_day',
        'image',
        'deskripsi',
        'highlights',
        'isi_paket',
        'stock',
    ];


    /**
     * Tipe produk (misal: Mirrorless, DSLR, Sleeping Bag, dst.)
     */
    public function typeCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'type_category_id');
    }

    /**
     * Merek produk (misal: Canon, Sony, Eiger, dst.)
     */
    public function brandCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'brand_category_id');
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }
}
