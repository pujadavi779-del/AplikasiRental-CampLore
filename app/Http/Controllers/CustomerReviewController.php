<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Pesanan;

class CustomerReviewController extends Controller
{
    /**
     * Tampilkan form tulis ulasan.
     * Hanya boleh diakses jika pesanan milik pelanggan & status selesai
     * & belum pernah review produk ini.
     */
    public function create($orderId)
    {
        $pesanan = Pesanan::with('details.barang')
            ->where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->where('status', 'selesai')
            ->firstOrFail();

        // Ambil detail pesanan pertama (karena 1 pesanan bisa punya banyak item, 
        // untuk review saat ini kita ambil item pertama)
        $detail = $pesanan->details->first();

        if (!$detail) {
            return redirect()->route('pelanggan.sewa')
                ->with('error', 'Detail pesanan tidak ditemukan.');
        }

        // Cek apakah sudah pernah review produk ini
        $alreadyReviewed = Review::where('user_id', Auth::id())
            ->where('product_id', $detail->product_id)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->route('pelanggan.sewa')
                ->with('success', 'Kamu sudah pernah memberikan ulasan untuk produk ini.');
        }

        $product = $detail->barang;

        return view('pages.pelanggan.ulasan.tulis', compact('pesanan', 'product'));
    }

    /**
     * Simpan ulasan ke database.
     */
    public function store(Request $request, $orderId)
    {
        $pesanan = Pesanan::with('details')
            ->where('id_pesanan', $orderId)
            ->where('user_id', Auth::id())
            ->where('status', 'selesai')
            ->firstOrFail();

        // Ambil detail pesanan pertama
        $detail = $pesanan->details->first();

        if (!$detail) {
            return redirect()->route('pelanggan.sewa')
                ->with('error', 'Detail pesanan tidak ditemukan.');
        }

        // Pastikan belum review
        $alreadyReviewed = Review::where('user_id', Auth::id())
            ->where('product_id', $detail->product_id)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->route('pelanggan.sewa')
                ->with('success', 'Kamu sudah pernah memberikan ulasan untuk produk ini.');
        }

        $request->validate([
            'bintang'  => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:10|max:1000',
        ], [
            'bintang.required'  => 'Pilih rating bintang terlebih dahulu.',
            'komentar.required' => 'Komentar tidak boleh kosong.',
            'komentar.min'      => 'Komentar minimal 10 karakter.',
        ]);

        Review::create([
            'user_id'    => Auth::id(),
            'product_id' => $detail->product_id,
            'bintang'     => $request->bintang,
            'komentar'    => $request->komentar,
            'is_replied' => false,
        ]);

        return redirect()->route('pelanggan.sewa')
            ->with('success', 'Ulasan berhasil dikirim! Terima kasih atas penilaianmu.');
    }

    public function show($reviewId)
    {
        $review = Review::with(['product' => function ($q) {
            $q->withTrashed();
        }, 'pelanggan'])
            ->where('id_review', $reviewId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('pages.pelanggan.ulasan.detail', compact('review'));
    }
}