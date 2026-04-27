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
// Models
use App\Models\Product;

//ADMIN
use App\Http\Controllers\AdminAuthController;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

//LANDING PAGE
Route::get('/rental', function () {
    return view('pages.landing.rental');
})->name('pages.landing.rental');




//PROFILE
Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::post('/profile', [ProfileController::class, 'update'])->middleware('auth');

// LOGIN
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/', [LandingController::class, 'index'])->name('pages.landing.landing');
Route::get('/camping', [CampingController::class, 'index'])->name('pages.camping.landing');
// Landing & Informasi
Route::get('/landing/about', function () {
    return view('pages.landing.about');
})->name('pages.landing.about');



// Camera Landing Page
Route::get('/camera', [CameraController::class, 'landing'])->name('camera.LP');
Route::get('/camping', [CampingController::class, 'landing'])->name('camping.LP');

// Detail Camera
Route::get('/camera/{id}', [CameraController::class, 'show'])->name('camera.show');
Route::get('/camping/{id}', [CampingController::class, 'show'])->name('camping.show');
// Rental Page


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/registrasi', [RegisterController::class, 'showForm'])->name('register');
Route::post('/registrasi', [RegisterController::class, 'register'])->name('register.submit');

// OTP
Route::post('/otp/send', [RegisterController::class, 'sendOtp'])->name('otp.send');
Route::post('/otp/verify', [RegisterController::class, 'verifyOtp'])->name('otp.verify');

/*
|--------------------------------------------------------------------------
| User Dashboard (Auth Required)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/dashboard_pelanggan', function () {
        return view('pages.pelanggan.dashboard.pesanan_saya');
    })->name('dashboard_pelanggan');

    // Checkout
    Route::get('/checkout', function () {
        return view('pages.pelanggan.checkout');
    })->name('checkout');


    Route::get('/pembayaran', function () {
        $payments = collect();
        return view('admin.pembayaran', compact('payments'));
    })->name('pembayaran');


    Route::put('/shipping-address', [ShippingAddressController::class, 'update'])
        ->name('shipping-address.update');
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

    // Dashboard
    Route::get('/dashboard_admin', function () {
        return view('pages.admin.dashboard_admin');
    })->name('dashboard');

    // Pemesanan
    Route::get('/pemesanan', function () {
        return view('pages.admin.pemesanan');
    })->name('pemesanan');

    // Pembayaran
    Route::get('/pembayaran', function () {
        $payments = collect();
        return view('pages.admin.pembayaran', compact('payments'));
    })->name('pembayaran');

    // Pengiriman
    Route::get('/pengiriman', [PemesananController::class, 'pengiriman'])->name('pengiriman');
    Route::patch('/pengiriman/{id}/tiba', [PemesananController::class, 'tandaiSudahTiba'])->name('pengiriman.tiba');

    // Pengembalian
    Route::get('/pengembalian', function () {
        return view('pages.admin.pengembalian');
    })->name('pengembalian');

    Route::get('/pengembalian', [PengembalianController::class, 'index'])
        ->name('pengembalian');

    // Products
    Route::get('/products', function (Request $request) {
        $query = Product::query();
        if ($request->category) $query->where('category', $request->category);

        if ($request->search) $query->where('name', 'like', '%' . $request->search . '%');

        $products = $query->paginate(10)->withQueryString();

        return view('pages.admin.products', compact('products'));
    })->name('products');

    //tambah produk
    Route::get('/products/create', function () {
        return view('admin.products.create');
    })->name('products.create');

    Route::post('/products', [CreateProductController::class, 'store'])->name('products.store');

    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}',      [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}',   [ProductController::class, 'destroy'])->name('products.destroy');


    // Orders
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])
        ->name('orders.destroy');

    // Riwayat
    Route::get('/riwayat/kamera', function () {
        return view('pages.admin.riwayat.kamera');
    })->name('riwayat.kamera');

    Route::get('/riwayat/camping', function () {
        return view('pages.admin.riwayat.camping');
    })->name('riwayat.camping');


    // Customers
    Route::resource('customers', CustomerController::class);
});

/*
|--------------------------------------------------------------------------
| Pelanggan Routes
|--------------------------------------------------------------------------
*/
// Route Riwayat Sewa (Halaman Profil)
Route::get('/profil', function () {
    return view('pelanggan.profil');
})->name('profil');



// ... (di dalam atau di luar middleware auth, pastikan bisa diakses pelanggan)

Route::middleware('auth')->group(function () {

    // Menampilkan halaman form ganti password
    Route::get('/change-password', [ChangePasswordController::class, 'index'])
        ->name('change-password');

    // Menangani proses update password (ini yang tadi error karena tidak ada)
    Route::put('/change-password/update', [ChangePasswordController::class, 'update'])
        ->name('pages.pelanggan.change-password.update');
});

// Route Pengaturan / Settings
Route::middleware('auth')->group(function () {

    // TAMPIL HALAMAN SETTINGS
    Route::get('/settings', [ProfileController::class, 'index'])
        ->name('pages.pelanggan.settings');

    // UPDATE PROFILE
    Route::put('/settings', [ProfileController::class, 'update_profile'])
        ->name('profil.update_profile');
});


// Route Alamat Pengiriman
Route::get('/alamat_pengiriman', function () {
    return view('pages.pelanggan.dashboard.alamat_pengiriman');
})->name('pages.pelanggan.alamat_pengiriman');


// LOGIN ADMIN
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Edit Pemesanan Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('admin.orders.index');
    Route::get('/pemesanan/{id}/edit', [PemesananController::class, 'edit'])->name('admin.orders.edit');
    Route::put('/pemesanan/{id}', [PemesananController::class, 'update'])->name('admin.orders.update');
    // Route::delete('/pemesanan/{id}', [PemesananController::class, 'destroy'])->name('admin.orders.destroy');
});