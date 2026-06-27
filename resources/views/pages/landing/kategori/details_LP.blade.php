@extends('layouts.landingpage')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">

@php
if (!isset($accordions)) {
    $accordions = [
        ['title' => 'Tentang Produk ini', 'deskripsi' => $item->deskripsi ?? $item->description ?? 'Deskripsi tidak tersedia.', 'open' => true],
        ['title' => 'Sorotan', 'deskripsi' => 'Spesifikasi unggulan untuk ' . $item->name . '.', 'open' => false],
        ['title' => 'Isi Paket', 'deskripsi' => $item->stok > 0 ? 'Tersedia — '.$item->stok.' unit siap disewa.' : 'Maaf, stok sedang kosong.', 'open' => false],
    ];
}
@endphp

{{-- Paksa scroll ke atas saat halaman dimuat --}}
<script>
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    window.scrollTo(0, 0);
</script>

<div style="font-family:'DM Sans',sans-serif;">

    {{-- ── BREADCRUMB ─────────────────────────────────────────── --}}
    <nav class="flex items-center gap-2 px-4 py-4 text-xs text-gray-400 max-w-6xl mx-auto">
        <a href="/" class="hover:text-gray-900 transition-colors">BERANDA</a>
        <span>/</span>
        <a href="{{ route($kategori . '.LP') }}" class="hover:text-gray-900 transition-colors">{{ $categoryLabel }}</a>
        <span>/</span>
        <span class="text-orange-600 font-medium truncate">{{ $item->name }}</span>
    </nav>

    {{-- ══════════════════════════════════════════════════════════
         MOBILE LAYOUT (< lg)
    ══════════════════════════════════════════════════════════ --}}
    <div class="lg:hidden">

        {{-- Main Image --}}
        <div class="relative bg-gray-100 w-full" style="aspect-ratio:1/1;">
            @if($item->stok == 0)
            <div class="absolute top-3 left-3 z-10 bg-red-500 text-white text-xs font-black px-3 py-1 rounded-lg tracking-widest uppercase">
                HABIS
            </div>
            @endif
            <img id="mainImgMobile"
                src="{{ str_starts_with($item->gambar_barang, 'http') ? $item->gambar_barang : asset($item->gambar_barang) }}"
                alt="{{ $item->name }}"
                class="w-full h-full object-cover {{ $item->stok == 0 ? 'opacity-60' : '' }}">
        </div>

        {{-- Thumbnail horizontal scroll --}}
        <div class="flex gap-2 px-4 py-3 overflow-x-auto no-scrollbar"></div>

        {{-- Info --}}
        <div class="px-4 pb-32">
            <div class="flex items-center justify-between mb-2">
                <div>
                    @if($item->is_new ?? false)
                    <span class="bg-gray-900 text-white text-xs font-bold tracking-widest uppercase px-3 py-1 rounded">Baru</span>
                    @endif
                </div>
            </div>

            <h1 class="text-xl font-bold text-gray-900 leading-snug mb-2">{{ $item->name }}</h1>

            @if($item->stok == 0)
            <div class="inline-flex items-center gap-1.5 bg-red-50 border border-red-200 text-red-600 text-xs font-bold px-3 py-1.5 rounded-lg mb-3">
                <span>🚫</span> Stok Habis
            </div>
            @else
            <div class="inline-flex items-center gap-1.5 bg-green-50 border border-green-200 text-green-700 text-xs font-bold px-3 py-1.5 rounded-lg mb-3">
                <span>✓</span> Tersedia {{ $item->stok }} unit
            </div>
            @endif

            <p class="text-2xl font-bold text-orange-600 mb-1">Rp {{ number_format($item->harga_per_hari, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mb-5" id="totalPriceNoteMobile"></p>

            @if($item->stok > 0)
            {{-- Tanggal --}}
            <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-2">Tanggal Penyewaan</p>
            <div class="flex gap-3 mb-3">
                <div class="flex-1">
                    <label class="block text-xs text-gray-400 mb-1">Mulai</label>
                    <input type="date" id="startDateM" onchange="onStartChangeM()"
                        class="w-full border-2 border-gray-100 rounded-xl px-3 py-3 text-sm focus:border-gray-400 focus:outline-none transition-colors">
                </div>
                <div class="flex-1">
                    <label class="block text-xs text-gray-400 mb-1">Selesai</label>
                    <input type="date" id="endDateM" onchange="onDateChangeM()"
                        class="w-full border-2 border-gray-100 rounded-xl px-3 py-3 text-sm focus:border-gray-400 focus:outline-none transition-colors">
                </div>
            </div>
            <div id="durationBadgeM" class="hidden mb-4">
                <span id="durationTextM" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium"
                    style="background:#FFF0F6;color:#C2185B;border:1px solid #F8BBD9;"></span>
            </div>
            <p id="dateErrorM" class="hidden text-xs text-red-500 mb-4">Tanggal selesai harus setelah tanggal mulai.</p>

            {{-- Jumlah --}}
            <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-2">Jumlah</p>
            <div class="flex items-center w-fit border-2 border-gray-100 rounded-xl overflow-hidden mb-6">
                <button onclick="changeQty(-1)" class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 select-none">−</button>
                <div id="qtyDisplay" class="w-12 h-12 flex items-center justify-center border-x-2 border-gray-100 text-sm font-bold text-gray-900">1</div>
                <button onclick="changeQty(1)" class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 select-none">+</button>
            </div>
            @endif

            {{-- Accordion --}}
            <div class="border-t border-gray-100">
                @foreach($accordions as $ac)
                <div class="border-b border-gray-100">
                    <button onclick="toggleAcc(this)" class="w-full flex items-center justify-between py-4 text-sm font-semibold text-gray-900 text-left">
                        {{ $ac['title'] }}
                        <span class="acc-icon transition-transform duration-300 {{ $ac['open'] ? 'rotate-180' : '' }}">▾</span>
                    </button>
                    <div class="acc-deskripsi overflow-hidden transition-all duration-300" style="{{ $ac['open'] ? 'max-height:200px;' : 'max-height:0;' }}">
                        <div class="pb-4 text-sm text-gray-500 leading-relaxed">{{ $ac['deskripsi'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- CTA Fixed Bottom --}}
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 px-4 py-3 flex gap-3 z-50 lg:hidden">
            @if($item->stok > 0)
            <button onclick="addToCart({{ $item->id_barang }})"
                class="flex-1 py-3.5 rounded-xl bg-gray-900 text-white text-xs font-black tracking-widest uppercase hover:bg-gray-700 active:scale-95 transition-all">
                + Keranjang
            </button>
            <button onclick="rentNow({{ $item->id_barang }})"
                class="flex-1 py-3.5 rounded-xl bg-[#ED64A6] text-white text-xs font-black tracking-widest uppercase hover:bg-[#d45592] active:scale-95 transition-all">
                Sewa Sekarang
            </button>
            @else
            <div class="flex-1 py-3.5 rounded-xl bg-red-100 border-2 border-red-300 text-red-600 text-xs font-black tracking-widest uppercase text-center flex items-center justify-center gap-2">
                🚫 Stok Habis
            </div>
            @endif
        </div>

    </div>{{-- END MOBILE --}}

    {{-- ══════════════════════════════════════════════════════════
         DESKTOP LAYOUT (>= lg)
    ══════════════════════════════════════════════════════════ --}}
    <div class="hidden lg:block max-w-6xl mx-auto px-10 pb-20">
        <div class="flex gap-5 items-start">
            <div class="flex flex-col items-center gap-2 shrink-0" style="width:72px;"></div>

            {{-- Main Image --}}
            <div class="flex-1 rounded-2xl overflow-hidden bg-gray-100 group relative" style="aspect-ratio:1/1;min-width:0;">
                @if($item->stok == 0)
                <div class="absolute top-4 left-4 z-10 bg-red-500 text-white text-xs font-black px-3 py-1.5 rounded-lg tracking-widest uppercase shadow">
                    HABIS
                </div>
                @endif
                <img id="mainImg"
                    src="{{ str_starts_with($item->gambar_barang, 'http') ? $item->gambar_barang : asset($item->gambar_barang) }}"
                    alt="{{ $item->name }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 {{ $item->stok == 0 ? 'opacity-60' : '' }}">
            </div>

            {{-- Info column --}}
            <div class="shrink-0 flex flex-col" style="width:360px;">
                @if($item->is_new ?? false)
                <span class="mb-3 self-start bg-gray-900 text-white text-xs font-bold tracking-widest uppercase px-3 py-1 rounded">Baru</span>
                @endif

                <h1 class="text-xl font-bold text-gray-900 leading-snug mb-1">{{ $item->name }}</h1>
                <div class="flex items-baseline gap-1 mb-1">
                    <p class="text-2xl font-bold text-orange-600" id="displayPrice">Rp {{ number_format($item->harga_per_hari, 0, ',', '.') }}</p>
                    <span class="text-sm text-gray-400">/ hari</span>
                </div>

                {{-- Stok Badge --}}
                @if($item->stok == 0)
                <div class="inline-flex items-center gap-1.5 bg-red-50 border border-red-200 text-red-600 text-xs font-bold px-3 py-1.5 rounded-lg mb-4 w-fit">
                    🚫 Stok Habis — Tidak tersedia untuk disewa
                </div>
                @else
                <div class="items-center gap-1.5 border-gray-300 text-xs font-bold py-1.5 mb-4 w-fit">
                Tersedia {{ $item->stok }} unit
                </div>
                @endif

                <p class="text-xs text-gray-400 mb-5" id="totalPriceNote"></p>

                @if($item->stok > 0)
                {{-- Tanggal --}}
                <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-3">Tanggal Penyewaan</p>
                <div class="flex gap-3 mb-3">
                    <div class="flex-1">
                        <label class="block text-xs text-gray-400 mb-1">Mulai</label>
                        <input type="date" id="startDate" onchange="onStartChange()"
                            class="w-full border-2 border-gray-100 rounded-xl px-3 py-3 text-sm focus:border-gray-400 focus:outline-none transition-colors">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs text-gray-400 mb-1">Selesai</label>
                        <input type="date" id="endDate" onchange="onDateChange()"
                            class="w-full border-2 border-gray-100 rounded-xl px-3 py-3 text-sm focus:border-gray-400 focus:outline-none transition-colors">
                    </div>
                </div>
                <div id="durationBadge" class="hidden mb-5">
                    <span id="durationText" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium"
                        style="background:#FFF0F6;color:#C2185B;border:1px solid #F8BBD9;"></span>
                </div>
                <p id="dateError" class="hidden text-xs text-red-500 mb-4">Tanggal selesai harus setelah tanggal mulai.</p>

                {{-- Jumlah --}}
                <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-3">Jumlah</p>
                <div class="flex items-center w-fit border-2 border-gray-100 rounded-xl overflow-hidden mb-8">
                    <button onclick="changeQty(-1)" class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 active:bg-gray-100 transition-colors select-none">−</button>
                    <div id="qtyDisplay2" class="w-12 h-12 flex items-center justify-center border-x-2 border-gray-100 text-sm font-bold text-gray-900">1</div>
                    <button onclick="changeQty(1)" class="w-12 h-12 flex items-center justify-center bg-white text-xl text-gray-500 hover:bg-gray-50 active:bg-gray-100 transition-colors select-none">+</button>
                </div>

                {{-- CTA Buttons --}}
                <div class="flex gap-3 mb-6">
                    <button onclick="addToCart({{ $item->id_barang }})" id="addToCartBtnD"
                        class="flex-1 py-4 rounded-xl bg-gray-900 text-white text-xs font-black tracking-widest uppercase hover:bg-gray-700 active:scale-95 transition-all duration-200">
                        Tambahkan ke Keranjang
                    </button>
                    <button onclick="rentNow({{ $item->id_barang }})"
                        class="flex-1 py-4 rounded-xl bg-[#ED64A6] text-white text-xs font-black tracking-widest uppercase hover:bg-[#d45592] active:scale-95 transition-all duration-200">
                        Sewa Sekarang
                    </button>
                </div>
                @else
                {{-- Stok Habis — CTA disabled --}}
                <div class="mb-8">
                    <div class="w-full py-4 rounded-xl bg-red-50 border-2 border-red-200 text-red-500 text-xs font-black tracking-widest uppercase text-center cursor-not-allowed">
                        🚫 Produk Tidak Tersedia
                    </div>
                    <p class="text-xs text-gray-400 mt-2 text-center">Stok habis. Silakan cek produk lain atau kembali lagi nanti.</p>
                </div>
                @endif

                {{-- Accordion --}}
                <div>
                    @foreach($accordions as $ac)
                    <div class="border-b border-gray-100">
                        <button onclick="toggleAcc(this)" class="w-full flex items-center justify-between py-4 text-sm font-semibold text-gray-900 text-left">
                            {{ $ac['title'] }}
                            <span class="acc-icon transition-transform duration-300 {{ $ac['open'] ? 'rotate-180' : '' }}">▾</span>
                        </button>
                        <div class="acc-deskripsi overflow-hidden transition-all duration-300" style="{{ $ac['open'] ? 'max-height:200px;' : 'max-height:0;' }}">
                            <div class="pb-4 text-sm text-gray-500 leading-relaxed">{{ $ac['deskripsi'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>{{-- END Info column --}}
        </div>
    </div>{{-- END DESKTOP --}}

</div>{{-- END main wrapper --}}

{{-- Toast --}}
<div id="toast"
    class="fixed bottom-6 left-1/2 -translate-x-1/2 px-5 py-3 rounded-xl text-sm font-medium text-white shadow-lg transition-all duration-300 opacity-0 pointer-events-none z-50"
    style="background:#1a1a1a;min-width:220px;text-align:center;"></div>

{{-- ══════════════════════════════════════════════════════════
     SECTION ULASAN PELANGGAN
══════════════════════════════════════════════════════════ --}}
<div class="max-w-6xl mx-auto px-4 lg:px-10 py-14" style="font-family:'DM Sans',sans-serif;">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8">
        <div>
            <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-1">Yang Mereka Bilang</p>
            <h2 class="text-2xl font-bold text-gray-900">Ulasan Pelanggan</h2>
        </div>
        @if(isset($reviews) && $reviews->count() > 0)
        <div class="flex items-center gap-3">
            <span class="text-5xl font-black text-gray-900">{{ $avgRating ?? '0' }}</span>
            <div>
                <div class="flex items-center gap-0.5 mb-1">
                    @for($i = 1; $i <= 5; $i++)
                    <svg width="18" height="18" viewBox="0 0 24 24"
                        fill="{{ $i <= round($avgRating ?? 0) ? '#f59e0b' : '#e5e7eb' }}"
                        stroke="{{ $i <= round($avgRating ?? 0) ? '#f59e0b' : '#d1d5db' }}"
                        stroke-width="1.5">
                        <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                    </svg>
                    @endfor
                </div>
                <p class="text-xs text-gray-400">{{ $reviews->count() }} ulasan</p>
            </div>
        </div>
        @endif
    </div>

    {{-- Form Tulis Ulasan --}}
    @if(isset($canReview) && $canReview && isset($reviewOrder) && $reviewOrder !== null)
    @php
        $orderParamId = $reviewOrder->id_pesanan ?? null;
    @endphp
    @if($orderParamId)
    <div class="bg-[#f9fdfb] border border-[#d7e6de] rounded-2xl p-6 mb-8">
        <h3 class="text-base font-bold text-gray-900 mb-1">Tulis Ulasanmu</h3>
        <p class="text-xs text-gray-400 mb-5">Bagikan pengalamanmu menyewa produk ini.</p>

        @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('pelanggan.ulasan.store', ['orderId' => $orderParamId]) }}" method="POST">
            @csrf
            <input type="hidden" name="bintang" id="rating-input-detail" value="{{ old('bintang', 0) }}">

            {{-- Bintang --}}
            <div class="mb-4">
                <p class="text-xs font-bold text-gray-700 mb-2">Rating <span class="text-pink-500">*</span></p>
                <div class="flex items-center gap-2" id="star-detail">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button" data-value="{{ $i }}"
                        class="star-btn-detail focus:outline-none transition-transform hover:scale-110">
                        <svg width="32" height="32" viewBox="0 0 24 24"
                            fill="#e5e7eb" stroke="#d1d5db" stroke-width="1.5" class="star-icon-detail">
                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                        </svg>
                    </button>
                    @endfor
                    <span id="rating-label-detail" class="text-sm font-bold text-amber-500 ml-1"></span>
                </div>
            </div>

            {{-- Komentar --}}
            <div class="mb-4">
                <p class="text-xs font-bold text-gray-700 mb-2">Komentar <span class="text-pink-500">*</span></p>
                <textarea name="komentar" rows="4" maxlength="1000"
                    placeholder="Ceritakan pengalamanmu menyewa produk ini..."
                    class="w-full text-sm bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#22543D] resize-none placeholder-gray-300">{{ old('komentar') }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-2.5 bg-gray-900 hover:bg-gray-700 text-white text-sm font-bold rounded-xl transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Ulasan
                </button>
            </div>
        </form>
    </div>
    @endif
    @endif

    {{-- Daftar Ulasan --}}
    @if(isset($reviews) && $reviews->count() > 0)
    <div class="space-y-4" id="review-list">
        @foreach($reviews as $review)
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    @php
                        $fotoPelanggan = $review->pelanggan->foto_profile ?? null;
                    @endphp
                    <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0 border border-gray-100">
                        @if($fotoPelanggan)
                        <img src="{{ str_starts_with($fotoPelanggan, 'http') ? $fotoPelanggan : asset('storage/'.$fotoPelanggan) }}"
                            alt="{{ $review->pelanggan->nama_lengkap ?? 'User' }}"
                            class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-white text-sm font-bold"
                            style="background: linear-gradient(135deg,#22543D,#38a169)">
                            {{ strtoupper(substr($review->pelanggan->nama_lengkap ?? 'U', 0, 2)) }}
                        </div>
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-900">{{ $review->pelanggan->nama_lengkap ?? $review->pelanggan->name ?? 'Pengguna' }}</span>
                            <span class="text-[10px] font-bold text-[#22543D] bg-[#d1fae5] px-2 py-0.5 rounded-full">✓ Terverifikasi</span>
                        </div>
                        <div class="flex items-center gap-0.5 mt-0.5">
                            @for($i = 1; $i <= 5; $i++)
                            <svg width="13" height="13" viewBox="0 0 24 24"
                                fill="{{ $i <= $review->bintang ? '#f59e0b' : '#e5e7eb' }}"
                                stroke="{{ $i <= $review->bintang ? '#f59e0b' : '#d1d5db' }}"
                                stroke-width="1.5">
                                <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                            </svg>
                            @endfor
                        </div>
                    </div>
                </div>
                <span class="text-xs text-gray-400 shrink-0">{{ $review->created_at ? $review->created_at->diffForHumans() : '-' }}</span>
            </div>
            <p class="text-sm text-gray-600 mt-3 leading-relaxed">{{ $review->komentar }}</p>

            {{-- Balasan Admin --}}
            @if(isset($review->is_replied) && $review->is_replied && $review->balas_pesan)
            <div class="mt-3 bg-[#f9fdfb] border-l-4 border-[#22543D] rounded-r-xl px-4 py-3">
                <p class="text-[10px] font-bold text-[#22543D] uppercase tracking-wide mb-1">Balasan Camplore</p>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $review->balas_pesan }}</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <p class="text-sm text-gray-400 italic text-center py-6">Belum ada ulasan untuk produk ini.</p>
    @endif

</div>{{-- END ULASAN --}}
<div id="app-config"
    data-logged-in="{{ Auth::check() ? '1' : '0' }}"
    data-price="{{ $item->harga_per_hari ?? 0 }}"
    data-stock="{{ $item->stok ?? 0 }}"
    data-csrf="{{ csrf_token() }}"
    data-login-url="{{ route('login') }}"
></div>

@vite('resources/js/detail_produk.js')
@include('layouts.footer_biasa')    
@endsection