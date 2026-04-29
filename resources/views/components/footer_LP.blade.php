     <!-- ========== MAP SECTION ========== -->
<section class="py-8 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-4">
            <h2 class="text-3xl font-extrabold text-[#22543D] mb-2">Temukan Kami</h2>
            <p class="text-gray-500 text-sm">Kunjungi kami di Politeknik Negeri Batam, Kepulauan Riau</p>
        </div>

        <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-100" style="height: 220px;" id="map"></div>
        <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-4 text-sm text-gray-600">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-[#22543D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>429X+F9 Tlk. Tering, Politeknik Negeri Batam, Batam Kota, Kepulauan Riau</span>
            </div>
        </div>
    </div>
</section>
    
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const map = L.map('map').setView([1.1187205, 104.0484566], 17);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
        maxZoom: 19,
    }).addTo(map);

    const icon = L.divIcon({
        html: `<div style="background:#22543D;width:16px;height:16px;border-radius:50%;border:3px solid white;box-shadow:0 2px 6px rgba(0,0,0,0.4)"></div>`,
        iconSize: [16, 16],
        iconAnchor: [8, 8],
        className: ''
    });

    L.marker([1.1187205, 104.0484566], { icon })
        .addTo(map)
        .bindPopup(`
            <div style="font-family:'Plus Jakarta Sans',sans-serif;padding:4px">
                <strong style="color:#22543D">📍 Camplore</strong><br>
                <span style="font-size:12px;color:#555">Politeknik Negeri Batam<br>Batam Kota, Kepulauan Riau</span>
            </div>
        `)
        .openPopup();
</script>
    <!-- ========== FOOTER ========== -->
    <footer class="bg-[#22543D] text-white pt-20 pb-10 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-5 gap-12 mb-12">
                <div class="col-span-2 space-y-4">
                    <a href="#" class="flex items-center gap-2">
                        <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#22543D]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            </svg>
                        </div>
                        <span class="text-2xl font-extrabold">Camp<span class="text-[#ED64A6]">lore</span></span>
                    </a>
                    <p class="text-emerald-200 text-sm leading-relaxed max-w-sm">Setiap Momen Layak Diabadikan, Setiap Perjalanan Layak Dinikmati. Solusi sewa kamera dan perlengkapan camping dalam satu platform.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-5 text-white">Perlengkapan</h4>
                    <ul class="space-y-3 text-emerald-200 text-sm">
                        <li><a href="#" class="hover:text-[#ED64A6] transition">Kamera</a></li>
                        <li><a href="#" class="hover:text-[#ED64A6] transition">Camping</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold mb-5 text-white">Support</h4>
                    <ul class="space-y-3 text-emerald-200 text-sm">
                        <li><a href="#" class="hover:text-[#ED64A6] transition">Store Location</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10 pt-8 text-center text-xs text-emerald-300">
                <p>&copy; 2026 Camplore Adventure Ltd. Batam, Indonesia. Seluruh hak dilindungi undang-undang.</p>
            </div>
        </div>
    </footer>