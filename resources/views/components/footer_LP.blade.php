<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


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
                <div>
                    <h4 class="font-bold mb-5 text-white">Lokasi Kami</h4>
                    <div id="map-footer" class="rounded-xl overflow-hidden" style="height:130px;"></div>
                    <p class="text-emerald-200 text-xs mt-2">Politeknik Negeri Batam, Batam Kota</p>
                </div>  
            </div>
            <div class="border-t border-white/10 pt-8 text-center text-xs text-emerald-300">
                <p>&copy; 2026 Camplore Adventure Ltd. Batam, Indonesia. Seluruh hak dilindungi undang-undang.</p>
            </div>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapFooter = L.map('map-footer', { zoomControl: false, dragging: false, scrollWheelZoom: false })
            .setView([1.1187205, 104.0484566], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(mapFooter);

        const iconFooter = L.divIcon({
            html: `<div style="background:#ED64A6;width:12px;height:12px;border-radius:50%;border:2px solid white;box-shadow:0 2px 4px rgba(0,0,0,0.4)"></div>`,
            iconSize: [12, 12], iconAnchor: [6, 6], className: ''
        });
        L.marker([1.1187205, 104.0484566], { icon: iconFooter }).addTo(mapFooter);
    });
</script>