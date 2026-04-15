@extends('layouts.app')

@section('title', 'Dashboard - Camplore')

@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --green: #22543D;
            --pink: #ED64A6;
            --light-pink: #FFF5F7;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }

        .sidebar-card {
            background: linear-gradient(145deg, #22543D 0%, #1a3d2e 100%);
        }
        .avatar-ring {
            background: linear-gradient(135deg, #ED64A6, #22543D);
            padding: 3px;
            border-radius: 9999px;
        }
        .stat-pill {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-pill:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(237,100,166,0.2);
        }
        .menu-item {
            transition: all 0.2s ease;
        }
        .menu-item:hover {
            background: rgba(237,100,166,0.08);
            transform: translateX(4px);
        }
        .menu-item.active {
            background: rgba(237,100,166,0.12);
            border-left: 3px solid #ED64A6;
        }
        .order-tab {
            transition: all 0.2s;
            position: relative;
        }
        .order-tab.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0; right: 0;
            height: 2px;
            background: #ED64A6;
            border-radius: 2px;
        }
        .gear-card {
            transition: transform 0.3s cubic-bezier(.34,1.56,.64,1), box-shadow 0.3s;
        }
        .gear-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(34,84,61,0.12);
        }
        .badge-active {
            animation: pulse-badge 2s infinite;
        }
        @keyframes pulse-badge {
            0%,100% { box-shadow: 0 0 0 0 rgba(237,100,166,0.3); }
            50% { box-shadow: 0 0 0 6px rgba(237,100,166,0); }
        }
        .progress-bar {
            background: linear-gradient(90deg, #22543D, #ED64A6);
            border-radius: 9999px;
            transition: width 1s ease;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .slide-in { animation: slideIn 0.5s ease forwards; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #22543D; border-radius: 9999px; }
    </style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        

        {{-- Top greeting banner --}}
        <div class="mb-8 bg-[#22543D] rounded-3xl px-8 py-6 flex items-center justify-between overflow-hidden relative" data-aos="fade-down">
            <div class="absolute -right-10 -top-10 w-48 h-48 bg-[#ED64A6]/10 rounded-full blur-2xl"></div>
            <div class="absolute right-20 -bottom-8 w-32 h-32 bg-white/5 rounded-full blur-xl"></div>
            <div class="relative z-10">
                <p class="text-emerald-300 text-sm font-semibold tracking-widest uppercase mb-1">Selamat Datang Kembali 👋</p>
                <h1 class="text-white text-2xl md:text-3xl font-extrabold tracking-tight">
                    Halo, <span class="text-[#ED64A6]">{{ auth()->user()->name ?? 'Adventurer' }}</span>!
                </h1>
                <p class="text-emerald-200 text-sm mt-1">Siap untuk petualangan berikutnya?</p>
            </div>
            <div class="relative z-10 hidden md:flex items-center gap-3">
                <div class="text-right">
                    <p class="text-emerald-300 text-xs">Member Since</p>
                    <p class="text-white font-bold">{{ auth()->user()->created_at->format('M Y') ?? 'Jan 2025' }}</p>
                </div>
                <div class="w-14 h-14 bg-[#ED64A6]/20 rounded-2xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#ED64A6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 0M5 3a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2M5 3l0 4h14V3" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            {{-- ===== SIDEBAR KIRI ===== --}}
            <div class="lg:col-span-1 space-y-5">

                {{-- Profile Card --}}
                <div class="sidebar-card rounded-3xl p-6 text-white relative overflow-hidden" data-aos="fade-right">
                    <div class="absolute -top-8 -right-8 w-32 h-32 bg-[#ED64A6]/10 rounded-full"></div>
                    <div class="absolute -bottom-6 -left-6 w-24 h-24 bg-white/5 rounded-full"></div>

                    {{-- Sign out --}}
                    <div class="flex justify-end mb-4 relative z-10">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="text-emerald-300 hover:text-[#ED64A6] text-xs font-semibold transition flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Sign Out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                    </div>

                    {{-- Avatar --}}
                    <div class="flex flex-col items-center relative z-10">
                        <div class="avatar-ring mb-3">
                            <div class="w-20 h-20 rounded-full bg-[#22543D] flex items-center justify-center text-3xl font-extrabold text-white overflow-hidden">
                                @if(auth()->user()->avatar ?? false)
                                    <img src="{{ asset('storage/'.auth()->user()->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                                @endif
                            </div>
                        </div>
                        <h3 class="font-extrabold text-lg text-white text-center">{{ auth()->user()->name ?? 'Adventurer' }}</h3>
                        <p class="text-emerald-300 text-xs mt-0.5">{{ auth()->user()->email ?? 'user@camplore.id' }}</p>

                        {{-- Member badge --}}
                        <div class="mt-3 bg-[#ED64A6]/20 border border-[#ED64A6]/40 px-4 py-1 rounded-full badge-active">
                            <span class="text-[#ED64A6] text-xs font-bold tracking-wider">⛺ Explorer Member</span>
                        </div>
                    </div>

                    {{-- Edit profile --}}
                    <div class="mt-5 relative z-10 flex gap-2">
                        <a href="#" class="flex-1 text-center border border-white/20 text-white text-xs font-semibold py-2.5 rounded-xl hover:bg-white/10 transition">Edit Profil</a>
                        <a href="#" class="flex-1 text-center bg-[#ED64A6] text-white text-xs font-semibold py-2.5 rounded-xl hover:bg-[#d5568f] transition">Pengaturan</a>
                    </div>
                </div>

                {{-- Stats Pills --}}
                <div class="grid grid-cols-2 gap-3" data-aos="fade-right" data-aos-delay="100">
                    @php
                        $stats = [
                            ['label' => 'Poin Saya', 'value' => '240', 'icon' => '⭐'],
                            ['label' => 'Voucher', 'value' => '3', 'icon' => '🎟️'],
                            ['label' => 'Wishlist', 'value' => '7', 'icon' => '❤️'],
                            ['label' => 'Review', 'value' => '5', 'icon' => '✍️'],
                        ];
                    @endphp
                    @foreach($stats as $stat)
                        <div class="stat-pill bg-white rounded-2xl p-4 border border-pink-100 shadow-sm text-center cursor-pointer">
                            <p class="text-xl mb-1">{{ $stat['icon'] }}</p>
                            <p class="text-[#22543D] font-extrabold text-lg">{{ $stat['value'] }}</p>
                            <p class="text-gray-500 text-xs">{{ $stat['label'] }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- Member Progress --}}
                <div class="bg-white rounded-3xl p-5 border border-pink-100 shadow-sm" data-aos="fade-right" data-aos-delay="150">
                    <div class="flex justify-between items-center mb-3">
                        <p class="text-sm font-bold text-[#22543D]">Level Member</p>
                        <span class="text-xs text-[#ED64A6] font-semibold">Explorer → Pioneer</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2 mb-2">
                        <div class="progress-bar h-2" style="width: 60%"></div>
                    </div>
                    <p class="text-xs text-gray-500">240 / 400 poin untuk naik level</p>
                </div>

                {{-- Navigation Menu --}}
                <div class="bg-white rounded-3xl p-4 border border-pink-100 shadow-sm" data-aos="fade-right" data-aos-delay="200">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 px-3">Menu</p>
                    @php
                        $menus = [
                            ['icon' => '📦', 'label' => 'Pesanan Saya', 'active' => true],
                            ['icon' => '🎒', 'label' => 'Riwayat Sewa', 'active' => false],
                            ['icon' => '📍', 'label' => 'Alamat Pengiriman', 'active' => false],
                            ['icon' => '🎁', 'label' => 'Reward Saya', 'active' => false],
                            ['icon' => '🔔', 'label' => 'Notifikasi', 'active' => false],
                            ['icon' => '🛡️', 'label' => 'Keamanan Akun', 'active' => false],
                        ];
                    @endphp
                    <div class="space-y-1">
                        @foreach($menus as $menu)
                            <a href="#" class="menu-item {{ $menu['active'] ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-xl">
                                <span class="text-base">{{ $menu['icon'] }}</span>
                                <span class="text-sm font-semibold {{ $menu['active'] ? 'text-[#22543D]' : 'text-gray-600' }}">{{ $menu['label'] }}</span>
                                @if($menu['active'])
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#ED64A6] ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ===== KONTEN KANAN ===== --}}
            <div class="lg:col-span-3 space-y-6">

                {{-- Order Status Tabs --}}
                <div class="bg-white rounded-3xl border border-pink-100 shadow-sm overflow-hidden" data-aos="fade-left">
                    {{-- Tab Header --}}
                    <div class="border-b border-gray-100 px-6 pt-5">
                        <h2 class="font-extrabold text-[#22543D] text-lg mb-4">Pesanan Saya</h2>
                        <div class="flex gap-6 overflow-x-auto pb-2">
                            @php
                                $tabs = ['Semua', 'Menunggu Bayar', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];
                            @endphp
                            @foreach($tabs as $i => $tab)
                                <button class="order-tab {{ $i === 0 ? 'active text-[#ED64A6]' : 'text-gray-400' }} text-sm font-bold whitespace-nowrap pb-3 hover:text-[#ED64A6] transition">
                                    {{ $tab }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Empty State / Order List --}}
                    <div class="p-8">
                        {{-- Jika belum ada pesanan: --}}
                        <div class="text-center py-12">
                            <div class="w-24 h-24 mx-auto mb-5 bg-[#FFF5F7] rounded-3xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#ED64A6]/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <h3 class="font-bold text-gray-700 text-lg mb-2">Belum Ada Pesanan</h3>
                            <p class="text-gray-400 text-sm mb-6 max-w-xs mx-auto">Kamu belum punya pesanan aktif. Yuk, mulai sewa gear petualanganmu!</p>
                            <a href="{{ route('catalog') ?? '#' }}" class="inline-flex items-center gap-2 bg-[#22543D] text-white px-8 py-3 rounded-full font-bold hover:bg-[#ED64A6] transition shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/></svg>
                                Browse Gear
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Quick Stats Row --}}
                <div class="grid grid-cols-3 gap-4" data-aos="fade-up" data-aos-delay="100">
                    @php
                        $quickStats = [
                            ['label' => 'Total Sewa', 'value' => '0', 'sub' => 'transaksi', 'color' => 'text-[#22543D]', 'bg' => 'bg-emerald-50', 'icon' => '📷'],
                            ['label' => 'Sedang Disewa', 'value' => '0', 'sub' => 'item aktif', 'color' => 'text-[#ED64A6]', 'bg' => 'bg-[#FFF5F7]', 'icon' => '⛺'],
                            ['label' => 'Total Penghematan', 'value' => 'Rp 0', 'sub' => 'vs beli baru', 'color' => 'text-[#22543D]', 'bg' => 'bg-emerald-50', 'icon' => '💰'],
                        ];
                    @endphp
                    @foreach($quickStats as $qs)
                        <div class="bg-white rounded-2xl p-5 border border-pink-100 shadow-sm text-center">
                            <p class="text-2xl mb-2">{{ $qs['icon'] }}</p>
                            <p class="font-extrabold text-xl {{ $qs['color'] }}">{{ $qs['value'] }}</p>
                            <p class="font-semibold text-gray-700 text-sm">{{ $qs['label'] }}</p>
                            <p class="text-gray-400 text-xs">{{ $qs['sub'] }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- Recommended Gear --}}
                <div class="bg-white rounded-3xl border border-pink-100 shadow-sm p-6" data-aos="fade-up" data-aos-delay="150">
                    <div class="flex justify-between items-center mb-5">
                        <div>
                            <h2 class="font-extrabold text-[#22543D] text-lg">Rekomendasi Gear</h2>
                            <p class="text-gray-400 text-xs mt-0.5">Populer minggu ini untuk petualanganmu</p>
                        </div>
                        <a href="#" class="text-[#ED64A6] text-sm font-bold hover:underline flex items-center gap-1">
                            Lihat Semua
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @php
                            $gears = [
                                ['name' => 'Canon EOS R6', 'cat' => 'Camera', 'price' => 'Rp 250k/hari', 'img' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&q=80&w=400', 'badge' => 'Terlaris'],
                                ['name' => 'Ultralight Tent 2P', 'cat' => 'Camping', 'price' => 'Rp 100k/hari', 'img' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&q=80&w=400', 'badge' => 'Baru'],
                                ['name' => 'Sony A7 III', 'cat' => 'Camera', 'price' => 'Rp 300k/hari', 'img' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?auto=format&fit=crop&q=80&w=400', 'badge' => 'Premium'],
                            ];
                        @endphp
                        @foreach($gears as $gear)
                            <div class="gear-card bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 cursor-pointer">
                                <div class="relative aspect-[4/3] overflow-hidden">
                                    <img src="{{ $gear['img'] }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500" alt="{{ $gear['name'] }}">
                                    <span class="absolute top-2 left-2 bg-[#22543D] text-white text-xs font-bold px-2.5 py-1 rounded-full">{{ $gear['cat'] }}</span>
                                    <span class="absolute top-2 right-2 bg-[#ED64A6] text-white text-xs font-bold px-2.5 py-1 rounded-full">{{ $gear['badge'] }}</span>
                                </div>
                                <div class="p-3">
                                    <h4 class="font-bold text-gray-800 text-sm">{{ $gear['name'] }}</h4>
                                    <p class="text-[#ED64A6] font-extrabold text-sm mt-0.5">{{ $gear['price'] }}</p>
                                    <button class="mt-2 w-full py-2 bg-[#22543D] text-white text-xs font-bold rounded-xl hover:bg-[#ED64A6] transition">
                                        Sewa Sekarang
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Delivery & Pickup --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-[#22543D] rounded-3xl p-6 relative overflow-hidden cursor-pointer hover:shadow-xl transition">
                        <div class="absolute -top-6 -right-6 w-28 h-28 bg-white/5 rounded-full"></div>
                        <div class="text-3xl mb-3">🚚</div>
                        <h3 class="text-white font-extrabold text-base mb-1">Pengiriman ke Lokasi</h3>
                        <p class="text-emerald-200 text-xs leading-relaxed">Gear dikirim langsung ke basecamp atau alamatmu.</p>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="text-[#ED64A6] font-bold text-sm">Atur Alamat</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#ED64A6]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                    <div class="bg-[#FFF5F7] rounded-3xl p-6 border border-pink-200 relative overflow-hidden cursor-pointer hover:shadow-xl transition">
                        <div class="absolute -top-6 -right-6 w-28 h-28 bg-[#ED64A6]/10 rounded-full"></div>
                        <div class="text-3xl mb-3">🏪</div>
                        <h3 class="text-[#22543D] font-extrabold text-base mb-1">Ambil di Store</h3>
                        <p class="text-gray-500 text-xs leading-relaxed">Ambil sendiri gear pilihanmu di store Camplore terdekat.</p>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="text-[#ED64A6] font-bold text-sm">Cari Store</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#ED64A6]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Address Book & Rewards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" data-aos="fade-up" data-aos-delay="250">
                    @php
                        $bottomMenus = [
                            ['icon' => '📍', 'title' => 'Buku Alamat', 'desc' => 'Kelola alamat pengiriman gear', 'color' => 'border-emerald-100'],
                            ['icon' => '🎁', 'title' => 'Reward Saya', 'desc' => 'Tukarkan poin dengan diskon sewa', 'color' => 'border-pink-100'],
                            ['icon' => '📅', 'title' => 'Riwayat Peminjaman', 'desc' => 'Cek history sewa gear kamu', 'color' => 'border-emerald-100'],
                            ['icon' => '💬', 'title' => 'Ulasan Saya', 'desc' => 'Review gear yang pernah kamu sewa', 'color' => 'border-pink-100'],
                        ];
                    @endphp
                    @foreach($bottomMenus as $bm)
                        <a href="#" class="bg-white rounded-2xl p-5 border {{ $bm['color'] }} shadow-sm hover:shadow-md transition flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition">
                                {{ $bm['icon'] }}
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 text-sm">{{ $bm['title'] }}</h4>
                                <p class="text-gray-400 text-xs mt-0.5">{{ $bm['desc'] }}</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300 group-hover:text-[#ED64A6] transition" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 700, easing: 'ease-in-out', once: true });

        // Tab switching
        document.querySelectorAll('.order-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.order-tab').forEach(t => {
                    t.classList.remove('active', 'text-[#ED64A6]');
                    t.classList.add('text-gray-400');
                });
                this.classList.add('active', 'text-[#ED64A6]');
                this.classList.remove('text-gray-400');
            });
        });

        // Progress bar animate on load
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.querySelector('.progress-bar').style.width = '60%';
            }, 500);
        });
    </script>
@endpush