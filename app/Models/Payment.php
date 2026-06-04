<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // Buka file app/Models/Order.php (atau Payment.php)
// Pastikan atau tambahkan kode cast di bawah ini:

protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
];
}

