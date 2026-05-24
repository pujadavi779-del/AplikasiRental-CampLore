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
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CreateProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminAuthController;
use App\Models\Product;
use App\Models\Cart;

/*
|--------------------------------------------------------------------------
| Public Routes (tidak perlu login)
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('pages.landing.landing');

Route::get('/landing/about', function () {
    return view('pages.landing.about');
})->name('pages.landing.about');

Route::get('/camera', [CameraController::class, 'landing'])->name('camera.LP');
Route::get('/camping', [CampingController::class, 'landing'])->name('camping.LP');

Route::get('/camera/{id}', [CameraController::class, 'show'])->name('camera.show');
Route::get('/camping/{id}', [CampingController::class, 'show'])->name('camping.show');

/*
|--------------------------------------------------------------------------
| Auth Routes — Pelanggan (guest only, redirect jika sudah login)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/registrasi', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/registrasi', [RegisterController::class, 'register'])->name('register.submit');
});

// OTP tidak perlu guest middleware
Route::post('/otp/send',   [RegisterController::class, 'sendOtp'])->name('otp.send');
Route::post('/otp/verify', [RegisterController::class, 'verifyOtp'])->name('otp.verify');

// Logout pelanggan
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Auth Routes — (guest only untuk admin)
|--------------------------------------------------------------------------
*/

Route::get('/admin/login',  [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout',[AdminAuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Pelanggan Routes — wajib login sebagai PELANGGAN
| Middleware 'auth' = CustomerAuthenticate
| → pelanggan belum login: redirect /login
| → admin coba masuk: redirect /admin/dashboard_admin
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard pelanggan
    Route::get('/home', function () {
        return view('pages.pelanggan.home');
    })->name('pelanggan.home');

    Route::get('/dashboard_pelanggan', function () {
        return view('pages.pelanggan.dashboard.pesanan_saya');
    })->name('dashboard_pelanggan');

    // Keranjang
    Route::get('/keranjang', function () {
        $carts = Cart::where('user_id', Auth::id())->get();
        return view('pages.landing.keranjang', compact('carts'));
    })->name('pages.landing.keranjang');

    // Cart (API-style)
    Route::get('/cart',                  [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add',             [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{cart}',        [CartController::class, 'destroy'])->name('cart.destroy');
    Route::put('/cart/{cart}',           [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/bulk-delete',     [CartController::class, 'bulkDestroy'])->name('cart.bulk-destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

    // Shipping Address
    Route::put('/shipping-address',      [ShippingAddressController::class, 'update'])->name('shipping-address.update');
    Route::post('/address/save',         [ShippingAddressController::class, 'store'])->name('address.save');

    // Ganti Password
    Route::get('/change-password',       [ChangePasswordController::class, 'index'])->name('change-password');
    Route::put('/change-password/update',[ChangePasswordController::class, 'update'])->name('pages.pelanggan.change-password.update');

    // Settings / Profile
    Route::get('/settings',  [ProfileController::class, 'index'])->name('pages.pelanggan.settings');
    Route::put('/settings',  [ProfileController::class, 'update_profile'])->name('profil.update_profile');

    Route::get('/profile',   [ProfileController::class, 'index'])->middleware('auth');
    Route::post('/profile',  [ProfileController::class, 'update'])->middleware('auth');

    // Alamat pengiriman
    Route::get('/alamat_pengiriman', [App\Http\Controllers\ShippingAddressController::class, 'index'])
    ->name('pages.pelanggan.alamat_pengiriman');

    // Riwayat sewa
    Route::get('/riwayat_sewa', function () {
        return view('pages.pelanggan.riwayat_sewa');
    })->name('pages.pelanggan.riwayat_sewa');
});

/*
|--------------------------------------------------------------------------
| Admin Routes — wajib login sebagai ADMIN
| Middleware 'admin.auth' = AdminAuthenticate
| → admin belum login: redirect /admin/login
| → pelanggan coba masuk: redirect /home dengan pesan error
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware('admin.auth')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard_admin', function () {
        return view('pages.admin.dashboard_admin');
    })->name('dashboard');

    // Pemesanan
    Route::get('/pemesanan',          [PemesananController::class, 'index'])->name('orders.index');
    Route::get('/pemesanan/{id}/edit',[PemesananController::class, 'edit'])->name('orders.edit');
    Route::put('/pemesanan/{id}',     [PemesananController::class, 'update'])->name('orders.update');

    // Pembayaran
    Route::get('/pembayaran', function () {
        $payments = collect();
        return view('pages.admin.pembayaran', compact('payments'));
    })->name('pembayaran');

    // Pengiriman
    Route::get('/pengiriman',                      [DeliveryController::class, 'pengiriman'])->name('pengiriman');
    Route::get('/pengiriman/{id}',                 [DeliveryController::class, 'detail'])->name('pengiriman.detail');
    Route::post('/pengiriman/{id}/tiba',           [DeliveryController::class, 'tandaiSudahTiba'])->name('pengiriman.tiba');
    Route::patch('/pengiriman/{id}/tiba',          [DeliveryController::class, 'tandaiSudahTiba']);
    Route::patch('/pengiriman/{id}/status',        [DeliveryController::class, 'updateStatus'])->name('pengiriman.update-status');

    // Pengembalian
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');

    // Kategori Produk
    Route::get('/kategori_produk',                     [KategoriController::class, 'index'])->name('kategori_produk');
    Route::post('/kategori/tipe',                      [KategoriController::class, 'storeType'])->name('category.storeType');
    Route::post('/kategori/merek',                     [KategoriController::class, 'storeBrand'])->name('category.storeBrand');
    Route::put('/kategori/tipe/{category}',            [KategoriController::class, 'updateType'])->name('category.updateType');
    Route::put('/kategori/merek/{category}',           [KategoriController::class, 'updateBrand'])->name('category.updateBrand');
    Route::delete('/kategori/tipe/{category}',         [KategoriController::class, 'destroyType'])->name('category.destroyType');
    Route::delete('/kategori/merek/{category}',        [KategoriController::class, 'destroyBrand'])->name('category.destroyBrand');
    Route::get('/kategori/merek/{category}/detail',    [KategoriController::class, 'brandDetail'])->name('category.brandDetail');

    // Products
    Route::get('/products', function (Request $request) {
        $query = Product::query();
        if ($request->category) $query->where('category', $request->category);
        if ($request->search)   $query->where('name', 'like', '%' . $request->search . '%');
        $products = $query->paginate(10)->withQueryString();
        return view('pages.admin.products', compact('products'));
    })->name('products');

    Route::get('/products/create',       fn() => view('pages.admin.products.create'))->name('products.create');
    Route::post('/products',             [CreateProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit',    [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}',         [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}',      [ProductController::class, 'destroy'])->name('products.destroy');

    // Orders
    Route::delete('/orders/{id}',        [OrderController::class, 'destroy'])->name('orders.destroy');

    // Riwayat
    Route::get('/riwayat/kamera',  fn() => view('pages.admin.riwayat.kamera'))->name('riwayat.kamera');
    Route::get('/riwayat/camping', fn() => view('pages.admin.riwayat.camping'))->name('riwayat.camping');

    // Customers (hanya admin yang bisa kelola data pelanggan)
    Route::resource('customers', CustomerController::class);
});