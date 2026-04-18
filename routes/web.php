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
use App\Http\Controllers\ShippingAddressController;
use App\Models\Product;


Route::get('/dashboard/camera', [CameraController::class, 'index'])->name('camera.index');

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

Route::get('/registrasi', [RegisterController::class, 'showForm'])->name('register');
Route::post('/registrasi', [RegisterController::class, 'register'])->name('register.submit');

Route::post('/otp/send',   [RegisterController::class, 'sendOtp'])->name('otp.send');
Route::post('/otp/verify', [RegisterController::class, 'verifyOtp'])->name('otp.verify');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

// ── BERANDA SIDEBAR PELANGGAN
Route::get('/dashboard_pelanggan', function () {
    return view('dashboard_pelanggan');
})->name('dashboard_pelanggan');


// ── BERANDA SIDEBAR ADMIN
Route::get('/pembayaran', function () {
    return view('admin.pembayaran');
})->name('pembayaran');

Route::delete('/admin/orders/{id}', [OrderController::class, 'destroy']);

Route::get('/pemesanan', function () {
    return view('admin.pemesanan');
})->name('pemesanan');

Route::get('/pengiriman', [
    DeliveryController::class,
    'index'
])->name('pengiriman');

Route::resource('/customers', CustomerController::class)
    ->names('admin.customers');

Route::get('/admin/products', function (Request $request) {

    $query = Product::query();

    // FILTER CATEGORY
    if ($request->category) {
        $query->where('category', $request->category);
    }

    $products = $query->paginate(10)->withQueryString();

    return view('admin.products', compact('products'));

    if ($request->search) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }
})->name('admin.products');

Route::get('/pengembalian', function () {
    return view('admin.pengembalian');
})->name('admin.pengembalian');



// HALAMAN CHECKOUT//
Route::get('/checkout', function () {
    return view('checkout');
});

// Profil pelanggan ( Shipping Address )
Route::get('/shipping-address', [ShippingAddressController::class, 'index'])
    ->name('shipping-address');
Route::put('/shipping-address', [ShippingAddressController::class, 'update'])
    ->name('shipping-address.update');


//Riwayat Produk
Route::get('/dashboard/admin/riwayat_produk', function () {
    return view('admin.riwayat_produk');
})->name('admin.riwayat_produk');

Route::get('/dashboard/admin/riwayat/kamera', function () {
    return view('admin.riwayat.kamera');
})->name('admin.riwayat.kamera');

Route::get('/dashboard/admin/riwayat/camping', function () {
    return view('admin.riwayat.camping');
})->name('riwayat.camping');
