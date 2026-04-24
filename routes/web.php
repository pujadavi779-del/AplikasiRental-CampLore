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
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChangePasswordController;
// Models
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

//PROFILE
Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::post('/profile', [ProfileController::class, 'update'])->middleware('auth');

// LOGIN
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/camping', [CampingController::class, 'index'])->name('camping.LP');
// Landing & Informasi
Route::get('/landing/about', function () {
    return view('pages.landing.about');
})->name('about');



// Camera Landing Page
Route::get('/camera', [CameraController::class, 'landing'])->name('camera.LP');
Route::get('/camping', [CampingController::class, 'landing'])->name('camping.LP');

// Detail Camera
Route::get('/camera/{id}', [CameraController::class, 'show'])->name('camera.show');
Route::get('/camping/{id}', [CampingController::class, 'show'])->name('camping.show');
// Rental Page
Route::get('/rental', function () {
    return view('rental');
})->name('rental');

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
        return view('dashboard_pelanggan');
    })->name('dashboard_pelanggan');

    // Checkout
    Route::get('/checkout', function () {
        return view('checkout');
    })->name('checkout');



    Route::get('/pembayaran', function () {
        $payments = collect();
        return view('admin.pembayaran', compact('payments'));
    })->name('pembayaran');


    Route::put('/shipping-address', [ShippingAddressController::class, 'update'])
        ->name('shipping-address.update');
});

Route::post('/address/save', [\App\Http\Controllers\ShippingAddressController::class, 'store'])
    ->middleware('auth')
    ->name('address.save');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard_admin', function () {
        return view('dashboard_admin');
    })->name('dashboard');

    // Pemesanan
    Route::get('/pemesanan', function () {
        return view('admin.pemesanan');
    })->name('pemesanan');

    // Pembayaran
    Route::get('/pembayaran', function () {
        $payments = collect();
        return view('admin.pembayaran', compact('payments'));
    })->name('pembayaran');

    // Pengiriman
    Route::get('/pengiriman', [DeliveryController::class, 'index'])
        ->name('pengiriman');

    // Pengembalian
    Route::get('/pengembalian', function () {
        return view('admin.pengembalian');
    })->name('pengembalian');

    // Products
    Route::get('/products', function (Request $request) {

        $query = Product::query();

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(10)->withQueryString();

        return view('admin.products', compact('products'));
    })->name('products');

    // Orders
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])
        ->name('orders.destroy');

    // Riwayat


    Route::get('/riwayat/kamera', function () {
        return view('admin.riwayat.kamera');
    })->name('riwayat.kamera');

    Route::get('/riwayat/camping', function () {
        return view('admin.riwayat.camping');
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
    return view('pages.pelanggan.alamat_pengiriman');
})->name('pages.pelanggan.alamat_pengiriman');
