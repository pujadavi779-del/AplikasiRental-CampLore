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
        'product_id',
        'start_date',
        'end_date',
        'days',
        'quantity',
        'note',
        'harga_per_hari',
        'total_harga',
        'biaya_pengiriman',
        'biaya_layanan',
        'metode_pengiriman',
        'snap_token',
        'status',
        'bukti_pembayaran',
        'bukti_pengiriman',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function alamatPengiriman()
{
    return $this->belongsTo(AlamatPengiriman::class, 'alamat_pengiriman_id', 'id_alamat');
}

    public function product()
    {
        return $this->belongsTo(Barang::class, 'product_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'user_id', 'id_pelanggan');
    }
}