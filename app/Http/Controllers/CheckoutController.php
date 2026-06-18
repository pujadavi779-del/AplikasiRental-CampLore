<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\AlamatPengiriman;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $ids = $request->query('ids', []);
        
        $idPelanggan = auth()->user()->id_pelanggan ?? auth()->user()->id ?? auth()->id();

        $ids = array_filter($ids);

        if (!empty($ids)) {
            $carts = Cart::with('product')
                ->whereIn('id_keranjang', $ids)
                ->where('user_id', $idPelanggan)
                ->get();
        } else {
            $carts = Cart::with('product')
                ->where('user_id', $idPelanggan)
                ->get();
        }

        $list_alamat = \App\Models\AlamatPengiriman::where('user_id', $idPelanggan)->get();

        return view('pages.pelanggan.checkout', compact('carts', 'list_alamat'));
    }
}