<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Tampilkan semua ulasan (dengan filter & paginasi).
     * Juga dipakai untuk men-share $recentReviews & $unrepliedCount
     * ke navbar via View Composer (lihat AppServiceProvider).
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product'])
            ->latest();

        // Filter: all | unreplied | replied
        if ($request->filter === 'unreplied') {
            $query->where('is_replied', false);
        } elseif ($request->filter === 'replied') {
            $query->where('is_replied', true);
        }

        $reviews        = $query->paginate(10);
        $unrepliedCount = Review::where('is_replied', false)->count();

        return view('pages.admin.ulasan.index', compact('reviews', 'unrepliedCount'));
    }

    /**
     * Kirim / update balasan admin untuk satu ulasan.
     */
    public function reply(Request $request, Review $review)
    {
        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        $review->update([
            'reply'      => $request->reply,
            'is_replied' => true,
            'replied_at' => now(),
        ]);

        return view('pages.admin.ulasan.index', compact('reviews', 'unrepliedCount'));
    }
}