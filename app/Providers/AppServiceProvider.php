<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // SANGAT PENTING
use App\Models\Review;               // SANGAT PENTING

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share data ulasan secara otomatis ke komponen navbar admin di semua halaman
        View::composer('components.navbar_admin', function ($view) {
            $view->with([
                'recentReviews' => Review::with(['pelanggan', 'product'])
                    ->latest()
                    ->take(5)
                    ->get(),
                'unrepliedCount' => Review::where('is_replied', false)
                    ->orWhereNull('is_replied')
                    ->count(),
            ]);
        });
    }
}