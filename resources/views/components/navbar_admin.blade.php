@once
    @push('styles')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght=400;500;600;700;800&family=Playfair+Display:wght=700;800&display=swap" rel="stylesheet">
        <style>
            .topbar-nav, .topbar-nav * { font-family: 'Inter', sans-serif; }
            [x-cloak] { display: none !important; }
        </style>
    @endpush
@once

<nav class="topbar-nav flex items-center justify-between px-6 py-3 bg-white border border-[#d7e6de] rounded-2xl shadow-sm">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2">
        <span class="text-[#22543D] text-[10px] font-bold uppercase tracking-widest">
            {{ $NavParent ?? 'Management Rental' }}
        </span>
        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#22543D" stroke-width="3">
            <path d="M9 18l6-6-6-6" />
        </svg>
        <span class="text-[#ED64A6] text-[10px] font-bold uppercase tracking-widest">
            {{ $section ?? 'Kamera' }}
        </span>
    </div>

    <div class="flex items-center gap-4">

        {{-- Search --}}
        <div class="relative hidden md:block">
            <span class="absolute inset-y-0 left-3 flex items-center text-[#22543D]">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
            </span>
            <input type="text" placeholder="Cari unit..."
                class="pl-9 pr-4 py-1.5 bg-[#f1f8f4] rounded-lg text-xs w-40 focus:w-56 transition-all focus:ring-1 focus:ring-[#ED64A6] border-none outline-none">
        </div>

        {{-- Notifikasi Ulasan --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="text-[#22543D] p-1.5 hover:bg-[#f1f8f4] rounded-full transition-colors relative">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
                @if($unrepliedCount > 0)
                <span class="absolute top-1 right-1 w-4 h-4 bg-[#ED64A6] text-white text-[9px] font-bold rounded-full flex items-center justify-center">
                    {{ $unrepliedCount > 9 ? '9+' : $unrepliedCount }}
                </span>
                @else
                <div class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-[#D977A8] rounded-full border border-white"></div>
                @endif
            </button>

            {{-- Dropdown --}}
            <div x-show="open" @click.outside="open = false" x-cloak
                class="absolute right-0 top-11 w-80 bg-white rounded-2xl shadow-xl border border-[#eef4f0] z-50 overflow-hidden">

                {{-- Header dropdown --}}
                <div class="flex items-center justify-between px-4 py-3 border-b border-[#eef4f0]">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-bold text-[#22543D]">Ulasan Terbaru</span>
                        @if($unrepliedCount > 0)
                        <span class="px-2 py-0.5 bg-[#fce7f3] text-[#ED64A6] text-[10px] font-bold rounded-full">
                            {{ $unrepliedCount }} belum ditanggapi
                        </span>
                        @endif
                    </div>
                    <a href="{{ route('admin.reviews.index') }}"
                        class="text-[11px] font-semibold text-[#ED64A6] hover:underline">
                        Lihat Semua
                    </a>
                </div>

                @if($recentReviews->isEmpty())
                <div class="px-4 py-8 text-center">
                    <svg class="w-8 h-8 text-gray-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <p class="text-xs text-gray-400">Belum ada ulasan</p>
                </div>
                @else
                <div class="divide-y divide-[#eef4f0] max-h-64 overflow-y-auto">
                    @foreach($recentReviews as $review)
                    <a href="{{ route('admin.reviews.index') }}"
                        class="flex items-start gap-3 px-4 py-3 hover:bg-[#f9fdfb] transition no-underline">
                        
                        {{-- Avatar Profil yang Diperbaiki agar Sinkron --}}
                        <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 border border-gray-100 flex items-center justify-center">
                            @if($review->pelanggan && $review->pelanggan->foto_profile)
                                <img src="{{ asset('storage/' . $review->pelanggan->foto_profile) }}"
                                    alt="{{ $review->pelanggan->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                @php
                                    $avatarColors  = ['#22543D','#ED64A6','#6366f1','#f59e0b','#ef4444'];
                                    $aColor        = $avatarColors[$loop->index % 5];
                                @endphp
                                <div class="w-full h-full flex items-center justify-center text-white text-xs font-bold"
                                    style="background: {{ $aColor }}">
                                    {{ strtoupper(substr($review->pelanggan->name ?? 'U', 0, 2)) }}
                                </div>
                            @endif
                        </div>

                        {{-- Teks Informasi Ulasan (Kembali ke versi awalmu yang rapi) --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-800 truncate m-0">
                                {{ $review->pelanggan->name ?? 'Pengguna' }}
                            </p>
                            <p class="text-[11px] text-gray-400 truncate m-0">
                                {{ $review->product->name ?? 'Produk' }}
                            </p>
                            
                            {{-- Tampilan Rating Bintang di dalam Notifikasi --}}
                            <div class="flex items-center gap-0.5 my-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                <svg class="w-2.5 h-2.5" viewBox="0 0 24 24"
                                    fill="{{ $i <= $review->bintang ? '#EF9F27' : '#e5e7eb' }}"
                                    stroke="{{ $i <= $review->bintang ? '#EF9F27' : '#d1d5db' }}"
                                    stroke-width="1.5">
                                    <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                                </svg>
                                @endfor
                            </div>

                            <p class="text-[11px] text-gray-500 mt-0.5 truncate m-0">
                                "{{ $review->komentar }}"
                            </p>
                        </div>

                        <span class="text-[10px] text-gray-400 flex-shrink-0 mt-0.5">
                            {{ $review->created_at->diffForHumans() }}
                        </span>
                    </a>
                    @endforeach
                </div>

                <a href="{{ route('admin.reviews.index') }}"
                    class="flex items-center justify-center gap-2 px-4 py-3 bg-[#22543D] hover:bg-[#1a3d2e] text-white text-xs font-bold transition no-underline">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    Balas Semua Ulasan
                </a>
                @endif
            </div>
        </div>

    </div>
</nav>