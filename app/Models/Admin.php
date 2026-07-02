<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $primaryKey = 'id_admin';
    
    protected $fillable = [
        'name',
        'nama_pengguna',
        'kata_sandi',
    ];

    protected $hidden = ['kata_sandi', 'remember_token'];

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }
}