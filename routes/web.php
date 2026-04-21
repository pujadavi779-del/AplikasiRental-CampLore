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

// Models
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/camping', [CampingController::class, 'index'])->name('camping.LP');
// Landing & Informasi
Route::get('/about', function () {
    return view('about');
})->name('about');

// Produk
Route::resource('camping', CampingController::class);
Route::resource('camera', CameraController::class);



// Camera Landing Page
Route::get('/camera', [CameraController::class, 'landing'])->name('camera.LP');
Route::get('/camping', [CampingController::class, 'landing'])->name('camping.LP');

// Detail Camera
Route::get('/camera/{id}', [CameraController::class, 'show'])->name('camera.show');

// Rental Page
Route::get('/rental', function () {
    return view('rental');
})->name('rental');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/registrasi', [RegisterController::class, 'showForm'])->name('register');
Route::post('/registrasi', [RegisterController::class, 'register'])->name('register.submit');

// OTP
Route::post('/otp/send', [RegisterController::class, 'sendOtp'])->name('otp.send');
Route::post('/otp/verify', [RegisterController::class, 'verifyOtp'])->name('otp.verify');

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

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


    // Shipping Address
    Route::get('/shipping-address', [ShippingAddressController::class, 'index'])
        ->name('shipping-address');

    Route::get('/pembayaran', function () {
        $payments = collect();
        return view('admin.pembayaran', compact('payments'));
    })->name('pembayaran');


    Route::put('/shipping-address', [ShippingAddressController::class, 'update'])
        ->name('shipping-address.update');
});

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

Route::get('/ubah_password', function () {
    return view('pelanggan.ubah_password');
})->name('ubah_password');

// Route Pengaturan / Settings
Route::get('/settings', function () {
    return view('pelanggan.settings');
})->name('settings');

// Route Alamat Pengiriman
Route::get('/alamat_pengiriman', function () {
    return view('pelanggan.alamat_pengiriman');
})->name('alamat_pengiriman');
