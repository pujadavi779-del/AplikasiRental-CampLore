<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Review;

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
        {
        View::composer('*', function ($view) {
            if (auth()->check() && auth()->user()->is_admin) {
                $view->with([
                    'recentReviews'  => Review::with(['user', 'product'])
                                            ->latest()
                                            ->take(5)
                                            ->get(),
                    'unrepliedCount' => Review::where('is_replied', false)->count(),
                ]);
        }
    });
}
    }
    
}
