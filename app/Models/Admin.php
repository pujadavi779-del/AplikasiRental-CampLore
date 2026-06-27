<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $primaryKey = 'id_admin';
    
    protected $fillable = [
        'name',
        'nama_pengguna',
        'password',
    ];

    protected $hidden = ['password', 'remember_token'];
}