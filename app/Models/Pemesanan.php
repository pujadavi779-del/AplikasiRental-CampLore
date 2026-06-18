<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;
use App\Models\AlamatPengiriman;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'user_id',
        'product_id',
        'start_date',
        'end_date',
        'days',
        'harga_per_hari',
        'total_harga',
        'status',
        'order_id', // ditambahkan jika kolom ini ada di database Anda
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'user_id', 'id_pelanggan');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'product_id', 'id_barang');
    }

    // RELASI UNTUK MENGAMBIL ALAMAT DI HALAMAN ADMIN
    public function alamatPengiriman()
    {
        // Menghubungkan id_pesanan di tabel pesanan dengan id_pesanan di tabel alamat pengiriman
        return $this->hasOne(AlamatPengiriman::class, 'id_pesanan', 'id_pesanan');
    }
}