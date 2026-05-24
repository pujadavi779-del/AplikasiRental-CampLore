<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        // Sudah login sebagai pelanggan → lanjutkan
        if (Auth::guard('web')->check()) {
            return $next($request);
        }

        // Sudah login sebagai admin → tolak, kembalikan ke dashboard admin
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Admin tidak dapat mengakses halaman pelanggan.');
        }

        // Belum login sama sekali → ke halaman login pelanggan
        return redirect()->route('login')
            ->with('error', 'Silakan login terlebih dahulu.');
    }
}