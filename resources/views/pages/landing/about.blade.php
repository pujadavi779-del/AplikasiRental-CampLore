<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Camplore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,800;1,700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        bebas: ['Bebas Neue', 'sans-serif'],
                        playfair: ['"Playfair Display"', 'Georgia', 'serif'],
                        dm: ['DM Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        html { scroll-behavior: smooth; }

        @keyframes heroPan {
            from { transform: scale(1.04) translateX(0); }
            to   { transform: scale(1.08) translateX(-2%); }
        }
        .hero-img-anim { animation: heroPan 12s ease-in-out infinite alternate; }

        @keyframes ticker {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }
        .ticker-scroll { animation: ticker 24s linear infinite; }

        @keyframes pulse-dot {
            0%, 100% { box-shadow: 0 0 0 0 rgba(237,100,166,0.4); }
            50%       { box-shadow: 0 0 0 8px rgba(237,100,166,0); }
        }
        .dot-pulse { animation: pulse-dot 2s infinite; }

        /* Watermark for CTA */
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

        details[open] .faq-plus { transform: rotate(45deg); }
        .faq-plus { transition: transform 0.25s; }
    </style>
</head>

<body class="font-dm bg-[#FAFAF8] text-gray-900 overflow-x-hidden">

    @include('layouts.landingpage')

    {{-- ============================================================ --}}
    {{-- HERO --}}
    {{-- ============================================================ --}}
    <section class="relative min-h-[80vh] flex items-end overflow-hidden bg-[#1a3f2e]">
        <img
            src="https://images.unsplash.com/photo-1501555088652-021faa106b9b?auto=format&fit=crop&w=1800&q=80"
            alt="About hero"
            class="absolute inset-0 w-full h-full object-cover opacity-45 hero-img-anim"
        >
        <div class="absolute inset-0 bg-gradient-to-tr from-[#22543D]/75 via-transparent to-[#ED64A6]/10"></div>
        <div class="absolute top-10 right-10 w-72 h-72 rounded-full bg-[#ED64A6]/10 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 px-6 md:px-16 pb-16 md:pb-24 max-w-3xl">
            <span class="inline-block bg-[#ED64A6] text-white text-[11px] font-bold tracking-[.18em] uppercase px-4 py-1.5 mb-5">
                Kisah Kami
            </span>
            <h1 class="font-bebas text-[clamp(52px,10vw,110px)] leading-[.9] text-white tracking-wide mb-5">
                Sewa dengan<br>
                Mudah —<br>
                <span class="text-[#ED64A6]">Kamera &amp;</span><br>
                <span class="text-[#ED64A6]">Camping.</span>
            </h1>
            <p class="text-white/75 text-base md:text-lg leading-relaxed max-w-md">
                Dari tenda pegunungan hingga kamera mirrorless profesional — Camplore hadir untuk memastikan setiap momen petualanganmu terabadikan dengan sempurna.
            </p>
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
    {{-- TENTANG KAMI — IMAGE + TEXT --}}
    {{-- ============================================================ --}}
    <section class="py-24 px-6 md:px-16 max-w-[1240px] mx-auto">
        <div class="grid md:grid-cols-2 gap-16 items-center">

            {{-- Image collage --}}
            <div class="grid grid-cols-2 gap-4 relative">
                <div class="space-y-4">
                    <img src="https://images.unsplash.com/photo-1510312305653-8ed496efae75?auto=format&fit=crop&w=600&q=80"
                         class="w-full h-64 object-cover shadow-2xl border-4 border-white" alt="Adventure camping">
                    <img src="https://images.unsplash.com/photo-1526772662000-3f88f10405ff?auto=format&fit=crop&w=600&q=80"
                         class="w-full h-44 object-cover shadow-lg" alt="Tent at sunset">
                </div>
                <div class="pt-10 space-y-4">
                    <img src="https://images.unsplash.com/photo-1520390138845-fd2d229dd553?auto=format&fit=crop&w=600&q=80"
                         class="w-full h-52 object-cover shadow-xl border-4 border-white" alt="Camera rental">
                    <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&w=600&q=80"
                         class="w-full h-56 object-cover shadow-lg" alt="Camping gear">
                </div>
                {{-- Decorative --}}
                <div class="absolute -bottom-8 -left-8 w-24 h-24 border-8 border-[#ED64A6]/20 rounded-full -z-10"></div>
                <div class="absolute -top-6 -right-6 w-16 h-16 bg-[#22543D]/10 rounded-full -z-10"></div>
            </div>

            {{-- Text --}}
            <div>
                <span class="text-[#ED64A6] text-[11px] font-bold tracking-[.2em] uppercase block mb-3">Tentang Kami</span>
                <h2 class="font-bebas text-[clamp(40px,6vw,68px)] leading-[.92] text-[#22543D] tracking-wide mb-6">
                    Gear untuk<br>
                    <span class="text-[#ED64A6]">Petualang</span><br>
                    &amp; Kreator.
                </h2>
                <p class="text-gray-600 text-[15px] leading-relaxed mb-5">
                    Camplore lahir dari kecintaan kami terhadap alam bebas dan seni fotografi. Kami percaya bahwa setiap orang berhak mengabadikan petualangannya — tanpa harus mengeluarkan biaya besar untuk membeli peralatan.
                </p>
                <p class="text-gray-500 text-[14px] leading-relaxed mb-10">
                    Platform kami menghubungkan pecinta alam, fotografer, dan traveler dengan koleksi kamera mirrorless terbaru serta perlengkapan camping premium berkualitas tinggi. Satu tempat, semua yang kamu butuhkan.
                </p>

                {{-- Features grid --}}
                <div class="grid grid-cols-2 gap-4">
                    @php
                    $features = [
                        ['icon'=>'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z','label'=>'Kamera Profesional'],
                        ['icon'=>'M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z','label'=>'Alat Camping Lengkap'],
                        ['icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','label'=>'Gear Bergaransi'],
                        ['icon'=>'M13 10V3L4 14h7v7l9-11h-7z','label'=>'Progress Cepat'],
                    ];
                    @endphp
                    @foreach($features as $f)
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-emerald-100 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#22543D]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['icon'] }}"/>
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-800 text-sm">{{ $f['label'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- STATS / NUMBERS --}}
    {{-- ============================================================ --}}
    <section class="py-20 px-6 md:px-16 bg-[#FFF0F5]">
        <div class="max-w-[1240px] mx-auto">
            <div class="text-center mb-14">
                <span class="text-[#ED64A6] text-[11px] font-bold tracking-[.2em] uppercase block mb-2">Pencapaian Kami</span>
                <h2 class="font-playfair text-4xl md:text-5xl font-extrabold text-[#22543D]">Dampak dalam Angka</h2>
                <p class="text-gray-500 mt-4 max-w-xl mx-auto text-[15px] leading-relaxed">
                    Dari setiap sewa kamera hingga tenda yang dipasang di puncak gunung — setiap momen adalah bagian dari perjalanan kami bersama.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @php
                $stats = [
                    ['icon'=>'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z','num'=>'+2K','title'=>'Penyewaan Gear','desc'=>'Ribuan kamera dan alat camping telah disewakan ke seluruh Indonesia.'],
                    ['icon'=>'M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017a2 2 0 01-1.789-1.106L6.734 14H4a2 2 0 01-2-2V7a2 2 0 012-2h2.034a2 2 0 011.789 1.106L9 8h5z','num'=>'98%','title'=>'Kepuasan Pelanggan','desc'=>'Kepuasan penyewa adalah prioritas utama kami di setiap transaksi.'],
                    ['icon'=>'M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z','num'=>'8+','title'=>'Kota Terjangkau','desc'=>'Hadir di berbagai kota dan terus berkembang menjangkau destinasi baru.'],
                    ['icon'=>'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z','num'=>'24/7','title'=>'Dukungan Pelanggan','desc'=>'Tim kami siap membantu kapanpun kamu membutuhkan bantuan.'],
                ];
                @endphp
                @foreach($stats as $s)
                <div class="bg-white border border-pink-100 p-7 hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(237,100,166,0.15)] transition-all duration-300 group">
                    <div class="w-12 h-12 bg-emerald-100 flex items-center justify-center mb-5 group-hover:bg-[#22543D] transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#22543D] group-hover:text-white transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/>
                        </svg>
                    </div>
                    <p class="font-bebas text-5xl text-[#ED64A6] mb-1 tracking-wide">{{ $s['num'] }}</p>
                    <p class="font-bold text-gray-800 text-[15px] mb-2">{{ $s['title'] }}</p>
                    <p class="text-gray-400 text-[13px] leading-relaxed">{{ $s['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- TIMELINE --}}
    {{-- ============================================================ --}}
    <section class="py-24 px-6 md:px-16 bg-[#22543D] overflow-hidden relative">
        <div class="absolute top-10 left-10 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-64 h-64 bg-[#ED64A6]/10 rounded-full blur-3xl"></div>

        <div class="max-w-[1100px] mx-auto relative z-10">
            <div class="text-center mb-16">
                <span class="text-[#ED64A6] text-[11px] font-bold tracking-[.2em] uppercase block mb-2">Perjalanan Kami</span>
                <h2 class="font-playfair text-4xl md:text-5xl font-extrabold text-white">Perjalanan Kita</h2>
                <p class="text-emerald-200 mt-4 max-w-xl mx-auto text-[15px] leading-relaxed">
                    Temukan bagaimana kami mengubah semangat petualangan menjadi layanan nyata bagi para explorer.
                </p>
            </div>

            {{-- Timeline steps --}}
            <div class="relative">
                {{-- Connector line (desktop) --}}
                <div class="hidden md:block absolute left-0 right-0 h-[2px] bg-white/20" style="top: 94px;">
                    <div class="h-full bg-[#ED64A6] w-full origin-left" style="transform: scaleX(1); transition: transform 1.6s ease;"></div>
                </div>

                <div class="hidden md:grid grid-cols-3 mb-0">
                    @php
                    $tl_icons = [
                        'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                        'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
                        'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064',
                    ];
                    @endphp
                    @foreach($tl_icons as $i => $path)
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 border-2 border-[#ED64A6]/60 bg-white/10 flex items-center justify-center z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#ED64A6]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/>
                            </svg>
                        </div>
                        <div class="w-3 h-3 bg-[#ED64A6] dot-pulse z-10 my-2" style="animation-delay: {{ $i * 0.3 }}s"></div>
                    </div>
                    @endforeach
                </div>

                <div class="grid md:grid-cols-3 gap-10 mt-6">
                    @php
                    $timeline = [
                        ['title'=>'Maret 2026 — Ide Awal','desc'=>'Bermula dari diskusi kecil soal sulitnya mencari rental kamera & alat camping yang terpercaya. Riset kebutuhan pengguna dan pembentukan tim dimulai.'],
                        ['title'=>'April 2026 — Pengembangan','desc'=>'Membangun fitur inti platform: sistem peminjaman, katalog gear, dan halaman detail produk kamera serta perlengkapan outdoor.'],
                        ['title'=>'Desember 2026 — Peluncuran','desc'=>'Penyempurnaan UI/UX, pengujian fitur, dan persiapan peluncuran resmi Camplore untuk melayani para petualang dan kreator konten.'],
                    ];
                    @endphp
                    @foreach($timeline as $t)
                    <div class="text-center">
                        <p class="font-bold text-white text-[15px] mb-2">{{ $t['title'] }}</p>
                        <p class="text-emerald-200 text-[13px] leading-relaxed">{{ $t['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Quote --}}
            <div class="text-center mt-20 border-t border-white/10 pt-14">
                <p class="text-emerald-100 italic text-xl md:text-2xl font-medium max-w-2xl mx-auto leading-relaxed">
                    "Kami tidak hanya menyewakan kamera dan tenda — kami membantu kamu merekam kenangan terbaik di alam bebas."
                </p>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- TEAM --}}
    {{-- ============================================================ --}}
    <section class="py-20 px-6 md:px-16 bg-[#FFF0F5]">
        <div class="max-w-[1100px] mx-auto">
            <div class="text-center mb-14">
                <span class="text-[#ED64A6] text-[11px] font-bold tracking-[.2em] uppercase block mb-2">Tim Kami</span>
                <h2 class="font-playfair text-4xl md:text-5xl font-extrabold text-[#22543D]">Tim di Balik Lensa<br>dan Petualangan</h2>
                <p class="text-gray-500 mt-4 max-w-xl mx-auto text-[15px] leading-relaxed">
                    Setiap anggota membawa semangat berbeda, namun bersama — kami menciptakan harmoni.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto">

                {{-- Member 1 --}}
                <div class="group bg-white border border-pink-100 p-8 text-center hover:-translate-y-2 hover:shadow-[0_24px_48px_rgba(34,84,61,0.12)] transition-all duration-300">
                    <div class="w-28 h-28 mx-auto mb-5 border-4 border-[#22543D] overflow-hidden group-hover:border-[#ED64A6] transition-colors duration-300">
                        <img src="{{ asset('images/lulu.png') }}" class="w-full h-full object-cover" alt="Lulu Khaira Yudita">
                    </div>
                    <h3 class="font-extrabold text-gray-900 text-lg mb-1">Lulu Khaira Yudita</h3>
                    <p class="text-[#ED64A6] font-semibold text-sm mb-3">Anggota</p>
                    <div class="w-8 h-[3px] bg-[#ED64A6] mx-auto"></div>
                </div>

                {{-- Member 2 — Featured / Ketua --}}
                <div class="group bg-[#22543D] border border-[#22543D] p-8 text-center -mt-4 shadow-xl hover:-translate-y-2 hover:shadow-[0_24px_48px_rgba(34,84,61,0.25)] transition-all duration-300">
                    <div class="w-28 h-28 mx-auto mb-5 border-4 border-[#ED64A6] overflow-hidden">
                        <img src="{{ asset('images/rizka.png') }}" class="w-full h-full object-cover" alt="Rizka Nur Azizah">
                    </div>
                    <h3 class="font-extrabold text-white text-lg mb-1">Rizka Nur Azizah</h3>
                    <p class="text-[#ED64A6] font-semibold text-sm mb-3">Ketua</p>
                    <div class="w-8 h-[3px] bg-[#ED64A6] mx-auto"></div>
                </div>

                {{-- Member 3 --}}
                <div class="group bg-white border border-pink-100 p-8 text-center hover:-translate-y-2 hover:shadow-[0_24px_48px_rgba(34,84,61,0.12)] transition-all duration-300">
                    <div class="w-28 h-28 mx-auto mb-5 border-4 border-[#22543D] overflow-hidden group-hover:border-[#ED64A6] transition-colors duration-300">
                        <img src="{{ asset('images/puja.png') }}" class="w-full h-full object-cover" alt="Puja Davi">
                    </div>
                    <h3 class="font-extrabold text-gray-900 text-lg mb-1">Puja Davi</h3>
                    <p class="text-[#ED64A6] font-semibold text-sm mb-3">Anggota</p>
                    <div class="w-8 h-[3px] bg-[#ED64A6] mx-auto"></div>
                </div>

            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- FULL BLEED SPLIT — same pattern as landing --}}
    {{-- ============================================================ --}}
    <section class="grid grid-cols-1 md:grid-cols-2 min-h-[420px]">
        <div class="overflow-hidden">
            <img src="https://images.unsplash.com/photo-1516939884455-1445c8652f83?auto=format&fit=crop&w=900&q=80"
                 alt="Drone view nature"
                 class="w-full h-full object-cover min-h-[300px]">
        </div>
        <div class="bg-[#22543D] flex flex-col justify-center px-10 md:px-16 py-16">
            <span class="text-[#ED64A6] text-[11px] font-bold tracking-[.2em] uppercase mb-5">✦ Mulai Sekarang</span>
            <h2 class="font-bebas text-[clamp(38px,5.5vw,64px)] leading-[.9] text-white tracking-wide mb-5">
                Siap Memulai<br>Petualanganmu?
            </h2>
            <p class="text-white/70 text-[15px] leading-relaxed mb-8 max-w-sm">
                Jelajahi koleksi kamera dan alat camping kami. Pemesanan mudah, Progress cepat, momen tak terlupakan.
            </p>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ url('/') }}#catalog"
                   class="self-start bg-[#ED64A6] hover:bg-[#d6529a] text-white font-bold text-xs tracking-widest uppercase px-8 py-3.5 transition-colors duration-200">
                    Telusuri Katalog
                </a>
                <a href="#"
                   class="self-start border-2 border-white/40 hover:border-white text-white font-bold text-xs tracking-widest uppercase px-8 py-3.5 transition-all duration-200">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- CTA STRIP --}}
    {{-- ============================================================ --}}
    <section class="relative bg-[#ED64A6] py-20 px-5 text-center overflow-hidden cta-watermark">
        <div class="relative z-10">
            <h2 class="font-bebas text-[clamp(40px,7vw,80px)] text-white tracking-wider mb-2">
                Abadikan Momenmu Bersama Kami
            </h2>
            <p class="text-white/80 text-[15px] mb-8 max-w-md mx-auto">
                Gear terbaik, tim yang ramah, dan pengalaman sewa yang mulus — itu Camplore.
            </p>
            <a href="{{ url('/') }}#catalog"
               class="inline-block bg-white text-[#ED64A6] hover:bg-[#22543D] hover:text-white font-extrabold text-xs tracking-widest uppercase px-10 py-4 transition-all duration-200">
                Mulai Sewa Sekarang
            </a>
        </div>
    </section>

    @vite('resources/js/landing.js')
    @include('layouts.footer_LP')

</body>
</html>