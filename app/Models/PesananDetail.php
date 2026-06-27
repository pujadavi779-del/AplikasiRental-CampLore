<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananDetail extends Model
{
    use HasFactory;

    protected $table = 'pesanan_detail';
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'pesanan_id',
        'product_id',
        'quantity',
        'start_date',
        'end_date',
        'hari_lama_sewa',
        'harga_per_hari',
        'subtotal',
        'note',
        'bukti_pengiriman',
        'hari_terlambat',
        'keterlambatan_biaya',
        'denda_dibayar',
    ];

    protected $casts = [
        'start_date'          => 'date',
        'end_date'            => 'date',
        'harga_per_hari'      => 'decimal:2',
        'subtotal'            => 'decimal:2',
        'keterlambatan_biaya' => 'decimal:2',
        'denda_dibayar'       => 'boolean',
    ];

    // === RELASI ===

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id', 'id_pesanan');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'product_id', 'id_barang');
    }

    // === HELPER ===

    public function getTotalDendaAttribute(): float
    {
        return (float) ($this->hari_terlambat * $this->keterlambatan_biaya);
    }
}