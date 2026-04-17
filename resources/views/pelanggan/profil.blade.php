<!DOCTYPE html>

<html lang="id">



<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Sewa - Camplore</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        [x-cloak] {

            display: none !important;

        }



        /* Font khusus agar terlihat lebih profesional (opsional) */

        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap');



        body {

            font-family: 'DM Sans', sans-serif;

            background-color: #f7fafc;

            /* Abu-abu sangat muda untuk background */

        }
    </style>

</head>



<body x-data="{ activeTab: 'all' }" class="p-6 md:p-10">



    <header class="flex items-center justify-between p-4 mb-10 bg-white shadow-sm rounded-2xl border border-gray-100">

        <div class="flex items-center gap-6">

            <div class="flex items-center justify-center flex-shrink-0 w-9 h-9 bg-green-700 rounded-lg">

                <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">

                    <path d="M12 2l10 16H2L12 2z" stroke-linecap="round" stroke-linejoin="round" />

                </svg>

            </div>

            <span class="text-xl font-bold text-gray-900">My<span class="text-green-700">Lodies</span></span>



            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">

                <a href="#" class="hover:text-green-700 transition">Beranda</a>

                <a href="#" class="hover:text-green-700 transition">Tentang</a>

                <a href="#" class="hover:text-green-700 transition">Katalog</a>

            </nav>

        </div>



        <div class="flex items-center gap-4">

            <div class="relative w-64 hidden md:block">

                <span class="absolute inset-y-0 left-0 flex items-center pl-3">

                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" />

                    </svg>

                </span>

                <input type="text" placeholder="Cari unit atau pesanan..." class="w-full py-2 pl-10 pr-4 text-xs bg-gray-50 border-none rounded-xl focus:ring-1 focus:ring-green-700 outline-none">

            </div>

            <div class="relative cursor-pointer hover:scale-105 transition">

                <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="1.5" />

                </svg>

                <span class="absolute top-0 right-0 w-2 h-2 bg-pink-600 rounded-full border-2 border-white"></span>

            </div>

            <img src="https://ui-avatars.com/api/?name=M+Falih+Hilmy&background=16a34a&color=fff&size=40&bold=true" alt="M. Falih Hilmy" class="w-10 h-10 rounded-full border-2 border-green-100 shadow-sm">

        </div>

    </header>



    <div class="flex flex-col lg:flex-row gap-10">



        <aside class="w-full lg:w-72 space-y-8 bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex-shrink-0">

            <div class="text-center">

                <img src="https://ui-avatars.com/api/?name=M+Falih+Hilmy&background=16a34a&color=fff&size=120&bold=true" alt="Foto M. Falih Hilmy" class="w-28 h-28 rounded-full border-4 border-green-100 object-cover shadow-sm mx-auto mb-5">

                <h2 class="text-lg font-semibold text-gray-900">M. Falih Hilmy</h2>

                <p class="text-xs text-green-700">falihhilmy72@gmail.com</p>

            </div>



            <nav class="space-y-3 pt-6 border-t border-gray-100">

                <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-semibold text-pink-700 rounded-xl bg-pink-50 shadow-inner transition">

                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />

                    </svg>

                    Riwayat Sewa

                </a>

                <a href="/ubah_password" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50 hover:text-green-800 transition">

                    <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />

                    </svg>

                    Ubah Password

                </a>

                <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50 hover:text-green-800 transition">

                    <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                    </svg>

                    Pengaturan

                </a>

                <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50 hover:text-green-800 transition">

                    <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />

                    </svg>

                    Alamat Pengiriman

                </a>

            </nav>



            <button class="w-full text-center flex items-center justify-center gap-3 px-3 py-2 text-xs font-semibold text-gray-400 rounded-xl hover:bg-pink-50 hover:text-pink-700 transition mt-6">

                Keluar

            </button>

        </aside>



        <main class="flex-1 bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100">



            <div class="mb-10 text-center sm:text-left">

                <h1 class="text-3xl font-bold text-gray-900 leading-tight">Riwayat Sewa</h1>

                <p class="text-sm text-gray-500 mt-1">Pantau dan kelola semua transaksi rental kamera & camping Anda di satu tempat.</p>

            </div>



            <div class="flex flex-wrap items-center gap-2.5 mb-10 bg-gray-50 rounded-2xl p-4 border border-gray-100 shadow-inner">

                <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-green-700 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100'" class="px-4 py-2 rounded-full text-xs font-semibold transition">Semua</button>

                <button @click="activeTab = 'pending'" :class="activeTab === 'pending' ? 'bg-pink-100 text-pink-700 shadow-sm border border-pink-200' : 'bg-white text-gray-600 hover:bg-pink-50'" class="px-4 py-2 rounded-full text-xs font-semibold transition">Menunggu</button>

                <button @click="activeTab = 'processing'" :class="activeTab === 'processing' ? 'bg-pink-100 text-pink-700 shadow-sm border border-pink-200' : 'bg-white text-gray-600 hover:bg-pink-50'" class="px-4 py-2 rounded-full text-xs font-semibold transition">Proses</button>

                <button @click="activeTab = 'shipped'" :class="activeTab === 'shipped' ? 'bg-pink-100 text-pink-700 shadow-sm border border-pink-200' : 'bg-white text-gray-600 hover:bg-pink-50'" class="px-4 py-2 rounded-full text-xs font-semibold transition">Dikirim</button>

                <button @click="activeTab = 'arrive'" :class="activeTab === 'arrive' ? 'bg-green-100 text-green-700 shadow-sm border border-green-200' : 'bg-white text-gray-600 hover:bg-green-50'" class="px-4 py-2 rounded-full text-xs font-semibold transition">Tiba</button>

                <button @click="activeTab = 'returned'" :class="activeTab === 'returned' ? 'bg-green-100 text-green-700 shadow-sm border border-green-200' : 'bg-white text-gray-600 hover:bg-green-50'" class="px-4 py-2 rounded-full text-xs font-semibold transition">Dikembalikan</button>

            </div>



            <div class="space-y-6">

                <div x-show="activeTab === 'all' || activeTab === 'arrive'" x-cloak class="bg-white p-6 rounded-3xl border border-gray-100 flex flex-col sm:flex-row items-center gap-6 cursor-pointer hover:bg-green-50/20 transition hover:shadow-sm">

                    <div class="flex items-center justify-center flex-shrink-0 w-16 h-16 bg-green-50 rounded-2xl border border-green-100">

                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />

                        </svg>

                    </div>

                    <div class="flex-1 space-y-1">

                        <h4 class="font-semibold text-gray-900">Sewa Kamera Mirrorless Sony A7 Mark III Kit 28-70mm</h4>

                        <p class="text-xs text-gray-400">ID Pesanan: CL-RENT-34502</p>

                        <p class="text-[11px] text-green-700 italic">Dipesan pada: 12 Jan 2026, 14:30</p>

                    </div>

                    <div class="text-center sm:text-right">

                        <p class="text-lg font-bold text-gray-900">Rp 350.000</p>

                        <span class="inline-block mt-2 px-3 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-100 shadow-inner">Selesai / Tiba</span>

                    </div>

                    <button class="flex items-center gap-1.5 px-4 py-2 border border-gray-100 text-gray-600 rounded-xl text-xs font-semibold hover:bg-gray-50 hover:text-green-800 transition shadow-sm">

                        Detail

                    </button>

                </div>



                <div x-show="activeTab === 'all' || activeTab === 'pending'" x-cloak class="bg-white p-6 rounded-3xl border border-gray-100 flex flex-col sm:flex-row items-center gap-6 cursor-pointer hover:bg-pink-50/20 transition hover:shadow-sm">

                    <div class="flex items-center justify-center flex-shrink-0 w-16 h-16 bg-pink-50 rounded-2xl border border-pink-100">

                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path d="M12 2l10 16H2L12 2z" stroke-width="1.5" />

                        </svg>

                    </div>

                    <div class="flex-1 space-y-1">

                        <h4 class="font-semibold text-gray-900">Sewa Tenda Camping Kapasitas 4 Orang (Tenda Dome)</h4>

                        <p class="text-xs text-gray-400">ID Pesanan: CL-RENT-34503</p>

                        <p class="text-[11px] text-pink-700 italic">Dipesan pada: 12 Jan 2026, 10:15</p>

                    </div>

                    <div class="text-center sm:text-right">

                        <p class="text-lg font-bold text-gray-900">Rp 120.000</p>

                        <span class="inline-block mt-2 px-3 py-1 rounded-full text-[10px] font-bold bg-pink-50 text-pink-700 border border-pink-100 shadow-inner">Menunggu Verifikasi</span>

                    </div>

                    <button class="flex items-center gap-1.5 px-4 py-2 border border-gray-100 text-gray-600 rounded-xl text-xs font-semibold hover:bg-gray-50 hover:text-green-800 transition shadow-sm">

                        Detail

                    </button>

                </div>



                <div x-show="activeTab === 'all' || activeTab === 'processing'" x-cloak class="bg-white p-6 rounded-3xl border border-gray-100 flex flex-col sm:flex-row items-center gap-6 cursor-pointer hover:bg-pink-50/20 transition hover:shadow-sm">

                    <div class="flex items-center justify-center flex-shrink-0 w-16 h-16 bg-pink-50 rounded-2xl border border-pink-100">

                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path d="M10 21h4a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="1.5" />

                        </svg>

                    </div>

                    <div class="flex-1 space-y-1">

                        <h4 class="font-semibold text-gray-900">Sewa Tas Carrier Eiger 60L + Cover Bag</h4>

                        <p class="text-xs text-gray-400">ID Pesanan: CL-RENT-34501</p>

                        <p class="text-[11px] text-pink-700 italic">Dipesan pada: 11 Jan 2026, 09:00</p>

                    </div>

                    <div class="text-center sm:text-right">

                        <p class="text-lg font-bold text-gray-900">Rp 80.000</p>

                        <span class="inline-block mt-2 px-3 py-1 rounded-full text-[10px] font-bold bg-pink-50 text-pink-700 border border-pink-100 shadow-inner">Sedang Diproses</span>

                    </div>

                    <button class="flex items-center gap-1.5 px-4 py-2 border border-gray-100 text-gray-600 rounded-xl text-xs font-semibold hover:bg-gray-50 hover:text-green-800 transition shadow-sm">

                        Detail

                    </button>

                </div>



            </div>



            <footer class="mt-16 text-center text-xs text-gray-300">

                &copy; 2026 Camplore - Penyewaan Alat Camping & Kamera Terpercaya. All Rights Reserved.

            </footer>

        </main>

    </div>



</body>



</html>
<!DOCTYPE html>

<html lang="id">



<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Sewa - Camplore</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        [x-cloak] {

            display: none !important;

        }



        /* Font khusus agar terlihat lebih profesional (opsional) */

        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap');



        body {

            font-family: 'DM Sans', sans-serif;

            background-color: #f7fafc;

            /* Abu-abu sangat muda untuk background */

        }
    </style>

</head>



<body x-data="{ activeTab: 'all' }" class="p-6 md:p-10">



    <header class="flex items-center justify-between p-4 mb-10 bg-white shadow-sm rounded-2xl border border-gray-100">

        <div class="flex items-center gap-6">

            <div class="flex items-center justify-center flex-shrink-0 w-9 h-9 bg-green-700 rounded-lg">

                <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">

                    <path d="M12 2l10 16H2L12 2z" stroke-linecap="round" stroke-linejoin="round" />

                </svg>

            </div>

            <span class="text-xl font-bold text-gray-900">My<span class="text-green-700">Lodies</span></span>



            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">

                <a href="#" class="hover:text-green-700 transition">Beranda</a>

                <a href="#" class="hover:text-green-700 transition">Tentang</a>

                <a href="#" class="hover:text-green-700 transition">Katalog</a>

            </nav>

        </div>



        <div class="flex items-center gap-4">

            <div class="relative w-64 hidden md:block">

                <span class="absolute inset-y-0 left-0 flex items-center pl-3">

                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" />

                    </svg>

                </span>

                <input type="text" placeholder="Cari unit atau pesanan..." class="w-full py-2 pl-10 pr-4 text-xs bg-gray-50 border-none rounded-xl focus:ring-1 focus:ring-green-700 outline-none">

            </div>

            <div class="relative cursor-pointer hover:scale-105 transition">

                <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="1.5" />

                </svg>

                <span class="absolute top-0 right-0 w-2 h-2 bg-pink-600 rounded-full border-2 border-white"></span>

            </div>

            <img src="https://ui-avatars.com/api/?name=M+Falih+Hilmy&background=16a34a&color=fff&size=40&bold=true" alt="M. Falih Hilmy" class="w-10 h-10 rounded-full border-2 border-green-100 shadow-sm">

        </div>

    </header>



    <div class="flex flex-col lg:flex-row gap-10">



        <aside class="w-full lg:w-72 space-y-8 bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex-shrink-0">

            <div class="text-center">

                <img src="https://ui-avatars.com/api/?name=M+Falih+Hilmy&background=16a34a&color=fff&size=120&bold=true" alt="Foto M. Falih Hilmy" class="w-28 h-28 rounded-full border-4 border-green-100 object-cover shadow-sm mx-auto mb-5">

                <h2 class="text-lg font-semibold text-gray-900">M. Falih Hilmy</h2>

                <p class="text-xs text-green-700">falihhilmy72@gmail.com</p>

            </div>



            <nav class="space-y-3 pt-6 border-t border-gray-100">

                <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-semibold text-pink-700 rounded-xl bg-pink-50 shadow-inner transition">

                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />

                    </svg>

                    Riwayat Sewa

                </a>

                <a href="/ubah_password" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50 hover:text-green-800 transition">

                    <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />

                    </svg>

                    Ubah Password

                </a>

                <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50 hover:text-green-800 transition">

                    <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                    </svg>

                    Pengaturan

                </a>

                <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50 hover:text-green-800 transition">

                    <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />

                    </svg>

                    Alamat Pengiriman

                </a>

            </nav>



            <button class="w-full text-center flex items-center justify-center gap-3 px-3 py-2 text-xs font-semibold text-gray-400 rounded-xl hover:bg-pink-50 hover:text-pink-700 transition mt-6">

                Keluar

            </button>

        </aside>



        <main class="flex-1 bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100">



            <div class="mb-10 text-center sm:text-left">

                <h1 class="text-3xl font-bold text-gray-900 leading-tight">Riwayat Sewa</h1>

                <p class="text-sm text-gray-500 mt-1">Pantau dan kelola semua transaksi rental kamera & camping Anda di satu tempat.</p>

            </div>



            <div class="flex flex-wrap items-center gap-2.5 mb-10 bg-gray-50 rounded-2xl p-4 border border-gray-100 shadow-inner">

                <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-green-700 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100'" class="px-4 py-2 rounded-full text-xs font-semibold transition">Semua</button>

                <button @click="activeTab = 'pending'" :class="activeTab === 'pending' ? 'bg-pink-100 text-pink-700 shadow-sm border border-pink-200' : 'bg-white text-gray-600 hover:bg-pink-50'" class="px-4 py-2 rounded-full text-xs font-semibold transition">Menunggu</button>

                <button @click="activeTab = 'processing'" :class="activeTab === 'processing' ? 'bg-pink-100 text-pink-700 shadow-sm border border-pink-200' : 'bg-white text-gray-600 hover:bg-pink-50'" class="px-4 py-2 rounded-full text-xs font-semibold transition">Proses</button>

                <button @click="activeTab = 'shipped'" :class="activeTab === 'shipped' ? 'bg-pink-100 text-pink-700 shadow-sm border border-pink-200' : 'bg-white text-gray-600 hover:bg-pink-50'" class="px-4 py-2 rounded-full text-xs font-semibold transition">Dikirim</button>

                <button @click="activeTab = 'arrive'" :class="activeTab === 'arrive' ? 'bg-green-100 text-green-700 shadow-sm border border-green-200' : 'bg-white text-gray-600 hover:bg-green-50'" class="px-4 py-2 rounded-full text-xs font-semibold transition">Tiba</button>

                <button @click="activeTab = 'returned'" :class="activeTab === 'returned' ? 'bg-green-100 text-green-700 shadow-sm border border-green-200' : 'bg-white text-gray-600 hover:bg-green-50'" class="px-4 py-2 rounded-full text-xs font-semibold transition">Dikembalikan</button>

            </div>



            <div class="space-y-6">

                <div x-show="activeTab === 'all' || activeTab === 'arrive'" x-cloak class="bg-white p-6 rounded-3xl border border-gray-100 flex flex-col sm:flex-row items-center gap-6 cursor-pointer hover:bg-green-50/20 transition hover:shadow-sm">

                    <div class="flex items-center justify-center flex-shrink-0 w-16 h-16 bg-green-50 rounded-2xl border border-green-100">

                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />

                        </svg>

                    </div>

                    <div class="flex-1 space-y-1">

                        <h4 class="font-semibold text-gray-900">Sewa Kamera Mirrorless Sony A7 Mark III Kit 28-70mm</h4>

                        <p class="text-xs text-gray-400">ID Pesanan: CL-RENT-34502</p>

                        <p class="text-[11px] text-green-700 italic">Dipesan pada: 12 Jan 2026, 14:30</p>

                    </div>

                    <div class="text-center sm:text-right">

                        <p class="text-lg font-bold text-gray-900">Rp 350.000</p>

                        <span class="inline-block mt-2 px-3 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-100 shadow-inner">Selesai / Tiba</span>

                    </div>

                    <button class="flex items-center gap-1.5 px-4 py-2 border border-gray-100 text-gray-600 rounded-xl text-xs font-semibold hover:bg-gray-50 hover:text-green-800 transition shadow-sm">

                        Detail

                    </button>

                </div>



                <div x-show="activeTab === 'all' || activeTab === 'pending'" x-cloak class="bg-white p-6 rounded-3xl border border-gray-100 flex flex-col sm:flex-row items-center gap-6 cursor-pointer hover:bg-pink-50/20 transition hover:shadow-sm">

                    <div class="flex items-center justify-center flex-shrink-0 w-16 h-16 bg-pink-50 rounded-2xl border border-pink-100">

                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path d="M12 2l10 16H2L12 2z" stroke-width="1.5" />

                        </svg>

                    </div>

                    <div class="flex-1 space-y-1">

                        <h4 class="font-semibold text-gray-900">Sewa Tenda Camping Kapasitas 4 Orang (Tenda Dome)</h4>

                        <p class="text-xs text-gray-400">ID Pesanan: CL-RENT-34503</p>

                        <p class="text-[11px] text-pink-700 italic">Dipesan pada: 12 Jan 2026, 10:15</p>

                    </div>

                    <div class="text-center sm:text-right">

                        <p class="text-lg font-bold text-gray-900">Rp 120.000</p>

                        <span class="inline-block mt-2 px-3 py-1 rounded-full text-[10px] font-bold bg-pink-50 text-pink-700 border border-pink-100 shadow-inner">Menunggu Verifikasi</span>

                    </div>

                    <button class="flex items-center gap-1.5 px-4 py-2 border border-gray-100 text-gray-600 rounded-xl text-xs font-semibold hover:bg-gray-50 hover:text-green-800 transition shadow-sm">

                        Detail

                    </button>

                </div>



                <div x-show="activeTab === 'all' || activeTab === 'processing'" x-cloak class="bg-white p-6 rounded-3xl border border-gray-100 flex flex-col sm:flex-row items-center gap-6 cursor-pointer hover:bg-pink-50/20 transition hover:shadow-sm">

                    <div class="flex items-center justify-center flex-shrink-0 w-16 h-16 bg-pink-50 rounded-2xl border border-pink-100">

                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path d="M10 21h4a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="1.5" />

                        </svg>

                    </div>

                    <div class="flex-1 space-y-1">

                        <h4 class="font-semibold text-gray-900">Sewa Tas Carrier Eiger 60L + Cover Bag</h4>

                        <p class="text-xs text-gray-400">ID Pesanan: CL-RENT-34501</p>

                        <p class="text-[11px] text-pink-700 italic">Dipesan pada: 11 Jan 2026, 09:00</p>

                    </div>

                    <div class="text-center sm:text-right">

                        <p class="text-lg font-bold text-gray-900">Rp 80.000</p>

                        <span class="inline-block mt-2 px-3 py-1 rounded-full text-[10px] font-bold bg-pink-50 text-pink-700 border border-pink-100 shadow-inner">Sedang Diproses</span>

                    </div>

                    <button class="flex items-center gap-1.5 px-4 py-2 border border-gray-100 text-gray-600 rounded-xl text-xs font-semibold hover:bg-gray-50 hover:text-green-800 transition shadow-sm">

                        Detail

                    </button>

                </div>



            </div>



            <footer class="mt-16 text-center text-xs text-gray-300">

                &copy; 2026 Camplore - Penyewaan Alat Camping & Kamera Terpercaya. All Rights Reserved.

            </footer>

        </main>

    </div>



</body>



</html>