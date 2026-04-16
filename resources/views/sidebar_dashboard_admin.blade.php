{{-- ═══ SIDEBAR ═══ --}}
<aside id="top-bar-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">

    <div class="flex flex-col h-full pb-4 pt-5"
        style="background:#e5e6d8; font-family:'DM Sans',sans-serif;">

        {{-- Logo --}}
        <div class="flex items-center gap-2.5 px-[18px] pb-[18px]"
            style="border-bottom:0.5px solid #c8c9b4;">
            <div class="flex items-center justify-center flex-shrink-0 w-[34px] h-[34px] rounded-lg"
                style="background:#5a7a3a;">
                {{-- square-3-stack-3d --}}
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="#dff0c0" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                </svg>
            </div>
            <span class="text-[17px]" style="font-family:'DM Serif Display',serif; color:#2a3020;">CampLore</span>
        </div>

        {{-- Nav --}}
        <div class="flex flex-col flex-1 gap-0.5 px-2.5 py-3.5">

            {{-- Beranda — home --}}
            <a href="{{ url('/dashboard_admin') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('dashboard_admin') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('dashboard_admin') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('dashboard_admin') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('dashboard_admin') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Beranda
            </a>

            <p class="text-[9.5px] font-semibold tracking-[.12em] uppercase px-2 pt-2.5 pb-1"
                style="color:#7a8060;">Manajemen Pesanan</p>

            {{-- Pemesanan — clipboard-document-list --}}
            <a href="{{ url('/dashboard/admin/pemesanan') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('Pemesanan') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('Pemesanan') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('Pemesanan') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('Pemesanan') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                <span class="flex-1">Pemesanan</span>
                <span class="text-[10px] font-semibold px-[7px] py-[1px] rounded-full"
                    style="background:#c8d0a8;color:#3a4820;border:0.5px solid #a8b088;">Pro</span>
            </a>

            {{-- Transaksi Pembayaran — banknotes --}}
            <a href="{{ url('/dashboard/admin/pembayaran') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('Transaksi Pembayaran') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('Transaksi Pembayaran') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('Transaksi Pembayaran') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('Transaksi Pembayaran') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
                <span class="flex-1">Transaksi Pembayaran</span>
                <span class="text-[10px] font-semibold px-[7px] py-[1px] rounded-full"
                    style="background:#f0c8c0;color:#802018;border:0.5px solid #dca898;">2</span>
            </a>

            <div class="my-2 mx-2.5" style="height:0.5px;background:#c8c9b4;"></div>
            <p class="text-[9.5px] font-semibold tracking-[.12em] uppercase px-2 pt-2.5 pb-1"
                style="color:#7a8060;">Manajemen Operasional</p>

            {{-- Users — users --}}
            <a href="{{ url('/dashboard/admin/users') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('users') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('users') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('users') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('users') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                Users
            </a>

            {{-- Pengiriman — truck --}}
            <a href="{{ url('/pengiriman') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('pengiriman') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('pengiriman') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('pengiriman') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('pengiriman') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                </svg>
                <span class="flex-1">Pengiriman</span>
                <span class="text-[10px] font-semibold px-[7px] py-[1px] rounded-full"
                    style="background:#c8d0a8;color:#3a4820;border:0.5px solid #a8b088;">Pro</span>
            </a>

            {{-- Pengembalian — arrow-uturn-left --}}
            <a href="{{ url('/Pengembalian') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('Pengembalian') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('Pengembalian') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('Pengembalian') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('Pengembalian') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
                <span class="flex-1">Pengembalian</span>
                <span class="text-[10px] font-semibold px-[7px] py-[1px] rounded-full"
                    style="background:#f0c8c0;color:#802018;border:0.5px solid #dca898;">2</span>
            </a>

            <div class="my-2 mx-2.5" style="height:0.5px;background:#c8c9b4;"></div>
            <p class="text-[9.5px] font-semibold tracking-[.12em] uppercase px-2 pt-2.5 pb-1"
                style="color:#7a8060;">Manajemen Rental</p>

            {{-- Data Kamera — camera --}}
            <a href="{{ route('camera.index') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('camera*') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('camera*') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('camera*') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('camera*') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                </svg>
                Data Kamera
            </a>

            {{-- Data Camping — tent icon via map-pin variant, pakai fire sebagai alternatif alam --}}
            <a href="{{ route('camping.index') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('camping') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('camping') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('camping') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('camping') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.975 5.975 0 0 1-2.133-1.001A3.75 3.75 0 0 0 12 18Z" />
                </svg>
                Data Camping
            </a>

            {{-- Products — shopping-bag --}}
            <a href="{{ url('/products') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('products') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('products') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('products') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('products') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                Products
            </a>


            <div class="flex-1"></div>

            {{-- Settings — cog-6-tooth --}}
            <!-- <a href="{{ url('/settings') }}"
                class="flex items-center gap-2.5 px-2.5 py-[9px] rounded-[9px] no-underline text-[13px] transition-all duration-150
                      {{ request()->is('settings') ? 'bg-white font-semibold shadow-[0_1px_4px_rgba(0,0,0,0.08)]' : 'hover:bg-[#d4d6c4]' }}"
                style="{{ request()->is('settings') ? 'color:#2a3020;' : 'color:#4a5038;' }}">
                <svg class="w-[15px] h-[15px] flex-shrink-0 {{ request()->is('settings') ? 'opacity-100' : 'opacity-60' }}"
                    viewBox="0 0 24 24" fill="none"
                    stroke="{{ request()->is('settings') ? '#4a7a28' : 'currentColor' }}"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Settings
            </a> -->
        </div>

        {{-- User Card --}}
        <div class="mx-2.5" style="height:0.5px;background:#c8c9b4;"></div>
        <div class="flex items-center gap-[9px] p-2.5 mx-2.5 mt-2 rounded-[10px] cursor-pointer"
            style="background:#d4d6c4;border:0.5px solid #c8c9b4;">
            <img class="w-[30px] h-[30px] rounded-full object-cover flex-shrink-0"
                style="border:1.5px solid #a8b890;"
                src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User').'&background=5a7a3a&color=dff0c0' }}"
                alt="Profile">
            <div class="flex-1 min-w-0">
                <p class="text-[12px] font-semibold m-0 whitespace-nowrap overflow-hidden text-ellip sis"
                    style="color:#2a3020;">
                    {{ Auth::user()->name ?? 'Lulu Khaira' }}
                </p>
                <p class="text-[10px] m-0" style="color:#6a7858;">
                    {{ Auth::user()->email ?? 'Administrator' }}
                </p>
            </div>
            {{-- ellipsis-vertical --}}
            <svg class="w-[14px] h-[14px]" viewBox="0 0 24 24" fill="none" stroke="#8a9070" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
            </svg>
        </div>

    </div>
</aside>