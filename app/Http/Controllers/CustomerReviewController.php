<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Order;

class CustomerReviewController extends Controller
{
    /**
     * Tampilkan form tulis ulasan.
     * Hanya boleh diakses jika order milik user & status selesai
     * & belum pernah review produk ini.
     */
    public function create($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->where('status', 'selesai')
            ->firstOrFail();

        // Cek apakah sudah pernah review produk ini
        $alreadyReviewed = Review::where('user_id', Auth::id())
            ->where('product_id', $order->product_id)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->route('pelanggan.sewa')
                ->with('success', 'Kamu sudah pernah memberikan ulasan untuk produk ini.');
        }

        $product = $order->product;

        return view('pages.pelanggan.ulasan.tulis', compact('order', 'product'));
    }

    /**
     * Simpan ulasan ke database.
     */
    public function store(Request $request, $orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->where('status', 'selesai')
            ->firstOrFail();

        // Pastikan belum review
        $alreadyReviewed = Review::where('user_id', Auth::id())
            ->where('product_id', $order->product_id)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->route('pelanggan.sewa')
                ->with('success', 'Kamu sudah pernah memberikan ulasan untuk produk ini.');
        }

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ], [
            'rating.required'  => 'Pilih rating bintang terlebih dahulu.',
            'comment.required' => 'Komentar tidak boleh kosong.',
            'comment.min'      => 'Komentar minimal 10 karakter.',
        ]);

        Review::create([
            'user_id'    => Auth::id(),
            'product_id' => $order->product_id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'is_replied' => false,
        ]);

        return redirect()->route('pelanggan.sewa')
            ->with('success', 'Ulasan berhasil dikirim! Terima kasih atas penilaianmu.');
    }
    public function show($reviewId)
    {
        $review = Review::with(['product', 'user'])
            ->where('id', $reviewId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('pages.pelanggan.ulasan.detail', compact('review'));
    }
}