<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    protected $fillable = [
        'email',
        'code',
        'is_verified',
        'expires_at',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'expires_at'  => 'datetime',
    ];

    /**
     * Cek apakah OTP masih berlaku (belum expired).
     */
    public function isValid(): bool
    {
        return ! $this->is_verified && now()->lessThanOrEqualTo($this->expires_at);
    }
}