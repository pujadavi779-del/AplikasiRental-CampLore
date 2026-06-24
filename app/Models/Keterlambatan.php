<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keterlambatan extends Model
{
    protected $table = 'keterlambatan';
    protected $primaryKey = 'id_keterlambatan';

    protected $fillable = [
        'id_tipe_kategori',
        'denda_per_hari',
    ];

    protected $casts = [
        'denda_per_hari' => 'decimal:2',
    ];

    // Relasi ke tipe kategori
    public function tipeKategori()
    {
        return $this->belongsTo(Kategori_data::class, 'id_tipe_kategori', 'id_kategori');
    }
}