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
        'name',
        'username',
        'nik',
        'email',
        'password',
        'no_tlp',
        'foto_profile',
        'foto_ktp',
        'ktp_status',
        'ktp_note',
        'ktp_updated_at',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'ktp_updated_at' => 'datetime',
    ];

    public function alamat_pengiriman()
    {
        return $this->belongsTo(Pelanggan::class, 'user_id', 'id_pelanggan');
    }
}
