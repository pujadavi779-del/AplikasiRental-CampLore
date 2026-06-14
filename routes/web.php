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
    use App\Http\Controllers\OtpController;
    use App\Http\Controllers\PaymentController;
    use App\Http\Controllers\SewaController;
    use App\Models\Barang;
    use App\Models\Cart;
    use App\Http\Controllers\Auth\ForgotPasswordController;
    use App\Http\Controllers\Admin\ReviewController;
    use App\Http\Controllers\RiwayatProdukController;
    use App\Http\Controllers\CustomerReviewController;


    /*
    |--------------------------------------------------------------------------
    | Public Routes
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
    | Auth Routes — Guest Only
    |--------------------------------------------------------------------------
    */

    Route::middleware('guest')->group(function () {
        Route::get('/login',  [LoginController::class, 'showLogin'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('login.post');

        Route::get('/registrasi',  [RegisterController::class, 'showForm'])->name('register');
        Route::post('/registrasi', [RegisterController::class, 'register'])->name('register.submit');
    });

    // OTP registrasi (guest, tidak perlu login)
    Route::post('/otp/send',   [RegisterController::class, 'sendOtp'])->name('otp.send');
    Route::post('/otp/verify', [RegisterController::class, 'verifyOtp'])->name('otp.verify');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Lupa Password Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])
        ->name('password.request');

    Route::post('/forgot-password/send-otp', [ForgotPasswordController::class, 'sendOtp'])
        ->name('password.send-otp');

    Route::post('/forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])
        ->name('password.verify-otp');

    Route::get('/forgot-password/reset', [ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset.form');

    Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])
        ->name('password.reset');

    /*
    |--------------------------------------------------------------------------
    | Admin Auth Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/login',   [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login',  [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    /*
    |--------------------------------------------------------------------------
    | Pelanggan Routes — wajib login
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth')->group(function () {

        // Dashboard
        Route::get('/home', fn() => view('pages.landing.landing'))->name('landing.landing');
        Route::get('/dashboard_pelanggan', [SewaController::class, 'index'])->name('dashboard_pelanggan');

        // Keranjang
        Route::get('/keranjang', function () {
            $carts = Cart::where('user_id', Auth::id())->get();
            return view('pages.landing.keranjang', compact('carts'));
        })->name('pages.landing.keranjang');

        // Cart
        Route::get('/cart',              [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add',         [CartController::class, 'add'])->name('cart.add');
        Route::delete('/cart/{cart}',    [CartController::class, 'destroy'])->name('cart.destroy');
        Route::put('/cart/{cart}',       [CartController::class, 'update'])->name('cart.update');
        Route::post('/cart/bulk-delete', [CartController::class, 'bulkDestroy'])->name('cart.bulk-destroy');

        // Checkout
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

        // Shipping Address
        Route::put('/shipping-address',  [ShippingAddressController::class, 'update'])->name('shipping-address.update');
        Route::post('/address/save',     [ShippingAddressController::class, 'store'])->name('address.save');
        Route::get('/alamat_pengiriman', [ShippingAddressController::class, 'index'])->name('pages.pelanggan.alamat_pengiriman');

        // Ganti Password
        Route::get('/change-password',        [ChangePasswordController::class, 'index'])->name('change-password');
        Route::put('/change-password/update', [ChangePasswordController::class, 'update'])->name('pages.pelanggan.change-password.update');

        // Settings / Profile 
        Route::get('/settings', [ProfileController::class, 'index'])->name('pages.pelanggan.settings');
        Route::put('/settings', [ProfileController::class, 'update_profile'])->name('profil.update_profile');

        // OTP nomor telepon (butuh login)
        Route::post('/otp/phone/send',   [OtpController::class, 'sendPhone'])->name('otp.phone.send');
        Route::post('/otp/phone/verify', [OtpController::class, 'verifyPhone'])->name('otp.phone.verify');

        // Riwayat sewa
        Route::get('/riwayat_sewa', fn() => view('pages.pelanggan.riwayat_sewa'))->name('pages.pelanggan.riwayat_sewa');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')->middleware('admin.auth')->name('admin.')->group(function () {

        Route::get('/dashboard_admin', fn() => view('pages.admin.dashboard_admin'))->name('dashboard');

        // Pemesanan
        Route::get('/pemesanan',           [PemesananController::class, 'index'])->name('pesanan.index');
        Route::get('/pemesanan/{id}/edit', [PemesananController::class, 'edit'])->name('pesanan.edit');
        Route::put('/pemesanan/{id}',      [PemesananController::class, 'update'])->name('pesanan.update');

        // Pembayaran - BARU
        Route::get('/pembayaran', [PaymentController::class, 'adminIndex'])->name('pembayaran');
        Route::post('/pembayaran/{id}/kirim', [PaymentController::class, 'kirimPesanan'])->name('pembayaran.kirim'); // ← Tambahkan baris ini
        Route::get('/pembayaran/export', [PaymentController::class, 'exportExcel'])->name('pembayaran.export');



        // Pengiriman
        Route::get('/pengiriman',                 [DeliveryController::class, 'pengiriman'])->name('pengiriman');
        Route::get('/pengiriman/{id}',            [DeliveryController::class, 'detail'])->name('pengiriman.detail');
        Route::post('/pengiriman/{id}/tiba',      [DeliveryController::class, 'tandaiSudahTiba'])->name('pengiriman.tiba');
        Route::patch('/pengiriman/{id}/tiba',     [DeliveryController::class, 'tandaiSudahTiba']);
        Route::patch('/pengiriman/{id}/status',   [DeliveryController::class, 'updateStatus'])->name('pengiriman.update-status');

        // Pengembalian
        Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');
        Route::post('/pengembalian/{orderId}/konfirmasi', [PengembalianController::class, 'konfirmasi'])->name('pengembalian.konfirmasi');

        // Kategori
        Route::get('/kategori_produk',                  [KategoriController::class, 'index'])->name('kategori_produk');
        Route::post('/kategori/tipe',                   [KategoriController::class, 'storeType'])->name('category.storeType');
        Route::post('/kategori/merek',                  [KategoriController::class, 'storeBrand'])->name('category.storeBrand');
        Route::put('/kategori/tipe/{kategori}',         [KategoriController::class, 'updateType'])->name('category.updateType');
        Route::put('/kategori/merek/{kategori}',        [KategoriController::class, 'updateBrand'])->name('category.updateBrand');
        Route::delete('/kategori/tipe/{kategori}',      [KategoriController::class, 'destroyType'])->name('category.destroyType');
        Route::delete('/kategori/merek/{kategori}',     [KategoriController::class, 'destroyBrand'])->name('category.destroyBrand');
        Route::get('/kategori/merek/{kategori}/detail', [KategoriController::class, 'brandDetail'])->name('category.brandDetail');

        // Products
        Route::get('/products', function (Request $request) {
            $query = Barang::query();
            if ($request->kategori) $query->where('kategori', $request->kategori);
            if ($request->search)   $query->where('name', 'like', '%' . $request->search . '%');
            $products = $query->paginate(10)->withQueryString();
            return view('pages.admin.products', compact('products'));
        })->name('products');

        Route::get('/products/create', [ProductController::class, 'create'])
            ->name('products.create');
        Route::post('/products',          [CreateProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}',      [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}',   [ProductController::class, 'destroy'])->name('products.destroy');

        // Orders
        Route::delete('/pesanan/{id}', [OrderController::class, 'destroy'])->name('pesanan.destroy');

        // Riwayat
        Route::get(
            '/riwayat-produk',
            [RiwayatProdukController::class, 'index']
        )->name('riwayat-produk');

        // Customers
        Route::resource('customers', CustomerController::class);
    });

    // Route untuk meminta token pembayaran (harus login)
    Route::middleware(['auth'])->group(function () {
        Route::post('/payment/token', [PaymentController::class, 'getToken'])->name('payment.token');
        Route::post('/payment/snap-token', [PaymentController::class, 'getSnapToken'])->name('payment.snap-token');
        Route::post('/pesanan/cancel', [OrderController::class, 'cancel'])->name('pesanan.cancel');  // ← tambah ini
        Route::post('/pesanan/store', [OrderController::class, 'store'])->name('pesanan.store');
        Route::post('/payment/update-status', [PaymentController::class, 'updateStatusAfterPay'])
            ->name('payment.update-status');
    });

    // Route Webhook untuk menerima notifikasi dari Midtrans (Jangan diberi middleware auth)
    Route::post('/payment/webhook', [PaymentController::class, 'webhook']);

    // ============================================================
    // 1. ROUTES → Ulasan Pelanggan (Admin)
    // ============================================================

    Route::middleware(['auth:admin', 'admin.auth'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/reviews', [ReviewController::class, 'index'])
                ->name('reviews.index');

            Route::put('/reviews/{review}/balas_pesan', [ReviewController::class, 'balas_pesan'])
                ->name('reviews.balas_pesan');
        });

    // Route Sewa Pelanggan
    Route::middleware('auth')->group(function () {
        Route::get('/ulasan/{orderId}/tulis', [CustomerReviewController::class, 'create'])
            ->name('pelanggan.ulasan.create');
        Route::post('/ulasan/{orderId}/simpan', [CustomerReviewController::class, 'store'])
            ->name('pelanggan.ulasan.store');
        Route::get('/sewa', [SewaController::class, 'index'])
        ->name('pelanggan.sewa');
        //ualsan detail pelanggan
        Route::get('/ulasan/{reviewId}/detail', [CustomerReviewController::class, 'show'])
        ->name('pelanggan.ulasan.show');
    });
