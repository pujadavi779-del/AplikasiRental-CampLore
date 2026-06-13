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
        'id_tipe_kategori',
        'id_merek_kategori',
        'name',
        'kategori',
        'harga_per_hari',
        'gambar_barang',
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
        return $this->belongsTo(Kategori_data::class, 'id_tipe_kategori');
    }

    /**
     * Merek produk (misal: Canon, Sony, Eiger, dst.)
     */
    public function brandCategory(): BelongsTo
    {
        return $this->belongsTo(Kategori_data::class, 'id_merek_kategori');
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }
}
