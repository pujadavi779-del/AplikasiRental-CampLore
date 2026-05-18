<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Menampilkan halaman kategori produk dengan Dummy Data untuk kebutuhan Front-End.
     */
    public function index()
    {
        // 1. Dummy Data untuk Kelompok Kamera
        $tipeKamera = [
            ['id' => 1, 'nama' => 'Mirrorless'],
            ['id' => 2, 'nama' => 'DSLR'],
            ['id' => 3, 'nama' => 'Action Camera'],
            ['id' => 4, 'nama' => 'Pocket Camera'],
        ];

        $merekKamera = [
            'Sony', 'Canon', 'Fujifilm', 'Nikon', 'GoPro'
        ];

        // 2. Dummy Data untuk Kelompok Camping
        $tipeCamping = [
            ['id' => 1, 'nama' => 'Tenda Dome'],
            ['id' => 2, 'nama' => 'Carrier Backpack'],
            ['id' => 3, 'nama' => 'Sleeping Bag'],
            ['id' => 4, 'nama' => 'Cooking Set'],
            ['id' => 5, 'nama' => 'Matras'],
        ];

        $merekCamping = [
            'Eiger', 'Consina', 'Naturehike', 'Arei', 'Deuter'
        ];

        // 3. Dummy Data untuk Statistik (Bagian Bawah)
        $stats = [
            'total_variasi' => count($tipeKamera) + count($tipeCamping), // Menghitung otomatis dari data di atas
            'total_brand'   => count($merekKamera) + count($merekCamping), // Menghitung otomatis dari data di atas
            'produk_tertaut' => 142, // Angka dummy untuk unit produk yang terdata
        ];

        // 4. Kirim semua variabel ke view pages.admin.kategori_produk
        return view('pages.admin.kategori_produk', compact(
            'tipeKamera',
            'merekKamera',
            'tipeCamping',
            'merekCamping',
            'stats'
        ));
    }
}