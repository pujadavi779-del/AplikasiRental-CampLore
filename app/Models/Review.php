<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;

class Review extends Model
{
    //protected diakses dalam class ini dan class turunannya
    //$fillable = yang boleh diisi
    protected $fillable = ['user_id', 'product_id', 'bintang', 'komentar', 'balas_pesan', 'is_replied', 'replied_at'];

public function user() { return $this->belongsTo(User::class); }
public function product() { return $this->belongsTo(Barang::class); }
}
