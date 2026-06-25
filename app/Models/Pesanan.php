<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';   
    
    protected $fillable = [
        'order_id',
        'user_id',
        'alamat_pengiriman_id',
        'status',
        'snap_token',
        'metode_pengiriman',
        'biaya_pengiriman',
        'biaya_layanan',
        'total_harga',
        'bukti_pembayaran',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
    ];

    // === RELASI BARU KE DETAIL ===
    public function details()
    {
        return $this->hasMany(PesananDetail::class, 'pesanan_id', 'id_pesanan');
    }

    public function alamatPengiriman()
    {
        return $this->belongsTo(AlamatPengiriman::class, 'alamat_pengiriman_id', 'id_alamat');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'user_id', 'id_pelanggan');
    }

    // === HELPER: ambil subtotal dari detail ===
    public function getSubtotalAttribute()
    {
        return $this->details->sum('subtotal');
    }
}