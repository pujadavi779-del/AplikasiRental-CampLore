<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['pelanggan', 'product'])->latest();

        if ($request->filter === 'unreplied') {
            $query->where('is_replied', false);
        } elseif ($request->filter === 'replied') {
            $query->where('is_replied', true);
        }

        $reviews        = $query->paginate(10);
        $unrepliedCount = Review::where('is_replied', false)->count();

        return view('pages.admin.ulasan.index', compact('reviews', 'unrepliedCount'));
    }

    public function balas_pesan(Request $request, Review $review)
    {
        $request->validate([
            'balas_pesan' => 'required|string|max:1000',
        ]);

        $review->update([
            'balas_pesan' => $request->balas_pesan,
            'is_replied'  => true,
            'replied_at'  => now(),
        ]);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Balasan berhasil dikirim!');
    }
}
