<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Saya - Camplore</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-[#1A392D]">

    <!-- Panggil Navbar Terpisah -->
    @include('navbar')

    <main class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold mb-8">Keranjang <span class="text-[#FF6B95]">Sewa</span></h1>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Daftar Produk -->
            <div class="flex-grow space-y-4">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-pink-50 flex gap-6 items-center">
                    <div class="w-32 h-32 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                        <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-lg font-bold">Sony Alpha A7 III</h3>
                        <p class="text-sm text-gray-500 mb-4">Kategori: Kamera Profesional</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-[#FF6B95]">Rp 250.000 <span class="text-xs text-gray-400">/hari</span></span>
                            <div class="flex items-center gap-3 border border-pink-100 rounded-lg p-1">
                                <button class="w-8 h-8 flex items-center justify-center hover:bg-pink-50 rounded">-</button>
                                <span class="font-bold">1 Hari</span>
                                <button class="w-8 h-8 flex items-center justify-center hover:bg-pink-50 rounded">+</button>
                            </div>
                        </div>
                    </div>
                    <button class="text-gray-300 hover:text-red-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Ringkasan Bayar -->
            <div class="w-full lg:w-96">
                <div class="bg-[#1A392D] text-white p-8 rounded-3xl shadow-xl sticky top-24">
                    <h2 class="text-xl font-bold mb-6 border-b border-white/10 pb-4">Ringkasan Sewa</h2>
                    <div class="space-y-4 mb-8 text-sm">
                        <div class="flex justify-between opacity-80">
                            <span>Subtotal Produk</span>
                            <span>Rp 250.000</span>
                        </div>
                        <div class="flex justify-between opacity-80">
                            <span>Biaya Layanan</span>
                            <span>Rp 10.000</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold border-t border-white/10 pt-4">
                            <span>Total Harga</span>
                            <span class="text-[#FF6B95]">Rp 260.000</span>
                        </div>
                    </div>
                    <button class="w-full bg-[#FF6B95] text-white py-4 rounded-xl font-bold hover:shadow-lg hover:brightness-110 transition-all transform active:scale-95">
                        Lanjut ke Pembayaran
                    </button>
                    <p class="text-[10px] text-center mt-4 opacity-50 italic">Syarat & Ketentuan berlaku untuk penyewaan alat.</p>
                </div>
            </div>
        </div>
    </main>

</body>

</html>