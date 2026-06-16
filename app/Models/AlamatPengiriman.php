<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatPengiriman extends Model
{
    protected $table = 'alamat_pengiriman';
    protected $primaryKey = 'id_alamat';

    protected $fillable = [
        'user_id',
        'alamat_lengkap',
        'kota',
        'province',
        'kode_pos',
        'daerah',
        'notes',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'user_id', 'id_pelanggan');
    }
}
