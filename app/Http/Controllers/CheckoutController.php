<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $ids = $request->query('ids', []);

        if (!empty($ids)) {
            // Kalau dari "Sewa Sekarang" — ambil cart berdasarkan ID yang dikirim
            $carts = Cart::with('item')
                ->whereIn('id', $ids)
                ->where('user_id', auth()->id())
                ->get();
        } else {
            // Kalau dari halaman cart biasa — ambil semua cart user
            $carts = Cart::with('item')
                ->where('user_id', auth()->id())
                ->get();
        }

        return view('pages.pelanggan.checkout', compact('carts'));
    }
}
