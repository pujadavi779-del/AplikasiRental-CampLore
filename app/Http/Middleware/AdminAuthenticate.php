<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        // Sudah login sebagai admin → lanjutkan
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Sudah login sebagai PELANGGAN → tolak, jangan biarkan masuk ke admin
        if (Auth::guard('web')->check()) {
            return redirect('/home')
                ->with('error', 'Anda tidak memiliki akses ke halaman admin. Silakan logout terlebih dahulu.');
        }

        // Belum login sama sekali → ke halaman login admin
        return redirect()->route('admin.login')
            ->with('error', 'Silakan login sebagai admin terlebih dahulu.');
    }
}