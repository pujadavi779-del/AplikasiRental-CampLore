{{-- resources/views/pages/landing.blade.php --}}

@extends('layouts.landingpage')

@section('content')

{{-- Google Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">

<style>
    .font-bebas    { font-family: 'Bebas Neue', sans-serif; }
    .font-playfair { font-family: 'Playfair Display', serif; }
    .font-inter    { font-family: 'Inter', sans-serif; }

    @keyframes ticker {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }
    .ticker-scroll { animation: ticker 24s linear infinite; }

    @keyframes heroPan {
        from { transform: scale(1.04) translateX(0); }
        to   { transform: scale(1.08) translateX(-2%); }
    }
    .hero-img-anim { animation: heroPan 12s ease-in-out infinite alternate; }

    html { scroll-behavior: smooth; }

    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    details[open] .faq-plus { transform: rotate(45deg); }
    .faq-plus { transition: transform 0.25s; }

    .cta-watermark::before {
        content: 'CAMPLORE';
        position: absolute;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 180px;
        color: rgba(255,255,255,0.07);
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        white-space: nowrap;
        pointer-events: none;
        z-index: 0;
    }

    /* Shimmer line for steps */
    .step-connector {
        position: relative;
    }
    .step-connector::before {
        content: '';
        position: absolute;
        top: 28px;
        left: calc(50% + 28px);
        right: calc(-50% + 28px);
        height: 2px;
        background: linear-gradient(90deg, #ED64A6, rgba(237,100,166,0.2));
    }
    .step-connector:last-child::before { display: none; }
</style>

<div class="font-inter bg-[#FAFAF8] text-gray-900 overflow-x-hidden" style="font-family:'Inter',sans-serif;">

    {{-- ============================================================ --}}
    {{-- HERO --}}
    {{-- ============================================================ --}}
    <section class="relative min-h-[88vh] flex items-end overflow-hidden bg-[#1a3f2e]">
        <img
            src="https://images.unsplash.com/photo-1510312305653-8ed496efae75?auto=format&fit=crop&w=1800&q=80"
            alt="Hero camping"
            class="absolute inset-0 w-full h-full object-cover opacity-50 hero-img-anim"
        >
        <div class="absolute inset-0 bg-gradient-to-tr from-[#22543D]/70 via-transparent to-[#ED64A6]/15"></div>
        <div class="absolute top-10 right-10 w-72 h-72 rounded-full bg-[#ED64A6]/10 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 px-6 md:px-16 pb-16 md:pb-24 max-w-3xl">
            <span class="inline-block bg-[#ED64A6] text-white text-[11px] font-bold tracking-[.18em] uppercase px-4 py-1.5 mb-5">
                🎒 Sewa Kamera & Camping Gear #1 di Batam
            </span>
            <h1 class="font-bebas text-[clamp(60px,11vw,120px)] leading-[.9] text-white tracking-wide mb-5">
                Abadikan<br>
                <span class="text-[#ED64A6]">Keindahan</span><br>
                Alam Bebas
            </h1>
            <p class="text-white/75 text-base md:text-lg leading-relaxed mb-8 max-w-md">
                Rental kamera mirrorless dan alat camping premium. Jelajahi — abadikan — nikmati, tanpa beli alat mahal.
            </p>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="#catalog"
                   class="bg-[#ED64A6] hover:bg-[#d6529a] text-white font-bold text-sm tracking-widest uppercase px-9 py-4 transition-all duration-200 hover:-translate-y-1 shadow-lg">
                    Jelajahi Perlengkapan
                </a>
                <a href="{{ route('pages.landing.about') }}"
                   class="border-2 border-white/50 hover:border-white hover:bg-white/10 text-white font-semibold text-sm tracking-widest uppercase px-9 py-4 transition-all duration-200">
                    Tentang Kami →
                </a>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- TICKER --}}
    {{-- ============================================================ --}}
    <div class="bg-[#22543D] border-t-4 border-[#ED64A6] overflow-hidden py-3">
        <div class="flex gap-16 whitespace-nowrap w-max ticker-scroll">
            @php
            $tickers = [
                '📷 Kamera Mirrorless','⛺ Tenda Ultralight','🔥 Kompor Portable',
                '🎒 Sleeping Bag Premium','🚚 Antar ke Basecamp','🛡️ Diasuransikan Penuh',
                '📷 Kamera Mirrorless','⛺ Tenda Ultralight','🔥 Kompor Portable',
                '🎒 Sleeping Bag Premium','🚚 Antar ke Basecamp','🛡️ Diasuransikan Penuh',
            ];
            @endphp
            @foreach($tickers as $t)
                <span class="flex items-center gap-3 text-white text-xs font-bold tracking-[.14em] uppercase">
                    <span class="text-[#ED64A6] text-lg leading-none">✦</span>
                    {{ $t }}
                </span>
            @endforeach
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- HOT & TRENDING --}}
    {{-- ============================================================ --}}
    <section class="py-20 px-5 md:px-10 max-w-[1240px] mx-auto" id="catalog">
        <div class="text-center mb-12">
            <span class="text-[#ED64A6] text-[11px] font-bold tracking-[.2em] uppercase block mb-2">Populer Minggu Ini</span>
            <h2 class="font-playfair text-4xl md:text-5xl font-extrabold text-[#22543D]">Rental Terlaris</h2>
        </div>

        <div class="overflow-x-auto no-scrollbar pb-3">
            <div class="flex gap-5" style="min-width: max-content;">
                @php
                $products = [
                    ['badge'=>'Best Seller','pink'=>false,'name'=>'Canon EOS R6','cat'=>'Kamera','price'=>'Rp250k','old'=>'','img'=>'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=400&q=80'],
                    ['badge'=>'Top Pick','pink'=>true,'name'=>'Sony A7 III','cat'=>'Kamera','price'=>'Rp300k','old'=>'','img'=>'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?auto=format&fit=crop&w=400&q=80'],
                    ['badge'=>'Best Seller','pink'=>false,'name'=>'Ultralight Tent 2P','cat'=>'Camping','price'=>'Rp100k','old'=>'','img'=>'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&w=400&q=80'],
                    ['badge'=>'New','pink'=>true,'name'=>'DJI Ronin SC','cat'=>'Aksesori','price'=>'Rp180k','old'=>'','img'=>'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=400&q=80'],
                    ['badge'=>'Best Seller','pink'=>false,'name'=>'Portable Cooking Set','cat'=>'Camping','price'=>'Rp60k','old'=>'','img'=>'https://images.unsplash.com/photo-1603126857599-f6e157fa2fe6?auto=format&fit=crop&w=400&q=80'],
                    ['badge'=>'Promo','pink'=>true,'name'=>'Sleeping Bag -10°C','cat'=>'Camping','price'=>'Rp75k','old'=>'Rp90k','img'=>'https://images.unsplash.com/photo-1571863533956-01c88e79957e?auto=format&fit=crop&w=400&q=80'],
                    ['badge'=>'Top Pick','pink'=>false,'name'=>'Fujifilm X-T4','cat'=>'Kamera','price'=>'Rp280k','old'=>'','img'=>'https://images.unsplash.com/photo-1606983340126-99ab4feaa64a?auto=format&fit=crop&w=400&q=80'],
                    ['badge'=>'Promo','pink'=>true,'name'=>'Trekking Pole Set','cat'=>'Outdoor','price'=>'Rp40k','old'=>'Rp55k','img'=>'https://images.unsplash.com/photo-1553361371-9b22f78e8b1d?auto=format&fit=crop&w=400&q=80'],
                ];
                @endphp

                @foreach($products as $p)
                <div class="w-52 flex-shrink-0 bg-white border border-gray-100 group hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer relative">
                    <span class="absolute top-2.5 left-2.5 z-10 text-white text-[10px] font-bold tracking-widest uppercase px-3 py-1 {{ $p['pink'] ? 'bg-[#ED64A6]' : 'bg-[#22543D]' }}">
                        {{ $p['badge'] }}
                    </span>
                    <div class="overflow-hidden aspect-square">
                        <img src="{{ $p['img'] }}" alt="{{ $p['name'] }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-4">
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-1">{{ $p['cat'] }}</p>
                        <p class="font-semibold text-[14px] text-gray-800 leading-snug mb-1">{{ $p['name'] }}</p>
                        <p class="font-extrabold text-[#ED64A6] text-base">
                            @if($p['old'])
                                <span class="text-xs text-gray-400 line-through font-normal mr-1">{{ $p['old'] }}</span>
                            @endif
                            {{ $p['price'] }}<span class="text-[11px] text-gray-400 font-normal">/Hari</span>
                        </p>
                        <button class="mt-3 w-full bg-[#22543D] hover:bg-[#ED64A6] text-white text-xs font-bold tracking-widest uppercase py-2.5 transition-colors duration-200">
                            Sewa Sekarang
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ✅ FIX: 2 tombol terpisah — Kamera & Camping --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-10">
            <a href="{{ route('camera.LP') }}"
               class="group flex items-center gap-3 bg-[#22543D] hover:bg-[#1a3f2e] text-white font-bold text-xs tracking-widest uppercase px-8 py-4 transition-all duration-200 shadow-md hover:shadow-xl hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Semua Kamera
                <span class="text-[#ED64A6] group-hover:translate-x-1 transition-transform duration-200">→</span>
            </a>
            <a href="{{ route('camping.LP') }}"
               class="group flex items-center gap-3 border-2 border-[#22543D] text-[#22543D] hover:bg-[#22543D] hover:text-white font-bold text-xs tracking-widest uppercase px-8 py-4 transition-all duration-200 hover:shadow-xl hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l6-10 4 6 3-4 5 8H3z"/>
                </svg>
                Semua Camping Gear
                <span class="group-hover:translate-x-1 transition-transform duration-200">→</span>
            </a>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- ✅ FIX: SHOP BY CATEGORY — Kontras lebih kuat, dark green bg --}}
    {{-- ============================================================ --}}
    <section class="bg-[#22543D] py-20 px-5 md:px-10">
        <div class="max-w-[1240px] mx-auto">

            {{-- Header --}}
            <div class="text-center mb-14">
                <span class="inline-block bg-[#ED64A6] text-white text-[11px] font-bold tracking-[.2em] uppercase px-4 py-1.5 mb-4">
                    Temukan Kategorimu
                </span>
                <h2 class="font-playfair text-4xl md:text-5xl font-extrabold text-white">
                    Belanja per Kategori
                </h2>
            </div>

            @php
            $cats = [
                [
                    'label'    => 'Kamera',
                    'sub'      => 'Mirrorless · Action Cam · Lensa',
                    'img'      => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=800&q=80',
                    'link'     => route('camera.LP'),
                    'accent'   => 'bg-[#ED64A6]',
                    'badge'    => '20+ Item',
                ],
                [
                    'label'    => 'Camping',
                    'sub'      => 'Tenda · Sleeping Bag · Masak',
                    'img'      => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&w=800&q=80',
                    'link'     => route('camping.LP'),
                    'accent'   => 'bg-white',
                    'badge'    => '30+ Item',
                ],
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                @foreach($cats as $c)
                <a href="{{ $c['link'] }}"
                   class="relative overflow-hidden group block shadow-2xl hover:-translate-y-2 transition-all duration-500">

                    {{-- Image --}}
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="{{ $c['img'] }}" alt="{{ $c['label'] }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 brightness-75 group-hover:brightness-90">
                    </div>

                    {{-- Dark gradient overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                    {{-- Top badge --}}
                    <span class="absolute top-4 right-4 {{ $c['accent'] }} {{ $c['accent'] === 'bg-white' ? 'text-[#22543D]' : 'text-white' }} text-[11px] font-extrabold tracking-widest uppercase px-3 py-1.5">
                        {{ $c['badge'] }}
                    </span>

                    {{-- Bottom text --}}
                    <div class="absolute bottom-0 left-0 right-0 p-7">
                        <p class="text-white/60 text-xs font-semibold tracking-widest uppercase mb-1">{{ $c['sub'] }}</p>
                        <div class="flex items-end justify-between">
                            <h3 class="font-bebas text-5xl text-white tracking-wide leading-none">{{ $c['label'] }}</h3>
                            <span class="flex items-center gap-2 text-white font-bold text-sm tracking-widest uppercase border border-white/40 px-4 py-2 group-hover:bg-[#ED64A6] group-hover:border-[#ED64A6] transition-all duration-300">
                                Lihat
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- ✅ FIX: HOW IT WORKS — bg putih bersih, numbered steps kontras --}}
    {{-- ============================================================ --}}
    <section class="py-24 px-5 md:px-10 bg-[#FAFAF8] border-t border-gray-100">
        <div class="max-w-[1100px] mx-auto">

            {{-- Header --}}
            <div class="text-center mb-16">
                <span class="inline-block bg-[#22543D] text-white text-[11px] font-bold tracking-[.2em] uppercase px-4 py-1.5 mb-4">
                    Gampang Banget
                </span>
                <h2 class="font-playfair text-4xl md:text-5xl font-extrabold text-[#22543D]">
                    Cara Sewa di <span class="text-[#ED64A6]">Camplore</span>
                </h2>
            </div>

            @php
            $steps = [
                ['n'=>'01','title'=>'Pilih Alat','desc'=>'Browse katalog kamera dan camping gear. Cek ketersediaan tanggal sesuai rencana tripmu.','path'=>'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
                ['n'=>'02','title'=>'Booking Online','desc'=>'Isi form pemesanan, unggah foto KTP, dan bayar DP via transfer atau e-wallet.','path'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['n'=>'03','title'=>'Ambil / Dikirim','desc'=>'Ambil langsung di toko kami, atau pilih layanan antar ke basecamp atau lokasi kamu.','path'=>'M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4'],
                ['n'=>'04','title'=>'Kembalikan','desc'=>'Kembalikan sesuai jadwal. Alat dicek bersama-sama, deposit langsung dikembalikan.','path'=>'M5 13l4 4L19 7'],
            ];
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-0 relative">
                {{-- connector line desktop --}}
                <div class="hidden md:block absolute top-[27px] left-[12.5%] right-[12.5%] h-[2px] bg-gray-200 z-0">
                    <div class="h-full bg-gradient-to-r from-[#22543D] to-[#ED64A6]"></div>
                </div>

                @foreach($steps as $i => $s)
                <div class="relative z-10 flex flex-col items-center text-center px-4">

                    {{-- Step circle --}}
                    <div class="w-14 h-14 rounded-full flex items-center justify-center mb-5 shadow-lg ring-4 ring-white
                        {{ $i % 2 === 0 ? 'bg-[#22543D]' : 'bg-[#ED64A6]' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['path'] }}"/>
                        </svg>
                    </div>

                    {{-- Number --}}
                    <p class="font-bebas text-5xl leading-none mb-2 tracking-wide
                        {{ $i % 2 === 0 ? 'text-[#22543D]' : 'text-[#ED64A6]' }}">
                        {{ $s['n'] }}
                    </p>

                    {{-- Title --}}
                    <p class="font-extrabold text-gray-900 text-[15px] mb-2">{{ $s['title'] }}</p>

                    {{-- Desc --}}
                    <p class="text-gray-500 text-[13px] leading-relaxed">{{ $s['desc'] }}</p>

                </div>
                @endforeach
            </div>

            {{-- CTA bawah --}}
            <div class="text-center mt-14">
                <a href="#catalog"
                   class="inline-block bg-[#ED64A6] hover:bg-[#d6529a] text-white font-bold text-xs tracking-widest uppercase px-10 py-4 transition-all duration-200 shadow-md hover:shadow-xl hover:-translate-y-0.5">
                    Mulai Sewa Sekarang
                </a>
            </div>

        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- COMMUNITY GALLERY --}}
    {{-- ============================================================ --}}
    <section>
        <div class="text-center py-14 px-5 bg-[#FAFAF8]">
            <span class="text-[#ED64A6] text-[11px] font-bold tracking-[.2em] uppercase block mb-2">Komunitas Camplore</span>
            <h2 class="font-playfair text-4xl md:text-5xl font-extrabold text-[#22543D]">Momen Para Penjelajah</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4">
            @php
            $ugcs = [
                'https://images.unsplash.com/photo-1501555088652-021faa106b9b?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1526772662000-3f88f10405ff?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1516939884455-1445c8652f83?auto=format&fit=crop&w=600&q=80',
                'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=600&q=80',
            ];
            @endphp
            @foreach($ugcs as $u)
            <div class="relative aspect-square overflow-hidden group cursor-pointer">
                <img src="{{ $u }}" alt="Community"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-[#22543D]/0 group-hover:bg-[#22543D]/50 transition-colors duration-300 flex items-center justify-center">
                    <svg class="text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 w-9 h-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                        <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/>
                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                    </svg>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- FAQ --}}
    {{-- ============================================================ --}}
    <section class="py-20 px-5 md:px-10 bg-[#FAFAF8]">
        <div class="max-w-[760px] mx-auto">
            <div class="text-center mb-12">
                <span class="text-[#ED64A6] text-[11px] font-bold tracking-[.2em] uppercase block mb-2">Pertanyaan Umum</span>
                <h2 class="font-playfair text-4xl md:text-5xl font-extrabold text-[#22543D]">FAQ</h2>
            </div>
            @php
            $faqs = [
                ['q'=>'Bagaimana proses penyewaan bekerja?','a'=>'Pilih alat di website, isi form booking, unggah KTP. Alat bisa diambil di store kami atau dikirim ke lokasi Anda sesuai area operasional kami.'],
                ['q'=>'Apakah diperlukan deposit?','a'=>'Ya, kami membutuhkan deposit berupa uang jaminan atau menahan kartu identitas asli (SIM/Paspor) selama masa sewa untuk item premium.'],
                ['q'=>'Apa yang terjadi jika peralatan rusak?','a'=>'Kami menyarankan penambahan asuransi sewa kecil di awal. Jika tidak berasuransi, penyewa bertanggung jawab penuh atas biaya perbaikan kerusakan alat.'],
                ['q'=>'Apakah Anda mengirim ke lokasi basecamp?','a'=>'Tentu! Kami melayani pengiriman ke area basecamp gunung atau pantai populer di wilayah operasional kami di Batam dan sekitarnya.'],
                ['q'=>'Berapa lama minimal sewa?','a'=>'Minimal sewa adalah 1 hari (24 jam). Tersedia juga paket 3 hari dan 7 hari dengan harga yang lebih hemat.'],
            ];
            @endphp
            <div class="divide-y divide-gray-200">
                @foreach($faqs as $i => $faq)
                <details class="group py-5" {{ $i === 0 ? 'open' : '' }}>
                    <summary class="flex justify-between items-center gap-4 font-bold text-[15px] text-[#22543D] cursor-pointer list-none select-none">
                        {{ $faq['q'] }}
                        <span class="faq-plus flex-shrink-0 text-[#ED64A6]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-[14px] text-gray-600 leading-relaxed">{{ $faq['a'] }}</p>
                </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- CTA STRIP --}}
    {{-- ============================================================ --}}
    <section class="relative bg-[#ED64A6] py-20 px-5 text-center overflow-hidden cta-watermark">
        <div class="relative z-10">
            <h2 class="font-bebas text-[clamp(40px,7vw,80px)] text-white tracking-wider mb-2">
                Siap Jelajahi Alam?
            </h2>
            <p class="text-white/80 text-[15px] mb-8">
                Lengkapi petualanganmu hari ini — perlengkapan terbaik, harga terjangkau.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('camera.LP') }}"
                   class="inline-block bg-white text-[#ED64A6] hover:bg-[#22543D] hover:text-white font-extrabold text-xs tracking-widest uppercase px-10 py-4 transition-all duration-200">
                    📷 Lihat Kamera
                </a>
                <a href="{{ route('camping.LP') }}"
                   class="inline-block border-2 border-white text-white hover:bg-white hover:text-[#ED64A6] font-extrabold text-xs tracking-widest uppercase px-10 py-4 transition-all duration-200">
                    ⛺ Lihat Camping Gear
                </a>
            </div>
        </div>
    </section>

</div>

@include('layouts.footer_LP')

@vite('resources/js/landing.js')

@endsection