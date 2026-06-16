<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Barang;

class Kategori_data extends Model
{
    use SoftDeletes;

    protected $table = 'data_kategori';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
        'kategori_utama',
        'jenis_atribut',
        'foto_logo',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function barangSebagaiTipe(): HasMany
    {
        return $this->hasMany(Barang::class, 'id_tipe_kategori', 'id_kategori');
    }

    public function barangSebagaiMerek(): HasMany
    {
        return $this->hasMany(Barang::class, 'id_merek_kategori', 'id_kategori');
    }

    public function scopeTipeKamera($query)
    {
        return $query->where('kategori_utama', 'Kamera')->where('jenis_atribut', 'Tipe');
    }

    public function scopeMerekKamera($query)
    {
        return $query->where('kategori_utama', 'Kamera')->where('jenis_atribut', 'Merek');
    }

    public function scopeTipeCamping($query)
    {
        return $query->where('kategori_utama', 'Camping')->where('jenis_atribut', 'Tipe');
    }

    public function scopeMerekCamping($query)
    {
        return $query->where('kategori_utama', 'Camping')->where('jenis_atribut', 'Merek');
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}
