<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;

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
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'user_id', 'id_pelanggan');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'product_id', 'id_barang');
    }
}
