<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        body { background:#0e1a06; font-family:'DM Sans',sans-serif; }
        .card { background:rgba(255,255,255,0.03); border:.5px solid rgba(106,170,42,0.18); border-radius:12px; }
        .card-dark { background:rgba(6,10,3,0.6); border:.5px solid rgba(106,170,42,0.12); border-radius:12px; }
        .stat-val { font-family:'DM Serif Display',serif; color:#d4f0a0; }
        .tag { font-size:10px; font-weight:500; padding:2px 8px; border-radius:99px; }
        .tag-green { background:rgba(106,170,42,.15); color:#8acc44; border:.5px solid rgba(106,170,42,.3); }
        .tag-amber { background:rgba(186,117,23,.2); color:#f0a840; border:.5px solid rgba(186,117,23,.3); }
        .tag-red   { background:rgba(180,50,50,.2);  color:#f08070; border:.5px solid rgba(180,50,50,.3); }
        .tag-blue  { background:rgba(60,130,200,.15);color:#70b8f0; border:.5px solid rgba(60,130,200,.25); }
        #map { height:100%; border-radius:11px; z-index:0; }
        .leaflet-container { background:#0f1f07 !important; }
        .section-title { font-family:'DM Serif Display',serif; font-size:16px; color:#d4f0a0; margin-bottom:14px; }
        .trow { display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:8px; align-items:center; padding:10px 12px; border-radius:8px; font-size:13px; }
        .trow:hover { background:rgba(106,170,42,0.06); }
        .tbody .trow { border-bottom:.5px solid rgba(106,170,42,0.08); }
        .tbody .trow:last-child { border-bottom:none; }
        .prog-bar { height:4px; border-radius:99px; background:rgba(106,170,42,0.12); overflow:hidden; }
        .prog-fill { height:100%; border-radius:99px; background:linear-gradient(90deg,#5a9a20,#8acc44); }
        @keyframes fadeUp { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
        .fade-up { animation: fadeUp .4s ease both; }
        .fade-up:nth-child(2){animation-delay:.07s} .fade-up:nth-child(3){animation-delay:.14s} .fade-up:nth-child(4){animation-delay:.21s}
    </style>
</head>
<body>

@include('sidebar_dashboard_admin')

<div class="p-5 sm:ml-64 mt-14 min-h-screen">

    {{-- ── STAT CARDS ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">

        <div class="card p-4 fade-up">
            <p style="font-size:11px;color:#6a8a50;letter-spacing:.06em;text-transform:uppercase;margin-bottom:6px">Total Rental Aktif</p>
            <p class="stat-val text-3xl">48</p>
            <div class="flex items-center gap-2 mt-2">
                <span class="tag tag-green">↑ 12% minggu ini</span>
            </div>
            <div class="prog-bar mt-3"><div class="prog-fill" style="width:72%"></div></div>
        </div>

        <div class="card p-4 fade-up">
            <p style="font-size:11px;color:#6a8a50;letter-spacing:.06em;text-transform:uppercase;margin-bottom:6px">Kamera Tersedia</p>
            <p class="stat-val text-3xl">23 <span style="font-size:16px;color:#6a8a50">/ 35</span></p>
            <div class="flex items-center gap-2 mt-2">
                <span class="tag tag-amber">12 sedang disewa</span>
            </div>
            <div class="prog-bar mt-3"><div class="prog-fill" style="width:66%"></div></div>
        </div>

        <div class="card p-4 fade-up">
            <p style="font-size:11px;color:#6a8a50;letter-spacing:.06em;text-transform:uppercase;margin-bottom:6px">Paket Camping</p>
            <p class="stat-val text-3xl">17</p>
            <div class="flex items-center gap-2 mt-2">
                <span class="tag tag-blue">5 reservasi baru</span>
            </div>
            <div class="prog-bar mt-3"><div class="prog-fill" style="width:45%"></div></div>
        </div>

        <div class="card p-4 fade-up">
            <p style="font-size:11px;color:#6a8a50;letter-spacing:.06em;text-transform:uppercase;margin-bottom:6px">Pendapatan Bulan Ini</p>
            <p class="stat-val text-3xl">Rp 18,4<span style="font-size:16px">jt</span></p>
            <div class="flex items-center gap-2 mt-2">
                <span class="tag tag-green">↑ 8% vs bulan lalu</span>
            </div>
            <div class="prog-bar mt-3"><div class="prog-fill" style="width:84%"></div></div>
        </div>

    </div>

    {{-- ── MAIN GRID: Chart + Map ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-5">

        {{-- Rental Chart --}}
        <div class="card p-5 lg:col-span-3">
            <div class="flex items-center justify-between mb-4">
                <p class="section-title mb-0">Tren Rental Mingguan</p>
                <div class="flex gap-2">
                    <span class="tag tag-green">Kamera</span>
                    <span class="tag tag-blue">Camping</span>
                </div>
            </div>
            <canvas id="rentalChart" height="180"></canvas>
        </div>

        {{-- Map --}}
        <div class="card p-3 lg:col-span-2" style="min-height:280px">
            <p class="section-title px-2">Lokasi Camping Aktif</p>
            <div style="height:220px">
                <div id="map"></div>
            </div>
        </div>

    </div>

    {{-- ── BOTTOM GRID: Recent Orders + Top Items ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Recent Orders --}}
        <div class="card p-5 lg:col-span-2">
            <p class="section-title">Pesanan Terbaru</p>
            <div class="trow" style="font-size:11px;color:#6a8a50;font-weight:500;letter-spacing:.06em;text-transform:uppercase;padding-bottom:8px;border-bottom:.5px solid rgba(106,170,42,0.15)">
                <span>Pelanggan</span><span>Item</span><span>Tgl Kembali</span><span>Status</span>
            </div>
            <div class="tbody">
                <div class="trow">
                    <div class="flex items-center gap-2">
                        <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#4a7a1a,#2d5010);display:flex;align-items:center;justify-content:center;font-size:11px;color:#c4e890;flex-shrink:0">RS</div>
                        <div><p style="color:#c8e898;font-size:13px">Rizky Saputra</p><p style="color:#6a8a50;font-size:11px">+62 812-xxx</p></div>
                    </div>
                    <span style="color:#a8c880">Sony A7III</span>
                    <span style="color:#a8c880">18 Mar</span>
                    <span class="tag tag-green">Aktif</span>
                </div>
                <div class="trow">
                    <div class="flex items-center gap-2">
                        <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#4a6a8a,#1a3050);display:flex;align-items:center;justify-content:center;font-size:11px;color:#90c0e8;flex-shrink:0">NA</div>
                        <div><p style="color:#c8e898;font-size:13px">Nadia Aulia</p><p style="color:#6a8a50;font-size:11px">+62 857-xxx</p></div>
                    </div>
                    <span style="color:#a8c880">Camping Kit L</span>
                    <span style="color:#a8c880">20 Mar</span>
                    <span class="tag tag-blue">Reservasi</span>
                </div>
                <div class="trow">
                    <div class="flex items-center gap-2">
                        <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#8a4a1a,#502010);display:flex;align-items:center;justify-content:center;font-size:11px;color:#e8b090;flex-shrink:0">DP</div>
                        <div><p style="color:#c8e898;font-size:13px">Doni Pratama</p><p style="color:#6a8a50;font-size:11px">+62 878-xxx</p></div>
                    </div>
                    <span style="color:#a8c880">Canon EOS R5</span>
                    <span style="color:#f08070">16 Mar !</span>
                    <span class="tag tag-red">Terlambat</span>
                </div>
                <div class="trow">
                    <div class="flex items-center gap-2">
                        <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#5a4a8a,#302050);display:flex;align-items:center;justify-content:center;font-size:11px;color:#c0b0e8;flex-shrink:0">SW</div>
                        <div><p style="color:#c8e898;font-size:13px">Sari Wulandari</p><p style="color:#6a8a50;font-size:11px">+62 821-xxx</p></div>
                    </div>
                    <span style="color:#a8c880">Drone DJI Mini</span>
                    <span style="color:#a8c880">22 Mar</span>
                    <span class="tag tag-amber">Proses</span>
                </div>
                <div class="trow">
                    <div class="flex items-center gap-2">
                        <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#3a7a5a,#1a4030);display:flex;align-items:center;justify-content:center;font-size:11px;color:#90e0b8;flex-shrink:0">FH</div>
                        <div><p style="color:#c8e898;font-size:13px">Farhan Hidayat</p><p style="color:#6a8a50;font-size:11px">+62 895-xxx</p></div>
                    </div>
                    <span style="color:#a8c880">Camping Kit M</span>
                    <span style="color:#a8c880">25 Mar</span>
                    <span class="tag tag-green">Aktif</span>
                </div>
            </div>
        </div>

        {{-- Top Items --}}
        <div class="card p-5">
            <p class="section-title">Item Terpopuler</p>
            <div class="flex flex-col gap-4">
                <div>
                    <div class="flex justify-between mb-1">
                        <span style="font-size:13px;color:#c8e898">Sony A7 III</span>
                        <span style="font-size:12px;color:#8acc44">38 rental</span>
                    </div>
                    <div class="prog-bar"><div class="prog-fill" style="width:92%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span style="font-size:13px;color:#c8e898">Camping Kit L</span>
                        <span style="font-size:12px;color:#8acc44">31 rental</span>
                    </div>
                    <div class="prog-bar"><div class="prog-fill" style="width:75%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span style="font-size:13px;color:#c8e898">Canon EOS R5</span>
                        <span style="font-size:12px;color:#8acc44">27 rental</span>
                    </div>
                    <div class="prog-bar"><div class="prog-fill" style="width:65%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span style="font-size:13px;color:#c8e898">Drone DJI Mini 4</span>
                        <span style="font-size:12px;color:#8acc44">22 rental</span>
                    </div>
                    <div class="prog-bar"><div class="prog-fill" style="width:53%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span style="font-size:13px;color:#c8e898">Tenda Dome 4P</span>
                        <span style="font-size:12px;color:#8acc44">19 rental</span>
                    </div>
                    <div class="prog-bar"><div class="prog-fill" style="width:46%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span style="font-size:13px;color:#c8e898">Sleeping Bag -5°</span>
                        <span style="font-size:12px;color:#8acc44">14 rental</span>
                    </div>
                    <div class="prog-bar"><div class="prog-fill" style="width:34%"></div></div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ── Chart ──
const ctx = document.getElementById('rentalChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Sen','Sel','Rab','Kam','Jum','Sab','Min'],
        datasets: [
            {
                label: 'Kamera',
                data: [8,12,7,15,10,18,14],
                backgroundColor: 'rgba(106,170,42,0.55)',
                borderColor: '#6aaa2a',
                borderWidth: 1,
                borderRadius: 5,
            },
            {
                label: 'Camping',
                data: [4,6,9,5,11,16,12],
                backgroundColor: 'rgba(60,130,200,0.4)',
                borderColor: '#3c82c8',
                borderWidth: 1,
                borderRadius: 5,
            }
        ]
    },
    options: {
        responsive: true, maintainAspectRatio: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color:'rgba(106,170,42,0.06)' }, ticks: { color:'#6a8a50', font:{size:12} } },
            y: { grid: { color:'rgba(106,170,42,0.06)' }, ticks: { color:'#6a8a50', font:{size:12} } }
        }
    }
});

// ── Map (Leaflet + OpenStreetMap) ──
const map = L.map('map', { zoomControl: false }).setView([-2.5, 117.5], 4);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap', maxZoom: 18
}).addTo(map);

const icon = L.divIcon({
    html: `<div style="width:12px;height:12px;border-radius:50%;background:#6aaa2a;border:2px solid #d4f0a0;box-shadow:0 0 8px #6aaa2a88"></div>`,
    className: '', iconAnchor: [6,6]
});

const spots = [
    [-6.917, 107.619, 'Lembang, Bandung'],
    [-7.519, 110.207, 'Selo, Boyolali'],
    [-8.340, 115.507, 'Bedugul, Bali'],
    [-5.271, 104.069, 'Gunung Pesagi, Lampung'],
    [-3.862, 102.314, 'Gunung Dempo, Sumsel'],
    [-0.943, 100.418, 'Gunung Marapi, Sumbar'],
];
spots.forEach(([lat, lng, name]) => {
    L.marker([lat, lng], {icon}).addTo(map)
     .bindPopup(`<b style="color:#1a3a06">${name}</b>`, {className:'camp-popup'});
});
</script>
</body>
</html>