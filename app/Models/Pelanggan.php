<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use Notifiable;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';

    public function getRouteKeyName()
    {
        return 'id_pelanggan';
    }

    protected $fillable = [
        'nama_lengkap',   // FIX: kolom asli di database adalah 'nama_lengkap', bukan 'name'
        'nama_pengguna',
        'nik',
        'email',
        'kata_sandi',
        'no_tlp',
        'foto_profile',
        'foto_ktp',
        'ktp_status',
        'ktp_note',
        'ktp_updated_at',
    ];

    protected $hidden = ['kata_sandi'];

    protected $casts = [
        'ktp_updated_at' => 'datetime',
    ];

    public function alamatPengiriman()
    {
        return $this->hasOne(AlamatPengiriman::class, 'user_id', 'id_pelanggan');
    }

    public function getAuthPassword()
{
    return $this->kata_sandi;
}
}