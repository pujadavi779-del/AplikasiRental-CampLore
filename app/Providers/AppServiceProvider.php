<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Review;
use App\Models\Cart;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        require_once app_path('Helpers/WaHelper.php');

        View::composer('*', function ($view) {

            // Badge keranjang untuk pelanggan
            $cartCount = auth()->check()
                ? Cart::where('user_id', auth()->id())->sum('quantity')
                : 0;

            $data = [
                'cartCount' => $cartCount,
            ];

            // Data khusus admin
            if (auth()->check() && auth()->user()->is_admin) {
                $data['recentReviews'] = Review::with(['pelanggan', 'product'])
                    ->latest()
                    ->take(5)
                    ->get();

                $data['unrepliedCount'] = Review::where('is_replied', false)->count();
            }

            $view->with($data);
        });
    }
}