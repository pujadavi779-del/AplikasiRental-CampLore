<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'main_category',
        'attribute_type',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Produk yang menggunakan category ini sebagai Tipe.
     */
    public function productsAsType(): HasMany
    {
        return $this->hasMany(Product::class, 'type_category_id');
    }

    /**
     * Produk yang menggunakan category ini sebagai Merek.
     */
    public function productsAsBrand(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_category_id');
    }

    // ── Scope helpers ──────────────────────────────────────────────────

    public function scopeTipeKamera($query)
    {
        return $query->where('main_category', 'Kamera')->where('attribute_type', 'Tipe');
    }

    public function scopeMerekKamera($query)
    {
        return $query->where('main_category', 'Kamera')->where('attribute_type', 'Merek');
    }

    public function scopeTipeCamping($query)
    {
        return $query->where('main_category', 'Camping')->where('attribute_type', 'Tipe');
    }

    public function scopeMerekCamping($query)
    {
        return $query->where('main_category', 'Camping')->where('attribute_type', 'Merek');
    }

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }
}