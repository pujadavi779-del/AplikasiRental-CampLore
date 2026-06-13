<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{

    protected $table = 'pesanan';
    
    protected $fillable = [
        'order_id',
        'user_id',
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
        'nama_pelanggan',
        'pelanggan_telepon',
        'alamat_pelanggan',
        'snap_token',
        'status',
        'bukti_pembayaran',
        'bukti_pengiriman',
    ];

    // Tambahkan properti ini di bawah $fillable
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}