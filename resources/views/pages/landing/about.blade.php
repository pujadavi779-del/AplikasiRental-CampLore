<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Camplore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Keyframe animations — tidak bisa digantikan sepenuhnya oleh Tailwind standar */
        @keyframes pulse-dot {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(237, 100, 166, 0.4);
            }

            50% {
                box-shadow: 0 0 0 8px rgba(237, 100, 166, 0);
            }
        }

        .dot-pulse {
            animation: pulse-dot 2s infinite;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up-anim {
            animation: fadeUp 0.6s ease forwards;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        jakarta: ['Plus Jakarta Sans', 'sans-serif']
                    },
                    colors: {
                        primary: '#22543D',
                        accent: '#ED64A6',
                    },
                    backgroundImage: {
                        'blob-pink': 'radial-gradient(ellipse at center, #ED64A6 0%, transparent 70%)',
                        'blob-green': 'radial-gradient(ellipse at center, #22543D 0%, transparent 70%)',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 text-gray-900 overflow-x-hidden font-[Plus_Jakarta_Sans,sans-serif]">

    @include('layouts.landingpage')
    @yield('content')

    <!-- ========== HERO ABOUT ========== -->
    <section class="relative min-h-[60vh] flex items-center justify-center bg-[#22543D] overflow-hidden pt-20">
        <!-- Background texture -->
        <div class="absolute inset-0 opacity-10 bg-[url('https://images.unsplash.com/photo-1501555088652-021faa106b9b?auto=format&fit=crop&q=80')] bg-cover bg-center"></div>

        <!-- Blobs -->
        <div class="absolute top-0 right-0 w-96 h-96 opacity-10 blur-3xl bg-[radial-gradient(ellipse_at_center,#ED64A6_0%,transparent_70%)]"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>

        <div class="relative z-10 text-center px-4 max-w-3xl" data-aos="zoom-in" data-aos-duration="900">
            <span class="inline-block bg-[#ED64A6] text-white px-4 py-1 rounded-full text-xs font-bold mb-4 tracking-widest uppercase">Kisah Kami</span>
            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-5 leading-tight tracking-tighter">
                Sewa dengan Mudah —<br><span class="text-[#ED64A6]">Kamera & Camping di Satu Tempat.</span>
            </h1>
            <p class="text-emerald-100 text-lg leading-relaxed max-w-xl mx-auto">
                Dari tenda pegunungan hingga kamera mirrorless profesional — Camplore hadir untuk memastikan setiap momen petualanganmu terabadikan dengan sempurna.
            </p>
        </div>

        <!-- Wave divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="#f9fafb" />
            </svg>
        </div>
    </section>

    <!-- ========== MISSION & VISION ========== -->
    <section class="py-24 max-w-7xl mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <!-- Image collage -->
            <div class="grid grid-cols-2 gap-4 relative" data-aos="fade-right" data-aos-duration="1100">
                <div class="space-y-4">
                    <img src="https://images.unsplash.com/photo-1510312305653-8ed496efae75?auto=format&fit=crop&q=80"
                        class="rounded-3xl h-64 w-full object-cover shadow-2xl border-4 border-white" alt="Adventure camping">
                    <img src="https://images.unsplash.com/photo-1526772662000-3f88f10405ff?auto=format&fit=crop&q=80"
                        class="rounded-3xl h-44 w-full object-cover shadow-lg" alt="Tent at sunset">
                </div>
                <div class="pt-10 space-y-4">
                    <img src="https://images.unsplash.com/photo-1520390138845-fd2d229dd553?auto=format&fit=crop&q=80"
                        class="rounded-3xl h-52 w-full object-cover shadow-xl border-4 border-white" alt="Camera rental">
                    <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&q=80"
                        class="rounded-3xl h-56 w-full object-cover shadow-lg" alt="Camping gear">
                </div>
                <!-- Decorative rings -->
                <div class="absolute -bottom-8 -left-8 w-24 h-24 border-8 border-[#ED64A6]/20 rounded-full -z-10"></div>
                <div class="absolute -top-6 -right-6 w-16 h-16 bg-[#22543D]/10 rounded-full -z-10"></div>
            </div>

            <!-- Text -->
            <div data-aos="fade-left" data-aos-duration="1100">
                <span class="text-[#ED64A6] font-bold tracking-widest uppercase text-sm mb-2 block">Tentang Kami</span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-[#22543D] mb-6 tracking-tighter leading-tight">
                    Gear untuk <span class="italic text-[#ED64A6]">Petualang</span> & Kreator.
                </h2>
                <p class="text-gray-600 mb-8 leading-relaxed text-lg">
                    Camplore lahir dari kecintaan kami terhadap alam bebas dan seni fotografi. Kami percaya bahwa setiap orang berhak mengabadikan petualangannya — tanpa harus mengeluarkan biaya besar untuk membeli peralatan.
                </p>
                <p class="text-gray-600 mb-10 leading-relaxed">
                    Platform kami menghubungkan pecinta alam, fotografer, dan traveler dengan koleksi kamera mirrorless terbaru serta perlengkapan camping premium berkualitas tinggi. Satu tempat, semua yang kamu butuhkan.
                </p>

                <!-- Features -->
                <div class="grid grid-cols-2 gap-5">
                    <div class="flex items-center gap-3" data-aos="fade-up" data-aos-delay="0">
                        <div class="w-11 h-11 bg-emerald-100 rounded-2xl flex items-center justify-center text-[#22543D] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-800 text-sm">Kamera Profesional</p>
                    </div>
                    <div class="flex items-center gap-3" data-aos="fade-up" data-aos-delay="150">
                        <div class="w-11 h-11 bg-emerald-100 rounded-2xl flex items-center justify-center text-[#22543D] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-800 text-sm">Alat Camping Lengkap</p>
                    </div>
                    <div class="flex items-center gap-3" data-aos="fade-up" data-aos-delay="300">
                        <div class="w-11 h-11 bg-emerald-100 rounded-2xl flex items-center justify-center text-[#22543D] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-800 text-sm">Gear Bergaransi</p>
                    </div>
                    <div class="flex items-center gap-3" data-aos="fade-up" data-aos-delay="450">
                        <div class="w-11 h-11 bg-emerald-100 rounded-2xl flex items-center justify-center text-[#22543D] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-800 text-sm">Progress Cepat</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== IMPACT IN NUMBERS ========== -->
    <section class="py-24 bg-[#FFF5F7]">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-[#ED64A6] font-bold tracking-widest uppercase text-sm">Pencapaian Kami</span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-[#22543D] mt-2 tracking-tighter">Dampak dalam Angka</h2>
                <p class="text-gray-600 mt-4 max-w-xl mx-auto leading-relaxed">
                    Dari setiap sewa kamera hingga tenda yang dipasang di puncak gunung — setiap momen adalah bagian dari perjalanan kami bersama.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat 1 -->
                <div class="bg-white rounded-3xl p-8 border border-pink-100 shadow-sm transition duration-300 ease-in-out hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(237,100,166,0.15)]"
                    data-aos="fade-up" data-aos-delay="0">
                    <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#22543D]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        </svg>
                    </div>
                    <p class="text-4xl font-extrabold text-[#ED64A6] mb-1">+2K</p>
                    <p class="font-bold text-gray-800 mb-2">Penyewaan Gear</p>
                    <p class="text-gray-500 text-sm leading-relaxed">Ribuan kamera dan alat camping telah disewakan ke seluruh Indonesia.</p>
                </div>

                <!-- Stat 2 -->
                <div class="bg-white rounded-3xl p-8 border border-pink-100 shadow-sm transition duration-300 ease-in-out hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(237,100,166,0.15)]"
                    data-aos="fade-up" data-aos-delay="150">
                    <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#22543D]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017a2 2 0 01-1.789-1.106L6.734 14H4a2 2 0 01-2-2V7a2 2 0 012-2h2.034a2 2 0 011.789 1.106L9 8h5z" />
                        </svg>
                    </div>
                    <p class="text-4xl font-extrabold text-[#ED64A6] mb-1">98%</p>
                    <p class="font-bold text-gray-800 mb-2">Kepuasan Pelanggan</p>
                    <p class="text-gray-500 text-sm leading-relaxed">Kepuasan penyewa adalah prioritas utama kami di setiap transaksi.</p>
                </div>

                <!-- Stat 3 -->
                <div class="bg-white rounded-3xl p-8 border border-pink-100 shadow-sm transition duration-300 ease-in-out hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(237,100,166,0.15)]"
                    data-aos="fade-up" data-aos-delay="300">
                    <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#22543D]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <p class="text-4xl font-extrabold text-[#ED64A6] mb-1">8+</p>
                    <p class="font-bold text-gray-800 mb-2">Kota Terjangkau</p>
                    <p class="text-gray-500 text-sm leading-relaxed">Hadir di berbagai kota dan terus berkembang menjangkau destinasi baru.</p>
                </div>

                <!-- Stat 4 -->
                <div class="bg-white rounded-3xl p-8 border border-pink-100 shadow-sm transition duration-300 ease-in-out hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(237,100,166,0.15)]"
                    data-aos="fade-up" data-aos-delay="450">
                    <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#22543D]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <p class="text-4xl font-extrabold text-[#ED64A6] mb-1">24/7</p>
                    <p class="font-bold text-gray-800 mb-2">Dukungan Pelanggan</p>
                    <p class="text-gray-500 text-sm leading-relaxed">Tim kami siap membantu kapanpun kamu membutuhkan bantuan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== JOURNEY TIMELINE ========== -->
    <section class="py-24 bg-[#22543D] overflow-hidden relative">
        <!-- Decorative blobs -->
        <div class="absolute top-10 left-10 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-64 h-64 bg-[#ED64A6]/10 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-[#ED64A6] font-bold tracking-widest uppercase text-sm">Perjalanan Kami</span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-white mt-2 tracking-tighter">Perjalanan Kita</h2>
                <p class="text-emerald-200 mt-4 max-w-xl mx-auto">Temukan bagaimana kami mengubah semangat petualangan menjadi layanan nyata bagi para explorer.</p>
            </div>

            <!-- Timeline -->
            <div class="relative">

                <!-- Satu grid: icon + dot sejajar per kolom, garis absolute melewati tengah dot -->
                <div class="hidden md:grid grid-cols-3 relative">

                    <!-- Garis animasi: top = tinggi icon (h-20=80px) + gap dot (my-2=8px) + setengah dot (6px) = 94px -->
                    <div class="absolute left-0 right-0 h-[2px] overflow-hidden" style="top: 94px;">
                        <div id="timeline-line"
                            class="h-full bg-white rounded-full"
                            style="width:0%; transition: width 1.6s cubic-bezier(0.4,0,0.2,1);">
                        </div>
                    </div>

                    <!-- Step 1 -->
                    <div class="flex flex-col items-center" data-aos="fade-up" data-aos-delay="0">
                        <div class="w-20 h-20 rounded-full border-2 border-[#ED64A6]/60 bg-white/10 flex items-center justify-center z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#ED64A6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <div class="w-3 h-3 rounded-full bg-[#ED64A6] dot-pulse z-10 my-2"></div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center" data-aos="fade-up" data-aos-delay="200">
                        <div class="w-20 h-20 rounded-full border-2 border-[#ED64A6]/60 bg-white/10 flex items-center justify-center z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#ED64A6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <div class="w-3 h-3 rounded-full bg-[#ED64A6] dot-pulse z-10 my-2" style="animation-delay:0.3s"></div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center" data-aos="fade-up" data-aos-delay="400">
                        <div class="w-20 h-20 rounded-full border-2 border-[#ED64A6]/60 bg-white/10 flex items-center justify-center z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#ED64A6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                            </svg>
                        </div>
                        <div class="w-3 h-3 rounded-full bg-[#ED64A6] dot-pulse z-10 my-2" style="animation-delay:0.6s"></div>
                    </div>
                </div>

                <!-- Text row -->
                <div class="grid md:grid-cols-3 gap-10 mt-4">
                    <div class="text-center" data-aos="fade-up" data-aos-delay="0">
                        <h3 class="font-bold text-white text-lg mb-1">Maret 2026 — Ide Awal</h3>
                        <p class="text-emerald-200 text-sm leading-relaxed">Bermula dari diskusi kecil soal sulitnya mencari rental kamera & alat camping yang terpercaya. Riset kebutuhan pengguna dan pembentukan tim dimulai.</p>
                    </div>
                    <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="font-bold text-white text-lg mb-1">April 2026 — Pengembangan</h3>
                        <p class="text-emerald-200 text-sm leading-relaxed">Membangun fitur inti platform: sistem peminjaman, katalog gear, dan halaman detail produk kamera serta perlengkapan outdoor.</p>
                    </div>
                    <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                        <h3 class="font-bold text-white text-lg mb-1">Desember 2026 (masi belum tau) — Peluncuran</h3>
                        <p class="text-emerald-200 text-sm leading-relaxed">Penyempurnaan UI/UX, pengujian fitur, dan persiapan peluncuran resmi Camplore untuk melayani para petualang dan kreator konten.</p>
                    </div>
                </div>
            </div>

            <!-- Quote -->
            <div class="text-center mt-20" data-aos="fade-up" data-aos-delay="200">
                <p class="text-emerald-100 italic text-xl md:text-2xl font-medium max-w-2xl mx-auto leading-relaxed">
                    "Kami tidak hanya menyewakan kamera dan tenda — kami membantu kamu merekam kenangan terbaik di alam bebas."
                </p>
            </div>
        </div>
    </section>

    <!-- ========== TEAM SECTION ========== -->
    <section class="py-24 bg-[#FFF5F7]">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-[#ED64A6] font-bold tracking-widest uppercase text-sm">Tim Kami</span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-[#22543D] mt-2 tracking-tighter">The Dreamers Behind the Lens</h2>
                <p class="text-gray-600 mt-4 max-w-xl mx-auto leading-relaxed">Setiap anggota membawa semangat berbeda, namun bersama — kami menciptakan harmoni.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">

                <!-- Team 1 -->
                <div class="group bg-white rounded-3xl p-8 border border-pink-100 shadow-sm text-center
                        transition duration-[350ms] ease-[cubic-bezier(.34,1.56,.64,1)]
                        hover:-translate-y-2.5 hover:scale-[1.02] hover:shadow-[0_24px_48px_rgba(34,84,61,0.15)]"
                    data-aos="fade-up" data-aos-delay="0">
                    <div class="w-28 h-28 mx-auto mb-5 rounded-full border-4 border-[#22543D] overflow-hidden shadow-lg
                            transition duration-300 group-hover:border-[#ED64A6] group-hover:shadow-[0_0_0_4px_rgba(237,100,166,0.2)]">
                        <img src="{{ asset('images/lulu.png') }}" class="w-full h-full object-cover" alt="Lulu Khaira Yudita">
                    </div>
                    <h3 class="font-extrabold text-gray-900 text-xl mb-1">Lulu Khaira Yudita</h3>
                    <p class="text-[#ED64A6] font-semibold text-sm mb-3">FullStack</p>
                    <div class="w-10 h-1 bg-[#ED64A6] rounded-full mx-auto mb-4"></div>
                    <p class="text-gray-500 text-sm italic leading-relaxed">"3312501002"</p>
                </div>

                <!-- Team 2 -->
                <div class="group bg-[#22543D] rounded-3xl p-8 border border-[#22543D] shadow-xl text-center -mt-4
                        transition duration-[350ms] ease-[cubic-bezier(.34,1.56,.64,1)]
                        hover:-translate-y-2.5 hover:scale-[1.02] hover:shadow-[0_24px_48px_rgba(34,84,61,0.15)]"
                    data-aos="fade-up" data-aos-delay="150">
                    <div class="w-28 h-28 mx-auto mb-5 rounded-full border-4 border-[#ED64A6] overflow-hidden shadow-lg
                            transition duration-300 group-hover:shadow-[0_0_0_4px_rgba(237,100,166,0.2)]">
                        <img src="{{ asset('images/rizka.jpg') }}" class="w-full h-full object-cover" alt="Rizka Nur Azizah">
                    </div>
                    <h3 class="font-extrabold text-white text-xl mb-1">Rizka Nur Azizah</h3>
                    <p class="text-[#ED64A6] font-semibold text-sm mb-3">Leader Team</p>
                    <div class="w-10 h-1 bg-[#ED64A6] rounded-full mx-auto mb-4"></div>
                    <p class="text-emerald-200 text-sm italic leading-relaxed">"3312501004"</p>
                </div>

                <!-- Team 3 -->
                <div class="group bg-white rounded-3xl p-8 border border-pink-100 shadow-sm text-center
                        transition duration-[350ms] ease-[cubic-bezier(.34,1.56,.64,1)]
                        hover:-translate-y-2.5 hover:scale-[1.02] hover:shadow-[0_24px_48px_rgba(34,84,61,0.15)]"
                    data-aos="fade-up" data-aos-delay="300">
                    <div class="w-28 h-28 mx-auto mb-5 rounded-full border-4 border-[#22543D] overflow-hidden shadow-lg
                            transition duration-300 group-hover:border-[#ED64A6] group-hover:shadow-[0_0_0_4px_rgba(237,100,166,0.2)]">
                        <img src="{{ asset('images/puja.png') }}" class="w-full h-full object-cover" alt="Puja Davi">
                    </div>
                    <h3 class="font-extrabold text-gray-900 text-xl mb-1">Puja Davi</h3>
                    <p class="text-[#ED64A6] font-semibold text-sm mb-3">FullStack</p>
                    <div class="w-10 h-1 bg-[#ED64A6] rounded-full mx-auto mb-4"></div>
                    <p class="text-gray-500 text-sm italic leading-relaxed">"3312501020"</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== CTA BANNER ========== -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 text-center" data-aos="zoom-in">
            <div class="bg-[#22543D] rounded-3xl p-14 relative overflow-hidden shadow-2xl">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-[#ED64A6]/20 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                <span class="relative z-10 inline-block bg-[#ED64A6] text-white px-4 py-1 rounded-full text-xs font-bold mb-4 tracking-widest uppercase">Mulai Sekarang</span>
                <h2 class="relative z-10 text-3xl md:text-4xl font-extrabold text-white mb-4 tracking-tighter">Siap Memulai Petualanganmu?</h2>
                <p class="relative z-10 text-emerald-100 mb-8 leading-relaxed max-w-lg mx-auto">Jelajahi koleksi kamera dan alat camping kami. Pemesanan mudah, Progress cepat, momen tak terlupakan.</p>
                <div class="relative z-10 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#" class="bg-[#ED64A6] text-white px-10 py-4 rounded-full font-bold hover:bg-white hover:text-[#22543D] transition shadow-lg hover:scale-105 transform">Telusuri Katalog</a>
                    <a href="#" class="bg-white/10 border border-white/20 text-white px-10 py-4 rounded-full font-semibold hover:bg-white/20 transition">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>


   
    @vite('resources/js/landing.js')
    @include('layouts.footer_lp')
</body>

</html>