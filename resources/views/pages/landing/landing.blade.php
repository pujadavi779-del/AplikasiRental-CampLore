
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camplore - Capture Your Adventure | Rental Kamera & Alat Camping</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* Custom Colors & Config */
        :root {
            --primary-green: #22543D;
            /* Hijau Tua Forest */
            --accent-pink: #ED64A6;
            /* Pink Cerah */
            --light-pink-bg: #FFF5F7;
            /* Pink Sangat Muda untuk BG */
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom Font (Optional, biar lebih keren) */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 overflow-x-hidden">

    @include('layouts.landingpage')
    @yield('content')

    <section id="hero" class="relative min-h-[90vh] flex items-center justify-center bg-[#22543D] text-white overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1510312305653-8ed496efae75?auto=format&fit=crop&q=80')] bg-cover bg-center"></div>

        <div class="absolute -top-16 -left-16 w-64 h-64 bg-[#ED64A6]/20 rounded-full blur-3xl" data-aos="fade-down" data-aos-delay="400"></div>
        <div class="absolute -bottom-16 -right-16 w-80 h-80 bg-white/10 rounded-full blur-3xl" data-aos="fade-up" data-aos-delay="600"></div>

        <div class="relative z-10 text-center px-4 max-w-4xl" data-aos="zoom-in" data-aos-duration="1000">
            <span class=" text-white px-4 py-1 rounded-full text-xs font-bold mb-4 tracking-widest uppercase">The Ultimate Adventure Companion</span>
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight tracking-tighter">Capture <span class="text-[#ED64A6]">Nature</span>,<br> Experience Freedom.</h1>
            <p class="text-lg md:text-xl text-emerald-100 mb-10 max-w-2xl mx-auto leading-relaxed">
                Sewakan perlengkapan Camping premium dan Kamera profesional dalam satu tempat. Jelajahi dunia, abadikan momen terbaikmu tanpa beban.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#catalog" class="bg-[#ED64A6] text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-[#22543D] transition-all shadow-lg transform hover:scale-105">Browse Gear</a>
                <a href="{{ route('pages.landing.about') }}" class="bg-white/10 backdrop-blur-sm border border-white/20 text-white px-10 py-4 rounded-full font-semibold text-lg hover:bg-white/20 transition">Our Story</a>
            </div>
        </div>
    </section>

    <section id="about" class="py-24 max-w-7xl mx-auto px-4 overflow-hidden">
        <div class="grid md:grid-cols-2 gap-16 items-center">

            <div class="grid grid-cols-2 gap-4 relative" data-aos="fade-right" data-aos-duration="1200">
                <div class="space-y-4">
                    <img src="https://images.unsplash.com/photo-1501555088652-021faa106b9b?auto=format&fit=crop&q=80" class="rounded-3xl h-72 w-full object-cover shadow-2xl border-4 border-white" alt="Hiking Mount">
                    <img src="https://images.unsplash.com/photo-1526772662000-3f88f10405ff?auto=format&fit=crop&q=80" class="rounded-3xl h-40 w-full object-cover shadow-lg" alt="Tent Camping">
                </div>
                <div class="pt-10 space-y-4">
                    <img src="https://images.unsplash.com/photo-1520390138845-fd2d229dd553?auto=format&fit=crop&q=80" class="rounded-3xl h-48 w-full object-cover shadow-xl border-4 border-white" alt="Professional Camera">
                    <img src="https://images.unsplash.com/photo-1516939884455-1445c8652f83?auto=format&fit=crop&q=80" class="rounded-3xl h-64 w-full object-cover shadow-lg" alt="Drone View">
                </div>
                <div class="absolute -bottom-8 -left-8 w-24 h-24 border-8 border-[#ED64A6]/20 rounded-full z-[-1]"></div>
            </div>

            <div data-aos="fade-left" data-aos-duration="1200">
                <span class="text-[#ED64A6] font-bold tracking-widest uppercase text-sm mb-2 block">All-in-One Rental</span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-[#22543D] mb-6 tracking-tighter leading-tight">Gears for <span class="italic text-[#ED64A6]">Creators</span> & Explorers.</h2>
                <p class="text-gray-600 mb-10 leading-relaxed text-lg">Camplore hadir untuk memudahkan petualanganmu. Tidak perlu membeli alat mahal untuk sekali pakai. Kami menyediakan kamera mirrorless terbaru,
                    alat berkemah seperti tenda, sleeping bag, dan peralatan masak outdoor dengan kualitas terbaik.</p>

                <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                    @php $features = [
                    ['icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z', 'title' => 'Cine-Ready Cameras'],
                    ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', 'title' => 'Rugged Camping Kit'],
                    ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Fully Insured Gears'],
                    ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Express Delivery']
                    ]; @endphp

                    @foreach($features as $index => $feature)
                    <div class="flex items-center gap-4" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
                        <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-[#22543D]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}" />
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-800 text-sm">{{ $feature['title'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="catalog" class="py-24 bg-[#FFF5F7]">
        <div class="max-w-7xl mx-auto px-4 relative">

            <div class="text-center mb-16 max-w-2xl mx-auto" data-aos="fade-up">
                <span class="text-[#ED64A6] font-bold tracking-widest uppercase text-sm">Our Gear Library</span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-[#22543D] mt-2 tracking-tighter">Featured Adventures Kit</h2>
                <p class="text-gray-600 mt-5 leading-relaxed">Peralatan terpopuler yang siap menemani perjalananmu minggu ini.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

                @php $items = [
                ['cat' => 'Camera', 'name' => 'Canon R6', 'price' => 'Rp 250k/day', 'img' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&q=80'],
                ['cat' => 'Camping', 'name' => 'Ultralight Tent 2P', 'price' => 'Rp 100k/day', 'img' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&q=80'],
                ['cat' => 'Accessory', 'name' => 'Sony A7III', 'price' => 'Rp 300k/day', 'img' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?q=80&w=200'],
                ['cat' => 'Camping', 'name' => 'Portable Cooking Set', 'price' => 'Rp 60k/day', 'img' => 'https://plus.unsplash.com/premium_photo-1664360971368-8cf4df3deb53?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D']
                ]; @endphp

                @foreach($items as $index => $item)
                <div class="bg-white rounded-3xl p-5 shadow-sm hover:shadow-2xl transition-all duration-300 border border-pink-100 group" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
                    <div class="relative overflow-hidden rounded-2xl mb-5 bg-gray-100 aspect-[4/3] flex items-center justify-center">
                        <img src="{{ $item['img'] }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500">
                        <span class="absolute top-3 left-3 bg-[#22543D] text-white px-3 py-1 rounded-full text-xs font-medium">{{ $item['cat'] }}</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-800 leading-tight">{{ $item['name'] }}</h3>
                    <p class="text-[#ED64A6] font-extrabold mt-1 mb-5 text-xl">{{ $item['price'] }}</p>
                    <button class="w-full py-3 bg-[#22543D] text-white rounded-xl font-bold hover:bg-[#ED64A6] transition transform active:scale-95 shadow">Book Gear</button>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="faq" class="py-24 max-w-3xl mx-auto px-4 overflow-hidden">
        <h2 class="text-4xl font-extrabold text-center text-[#22543D] mb-16 tracking-tighter" data-aos="fade-up">Got Questions?</h2>
        <div class="space-y-5">

            @php $faqs = [
            ['q' => 'How does the rental process work?', 'a' => 'Pilih alat di website, isi form booking, unggah KTP. Alat bisa diambil di store kami atau dikirim ke lokasi Anda.'],
            ['q' => 'Is a deposit required?', 'a' => 'Ya, kami membutuhkan deposit berupa uang jaminan atau menahan kartu identitas asli (SIM/Paspor) selama masa sewa untuk item premium.'],
            ['q' => 'What if the gear gets damaged?', 'a' => 'Kami menyarankan penambahan asuransi sewa kecil di awal. Jika tidak berasuransi, penyewa bertanggung jawab penuh atas biaya perbaikan kerusakan alat.'],
            ['q' => 'Do you deliver to camp sites?', 'a' => 'Tentu! Kami melayani pengiriman ke area basecamp gunung atau pantai populer di wilayah operasional kami.']
            ]; @endphp

            @foreach($faqs as $index => $faq)
            <details class="group bg-white p-7 rounded-2xl shadow-sm border border-pink-50 cursor-pointer" {{ $index === 0 ? 'open' : '' }} data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <summary class="flex justify-between items-center font-bold text-lg text-[#22543D] list-none">
                    {{ $faq['q'] }}
                    <span class="transition group-open:rotate-180 text-[#ED64A6]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </summary>
                <p class="mt-5 text-gray-600 leading-relaxed text-base">{{ $faq['a'] }}</p>
            </details>
            @endforeach
        </div>
    </section>

    <footer class="bg-[#22543D] text-white pt-24 pb-12 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 relative">
            <div class="relative z-10 grid md:grid-cols-5 gap-12 mb-16">
                <div class="col-span-2 space-y-5">
                    <a href="#" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}"
                            alt="Camplore Logo"
                            class="h-10 w-auto object-contain transition-transform hover:scale-105">
                    </a>
                    <p class="text-emerald-200 text-sm leading-relaxed max-w-sm">
                        Capture Nature, Experience Freedom. Platform penyewaan Outdoor Gear paling terintegrasi di Indonesia.
                    </p>
                </div>

                @php $footerLinks = [
                ['title' => 'Gear', 'links' => ['Cameras', 'Tents']],
                ['title' => 'Company', 'links' => ['About Us', 'Careers', 'Policy', 'Contact']],
                ['title' => 'Support', 'links' => ['WhatsApp', 'FAQ', 'Store Location']]
                ]; @endphp

                @foreach($footerLinks as $section)
                <div>
                    <h4 class="font-bold mb-6 text-white text-lg tracking-tight">{{ $section['title'] }}</h4>
                    <ul class="space-y-3 text-emerald-200 text-sm">
                        @foreach($section['links'] as $link)
                        <li><a href="#" class="hover:text-[#ED64A6] transition">{{ $link }}</a></li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>

            <div class="border-t border-white/10 pt-10 text-center text-xs text-emerald-300 relative z-10">
                <p>&copy; 2026 Camplore Adventure Ltd. Batam, Indonesia. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800, // Durasi animasi standar (800ms)
            easing: 'ease-in-out', // Efek easing
            once: true, // Animasi hanya berjalan sekali saat di-scroll
        });
    </script>

</body>

</html>