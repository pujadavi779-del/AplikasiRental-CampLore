<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $ids = $request->query('ids', []);
        
        // Coba ambil ID dengan beberapa alternatif agar pasti mendapatkan angka primary key user (misal: 4)
        $idPelanggan = auth()->user()->id_pelanggan ?? auth()->user()->id ?? auth()->id();

        // Bersihkan array $ids dari nilai kosong/null
        $ids = array_filter($ids);

        if (!empty($ids)) {
            // Jalur dari "Sewa Sekarang" atau Checklist Keranjang (Membawa array ID)
            $carts = Cart::with('product')
                ->whereIn('id_keranjang', $ids)
                ->where('user_id', $idPelanggan)
                ->get();
        } else {
            // Jalur dari halaman Keranjang langsung (Ambil semua yang ada di keranjang milik user ini)
            $carts = Cart::with('product')
                ->where('user_id', $idPelanggan)
                ->get();
        }

        // Hapus atau komentari dd() jika sebelumnya masih terpasang:
        // dd($carts); 

        return view('pages.pelanggan.checkout', compact('carts'));
    }
}