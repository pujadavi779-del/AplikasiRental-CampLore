<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampingController;
use App\Http\Controllers\CameraController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DeliveryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\CustomerController;

Route::get('/dashboard/camera', [CameraController::class, 'index'])->name('camera.index');
Route::get('/pengiriman', [DeliveryController::class, 'index'])->name('pengiriman');

Route::get('/', [LandingController::class, 'index']);
Route::resource('camping', CampingController::class);
Route::resource('camera', CameraController::class);

Route::get('/landing', [LandingController::class, 'index'])->name('landing');
Route::get('/about', [CameraController::class, 'landing'])->name('about');
Route::get('/camera', [CameraController::class, 'landing'])->name('camera.LP');

// details camera
Route::get('/camera/{id}', [CameraController::class, 'show'])->name('camera.show');

Route::get('/dashboard_admin', function () {
    return view('dashboard_admin');
});

Route::get('/login', function () {
    return view('login');
})->name('login');


Route::get('/about', function () {
    return view('about');
})->name('about');

// Dashboard (protected)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/rental', function () {
    return view('rental');
})->name('rental');


// ── Halaman registrasi ─────────────────────────────────────────────────────
Route::get('/registrasi', [RegisterController::class, 'showForm'])->name('register');
Route::post('/registrasi', [RegisterController::class, 'register'])->name('register.submit');

// ── OTP ────────────────────────────────────────────────────────────────────
Route::post('/otp/send',   [RegisterController::class, 'sendOtp'])->name('otp.send');
Route::post('/otp/verify', [RegisterController::class, 'verifyOtp'])->name('otp.verify');




Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

// ── BERANDA SIDEBAR PELANGGAN ─────────────────────────────────────────────────────
Route::get('/dashboard_pelanggan', function () {
    return view('dashboard_pelanggan');
})->name('dashboard_pelanggan');


// ── BERANDA SIDEBAR ADMIN ─────────────────────────────────────────────────────
Route::get('/dashboard/admin/pembayaran', function () {
    return view('admin.pembayaran');
})->name('pembayaran');



Route::delete('/admin/orders/{id}', [OrderController::class, 'destroy']);

Route::get('/dashboard/admin/pemesanan', function () {
    return view('admin.pemesanan');
})->name('pemesanan');


// HALAMAN CHECKOUT//
Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/dashboard/admin/users', function () {
    $customers = \App\Models\Customer::withCount('rentals')->paginate(10);
    return view('admin.users', compact('customers'));
})->name('users');

Route::resource('dashboard/admin/customers', CustomerController::class)
     ->names('admin.customers');