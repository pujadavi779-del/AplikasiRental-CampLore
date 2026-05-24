<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards)
    {
        // Cek guard admin
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // Cek guard pelanggan (web)
        if (Auth::guard('web')->check()) {
            return redirect()->route('pelanggan.home');
        }

        return $next($request);
    }
}