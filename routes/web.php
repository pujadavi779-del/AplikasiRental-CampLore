<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\CampingController;
use App\Http\Controllers\CameraController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\Admin\PemesananController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CreateProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Models
use App\Models\Product;
use App\Models\Cart;

// Admin
use App\Http\Controllers\AdminAuthController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/rental', function () {
    $carts = [];
    if (Auth::check()) {
        $carts = Cart::where('user_id', Auth::id())->get();
    }
    return view('pages.landing.rental', compact('carts'));
})->name('pages.landing.rental');

// Profile
Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::post('/profile', [ProfileController::class, 'update'])->middleware('auth');

// Login
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [LandingController::class, 'index'])->name('pages.landing.landing');
Route::get('/camping', [CampingController::class, 'index'])->name('pages.camping.landing');

Route::get('/landing/about', function () {
    return view('pages.landing.about');
})->name('pages.landing.about');

// Camera & Camping Landing Page
Route::get('/camera', [CameraController::class, 'landing'])->name('camera.LP');
Route::get('/camping', [CampingController::class, 'landing'])->name('camping.LP');

// Detail
Route::get('/camera/{id}', [CameraController::class, 'show'])->name('camera.show');
Route::get('/camping/{id}', [CampingController::class, 'show'])->name('camping.show');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/registrasi', [RegisterController::class, 'showForm'])->name('register');
Route::post('/registrasi', [RegisterController::class, 'register'])->name('register.submit');

Route::post('/otp/send', [RegisterController::class, 'sendOtp'])->name('otp.send');
Route::post('/otp/verify', [RegisterController::class, 'verifyOtp'])->name('otp.verify');

/*
|--------------------------------------------------------------------------
| User Routes (Auth Required)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/dashboard_pelanggan', function () {
        return view('pages.pelanggan.dashboard.pesanan_saya');
    })->name('dashboard_pelanggan');

    // Checkout — DIPERBAIKI, tidak ada duplikasi
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

    Route::get('/pembayaran', function () {
        $payments = collect();
        return view('admin.pembayaran', compact('payments'));
    })->name('pembayaran');

    Route::put('/shipping-address', [ShippingAddressController::class, 'update'])
        ->name('shipping-address.update');

    // Ganti Password
    Route::get('/change-password', [ChangePasswordController::class, 'index'])
        ->name('change-password');
    Route::put('/change-password/update', [ChangePasswordController::class, 'update'])
        ->name('pages.pelanggan.change-password.update');

    // Settings / Profile
    Route::get('/settings', [ProfileController::class, 'index'])
        ->name('pages.pelanggan.settings');
    Route::put('/settings', [ProfileController::class, 'update_profile'])
        ->name('profil.update_profile');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/bulk-delete', [CartController::class, 'bulkDestroy'])->name('cart.bulk-destroy');
});

Route::post('/address/save', [ShippingAddressController::class, 'store'])
    ->middleware('auth')
    ->name('address.save');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware('admin.auth')->name('admin.')->group(function () {

    Route::get('/dashboard_admin', function () {
        return view('pages.admin.dashboard_admin');
    })->name('dashboard');

    Route::get('/pemesanan', function () {
        return view('pages.admin.pemesanan');
    })->name('pemesanan');

    Route::get('/pembayaran', function () {
        $payments = collect();
        return view('pages.admin.pembayaran', compact('payments'));
    })->name('pembayaran');

    Route::get('/pengiriman', [PemesananController::class, 'pengiriman'])->name('pengiriman');
    Route::patch('/pengiriman/{id}/tiba', [PemesananController::class, 'tandaiSudahTiba'])->name('pengiriman.tiba');

    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');

    Route::get('/products', function (Request $request) {
        $query = Product::query();
        if ($request->category) $query->where('category', $request->category);
        if ($request->search) $query->where('name', 'like', '%' . $request->search . '%');
        $products = $query->paginate(10)->withQueryString();
        return view('pages.admin.products', compact('products'));
    })->name('products');

    Route::get('/products/create', function () {
        return view('admin.products.create');
    })->name('products.create');

    Route::post('/products', [CreateProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

    Route::get('/riwayat/kamera', function () {
        return view('pages.admin.riwayat.kamera');
    })->name('riwayat.kamera');

    Route::get('/riwayat/camping', function () {
        return view('pages.admin.riwayat.camping');
    })->name('riwayat.camping');

    Route::resource('customers', CustomerController::class);
});

/*
|--------------------------------------------------------------------------
| Edit Pemesanan Admin (tanpa middleware admin.auth — sesuai kode asli)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('admin.orders.index');
    Route::get('/pemesanan/{id}/edit', [PemesananController::class, 'edit'])->name('admin.orders.edit');
    Route::put('/pemesanan/{id}', [PemesananController::class, 'update'])->name('admin.orders.update');
});

/*
|--------------------------------------------------------------------------
| Pelanggan
|--------------------------------------------------------------------------
*/

Route::get('/profil', function () {
    return view('pelanggan.profil');
})->name('profil');

Route::get('/alamat_pengiriman', function () {
    return view('pages.pelanggan.dashboard.alamat_pengiriman');
})->name('pages.pelanggan.alamat_pengiriman');

/*
|--------------------------------------------------------------------------
| Admin Auth
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
