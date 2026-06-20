<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Helper terpusat untuk mengambil identitas user di tabel carts.
     * PENTING: sebelumnya kode ini tidak konsisten — index() pakai `nik`,
     * add() pakai `id_pelanggan`, sementara update/destroy/bulkDestroy pakai
     * Auth::id(). Kalau kolom-kolom itu nilainya berbeda, cart yang dibuat
     * lewat add() tidak akan pernah ketemu saat update/destroy dipanggil.
     * Samakan semuanya ke satu sumber di sini.
     */
    private function currentUserId()
    {
        return auth()->user()->id_pelanggan ?? Auth::id();
    }

    public function index()
    {
        $carts = Cart::with('product')
            ->where('user_id', $this->currentUserId())
            ->get();

        return view('pages.landing.keranjang', compact('carts'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity'   => 'required|integer|min:1',
        ]);

        $userId = $this->currentUserId();

        // Lock baris produk supaya stok tidak berubah di tengah proses
        // (mencegah race condition kalau ada beberapa request bersamaan)
        $barang = Barang::where('id_barang', $request->product_id)
            ->lockForUpdate()
            ->first();

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        // add() pakai updateOrCreate, artinya quantity request akan MENIMPA
        // (bukan menambah) quantity yang sudah ada di cart untuk produk ini.
        // Jadi validasi cukup terhadap quantity baru, bukan quantity lama + baru.
        if ($request->quantity > $barang->stok) {
            return response()->json([
                'success' => false,
                'message' => "Stok {$barang->name} tidak mencukupi. Sisa stok: {$barang->stok}.",
            ], 422);
        }

        $cart = Cart::updateOrCreate(
            [
                'user_id'    => $userId,
                'product_id' => $request->product_id,
            ],
            [
                'quantity'   => $request->quantity,
                'start_date' => $request->start_date,
                'end_date'   => $request->end_date,
            ]
        );

        return response()->json([
            'success' => true,
            'cart_id' => $cart->id_keranjang ?? $cart->id,
            'total'   => Cart::where('user_id', $userId)->count(),
        ]);
    }

    public function update(Request $request, $cartId)
    {
        $userId = $this->currentUserId();

        $cart = Cart::with('product')
            ->where('id_keranjang', $cartId)
            ->where('user_id', $userId)
            ->firstOrFail();

        if ($request->has('quantity')) {
            $requestedQty = max(1, (int) $request->quantity);

            $barang = Barang::where('id_barang', $cart->product_id)
                ->lockForUpdate()
                ->first();

            if (!$barang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan.',
                ], 404);
            }

            if ($requestedQty > $barang->stok) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok {$barang->name} tidak mencukupi. Sisa stok: {$barang->stok}.",
                    'max_stok' => $barang->stok,
                ], 422);
            }

            $cart->quantity = $requestedQty;
        }

        if ($request->has('start_date')) {
            $cart->start_date = $request->start_date;
        }

        if ($request->has('end_date')) {
            $cart->end_date = $request->end_date;
        }

        $cart->save();

        return response()->json(['success' => true, 'quantity' => $cart->quantity]);
    }

    public function destroy($cartId)
    {
        $userId = $this->currentUserId();

        Cart::where('id_keranjang', $cartId)
            ->where('user_id', $userId)
            ->delete();

        return response()->json([
            'success' => true,
            'total'   => Cart::where('user_id', $userId)->count(),
        ]);
    }

    public function bulkDestroy(Request $request)
    {
        $userId = $this->currentUserId();

        Cart::whereIn('id_keranjang', $request->ids)
            ->where('user_id', $userId)
            ->delete();

        return response()->json([
            'success' => true,
            'total'   => Cart::where('user_id', $userId)->count(),
        ]);
    }
}