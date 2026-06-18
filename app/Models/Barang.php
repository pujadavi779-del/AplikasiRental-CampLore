<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';

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

    public function typeCategory(): BelongsTo
    {
        return $this->belongsTo(Kategori_data::class, 'id_tipe_kategori');
    }

    public function brandCategory(): BelongsTo
    {
        return $this->belongsTo(Kategori_data::class, 'id_merek_kategori');
    }

    public function pesanan()
    {
        return $this->hasMany(\App\Models\Pesanan::class, 'product_id', 'id_barang');
    }
}