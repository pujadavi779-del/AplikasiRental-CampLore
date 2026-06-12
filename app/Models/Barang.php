<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = [
        'tipe_kategori_id',
        'merek_kategori_id',
        'name',
        'kategori',
        'harga_per_hari',
        'image',
        'deskripsi',
        'sorotan',
        'isi_paket',
        'stok',
    ];


    /**
     * Tipe produk (misal: Mirrorless, DSLR, Sleeping Bag, dst.)
     */
    public function typeCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'tipe_kategori_id');
    }

    /**
     * Merek produk (misal: Canon, Sony, Eiger, dst.)
     */
    public function brandCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'merek_kategori_id');
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }
}
