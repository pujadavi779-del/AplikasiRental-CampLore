<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PengembalianController extends Controller
{
    public function index()
    {
        // ── DATA DUMMY untuk presentasi ──────────────────────────────
        $data_pengembalian = collect([
    ['id'=>1,'id_pesanan'=>'CMP-20250722-001','tanggal_kembali'=>today()->subDays(3)->toDateString(),'status'=>'disewa',
     'user'=>(object)['name'=>'Rizka Nur','no_hp'=>'081234567890'],
     'products'=>[(object)['name'=>'Canon EOS R6','kategori'=>'Kamera','tipe'=>'Mirrorless','merek'=>'Canon'],(object)['name'=>'Lensa 50mm f1.4','kategori'=>'Kamera','tipe'=>'Aksesori','merek'=>'Canon']],
     'product'=>(object)['name'=>'Canon EOS R6','kategori'=>'Kamera','tipe'=>'Mirrorless','merek'=>'Canon','brand'=>'Canon']],
    ['id'=>2,'id_pesanan'=>'CMP-20250722-002','tanggal_kembali'=>today()->addDays(2)->toDateString(),'status'=>'disewa',
     'user'=>(object)['name'=>'Budi Santoso','no_hp'=>'082345678901'],
     'products'=>[(object)['name'=>'Tenda Dome 4P','kategori'=>'Camping','tipe'=>'Tenda','merek'=>'Consina']],
     'product'=>(object)['name'=>'Tenda Dome 4P','kategori'=>'Camping','tipe'=>'Tenda','merek'=>'Consina','brand'=>'Consina']],
    ['id'=>3,'id_pesanan'=>'CMP-20250722-003','tanggal_kembali'=>today()->subDays(1)->toDateString(),'status'=>'disewa',
     'user'=>(object)['name'=>'Sari Dewi','no_hp'=>'083456789012'],
     'products'=>[(object)['name'=>'Sony ZV-E10','kategori'=>'Kamera','tipe'=>'Kamera Video','merek'=>'Sony']],
     'product'=>(object)['name'=>'Sony ZV-E10','kategori'=>'Kamera','tipe'=>'Kamera Video','merek'=>'Sony','brand'=>'Sony']],
    ['id'=>4,'id_pesanan'=>'CMP-20250722-004','tanggal_kembali'=>today()->addDays(5)->toDateString(),'status'=>'disewa',
     'user'=>(object)['name'=>'Andi Prasetyo','no_hp'=>'084567890123'],
     'products'=>[(object)['name'=>'Sleeping Bag Alpine','kategori'=>'Camping','tipe'=>'Sleeping Bag','merek'=>'Eiger']],
     'product'=>(object)['name'=>'Sleeping Bag Alpine','kategori'=>'Camping','tipe'=>'Sleeping Bag','merek'=>'Eiger','brand'=>'Eiger']],
    ['id'=>5,'id_pesanan'=>'CMP-20250722-005','tanggal_kembali'=>today()->toDateString(),'status'=>'disewa',
     'user'=>(object)['name'=>'Maya Lestari','no_hp'=>'085678901234'],
     'products'=>[(object)['name'=>'Carrier 60L','kategori'=>'Camping','tipe'=>'Carrier / Backpack','merek'=>'Deuter']],
     'product'=>(object)['name'=>'Carrier 60L','kategori'=>'Camping','tipe'=>'Carrier / Backpack','merek'=>'Deuter','brand'=>'Deuter']],
    ['id'=>6,'id_pesanan'=>'CMP-20250722-006','tanggal_kembali'=>today()->subDays(5)->toDateString(),'status'=>'disewa',
     'user'=>(object)['name'=>'Fajar Ramadhan','no_hp'=>'086789012345'],
     'products'=>[(object)['name'=>'Fujifilm Instax Mini 12','kategori'=>'Kamera','tipe'=>'Kamera Instan (Polaroid)','merek'=>'Fujifilm']],
     'product'=>(object)['name'=>'Fujifilm Instax Mini 12','kategori'=>'Kamera','tipe'=>'Kamera Instan (Polaroid)','merek'=>'Fujifilm','brand'=>'Fujifilm']],
])->map(fn($d) => (object)$d);

return view('pages.admin.pengembalian', compact('data_pengembalian'));
    }
}
