<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        body { background:#fff; font-family:'DM Sans',sans-serif; color:#1a1a1a; }

        .card { background:#fff; border:.5px solid #e8e8e0; border-radius:12px; }
        .card-olive { background:#f7f8f0; border:.5px solid #d8da9a; border-radius:12px; }
        .card-rose  { background:#fef4f5; border:.5px solid #f0c0c8; border-radius:12px; }

        .stat-val { font-family:'DM Serif Display',serif; }
        .section-title { font-family:'DM Serif Display',serif; font-size:16px; color:#1a1a1a; margin-bottom:14px; }

        .tag { font-size:10px; font-weight:500; padding:2px 8px; border-radius:99px; }
        .tag-olive { background:rgba(95,104,38,.12); color:#3d4410; border:.5px solid rgba(95,104,38,.3); }
        .tag-rose  { background:rgba(223,111,129,.12); color:#8a2035; border:.5px solid rgba(223,111,129,.3); }
        .tag-amber { background:rgba(200,140,60,.12); color:#7a4a10; border:.5px solid rgba(200,140,60,.3); }
        .tag-blue  { background:rgba(60,100,200,.1);  color:#1a3a80; border:.5px solid rgba(60,100,200,.2); }
        .tag-red   { background:rgba(200,60,60,.1);   color:#7a1818; border:.5px solid rgba(200,60,60,.25); }

        .prog-bar  { height:4px; border-radius:99px; background:#f0f0e8; overflow:hidden; }
        .fill-olive{ height:100%; border-radius:99px; background:linear-gradient(90deg,#5f6826,#9aa040); }
        .fill-rose { height:100%; border-radius:99px; background:linear-gradient(90deg,#df6f81,#f0a0b0); }

        .trow { display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:8px; align-items:center; padding:10px 12px; border-radius:8px; font-size:13px; }
        .trow:hover { background:#fafaf5; }
        .tbody .trow { border-bottom:.5px solid #f0f0e8; }
        .tbody .trow:last-child { border-bottom:none; }

        #map { height:100%; border-radius:10px; }

        @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
        .fade-up { animation:fadeUp .4s ease both; }
        .fade-up:nth-child(2){animation-delay:.07s}
        .fade-up:nth-child(3){animation-delay:.14s}
        .fade-up:nth-child(4){animation-delay:.21s}
    </style>
</head>
<body>

@include('sidebar_dashboard_admin')

<!-- NAVBAR -->
<nav class="fixed top-0 z-50 sm:ml-64" style="width:calc(100% - 16rem);background:#fff;border-bottom:.5px solid #e8e8e0;">
    <div class="px-5 py-3 flex items-center justify-between gap-4">
        <div>
            <h1 style="font-family:'DM Serif Display',serif;font-size:20px;">Selamat Datang, Admin</h1>
            <p style="font-size:11.5px;color:#999;">CampLore › <span style="color:#df6f81;">Dashboard</span></p>
        </div>
        <div class="flex items-center gap-3">
            <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-lg" style="background:#f7f8f0;border:.5px solid #d8da9a;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9aa040" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" placeholder="Search..." style="background:transparent;border:none;outline:none;font-size:13px;color:#1a1a1a;width:140px;" />
            </div>
            <button style="position:relative;width:36px;height:36px;border-radius:8px;border:.5px solid #e8e8e0;background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <span style="position:absolute;top:6px;right:6px;width:7px;height:7px;border-radius:50%;background:#df6f81;border:1.5px solid #fff;"></span>
            </button>
            <button style="display:flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:13px;font-weight:500;background:#5f6826;color:#fff;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                Tambah
            </button>
        </div>
    </div>
</nav>

<div class="p-5 sm:ml-64 mt-14 min-h-screen">

    <!-- STAT CARDS — alternating olive & rose -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
        <div class="card-olive p-4 fade-up">
            <p style="font-size:11px;color:#7a8040;letter-spacing:.06em;text-transform:uppercase;margin-bottom:6px">Total Rental Aktif</p>
            <p class="stat-val text-3xl" style="color:#3d4410;">48</p>
            <div class="flex items-center gap-2 mt-2"><span class="tag tag-olive">↑ 12% minggu ini</span></div>
            <div class="prog-bar mt-3"><div class="fill-olive" style="width:72%"></div></div>
        </div>
        <div class="card-rose p-4 fade-up">
            <p style="font-size:11px;color:#c07888;letter-spacing:.06em;text-transform:uppercase;margin-bottom:6px">Kamera Tersedia</p>
            <p class="stat-val text-3xl" style="color:#8a2035;">23 <span style="font-size:16px;color:#c07888">/ 35</span></p>
            <div class="flex items-center gap-2 mt-2"><span class="tag tag-rose">12 sedang disewa</span></div>
            <div class="prog-bar mt-3"><div class="fill-rose" style="width:66%"></div></div>
        </div>
        <div class="card-olive p-4 fade-up">
            <p style="font-size:11px;color:#7a8040;letter-spacing:.06em;text-transform:uppercase;margin-bottom:6px">Paket Camping</p>
            <p class="stat-val text-3xl" style="color:#3d4410;">17</p>
            <div class="flex items-center gap-2 mt-2"><span class="tag tag-blue">5 reservasi baru</span></div>
            <div class="prog-bar mt-3"><div class="fill-olive" style="width:45%"></div></div>
        </div>
        <div class="card-rose p-4 fade-up">
            <p style="font-size:11px;color:#c07888;letter-spacing:.06em;text-transform:uppercase;margin-bottom:6px">Pendapatan Bulan Ini</p>
            <p class="stat-val text-3xl" style="color:#8a2035;">Rp 18,4<span style="font-size:16px">jt</span></p>
            <div class="flex items-center gap-2 mt-2"><span class="tag tag-rose">↑ 8% vs bulan lalu</span></div>
            <div class="prog-bar mt-3"><div class="fill-rose" style="width:84%"></div></div>
        </div>
    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-5">
        <div class="card p-5 lg:col-span-3">
            <div class="flex items-center justify-between mb-4">
                <p class="section-title mb-0">Tren Rental Mingguan</p>
                <div class="flex gap-2">
                    <span class="tag tag-olive">Kamera</span>
                    <span class="tag tag-rose">Camping</span>
                </div>
            </div>
            <canvas id="rentalChart" height="180"></canvas>
        </div>
        <div class="card p-3 lg:col-span-2" style="min-height:280px">
            <p class="section-title px-2">Lokasi Camping Aktif</p>
            <div style="height:220px"><div id="map"></div></div>
        </div>
    </div>

    <!-- BOTTOM GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="card p-5 lg:col-span-2">
            <p class="section-title">Pesanan Terbaru</p>
            <div class="trow" style="font-size:11px;color:#999;font-weight:500;letter-spacing:.06em;text-transform:uppercase;padding-bottom:8px;border-bottom:.5px solid #f0f0e8;">
                <span>Pelanggan</span><span>Item</span><span>Tgl Kembali</span><span>Status</span>
            </div>
            <div class="tbody">
                <div class="trow">
                    <div class="flex items-center gap-2">
                        <div style="width:28px;height:28px;border-radius:50%;background:#f7f8f0;border:1px solid #d8da9a;display:flex;align-items:center;justify-content:center;font-size:11px;color:#5f6826;font-weight:600;">RS</div>
                        <div><p style="font-size:13px">Rizky Saputra</p><p style="color:#999;font-size:11px">+62 812-xxx</p></div>
                    </div>
                    <span style="color:#555">Sony A7III</span><span style="color:#555">18 Mar</span>
                    <span class="tag tag-olive">Aktif</span>
                </div>
                <div class="trow">
                    <div class="flex items-center gap-2">
                        <div style="width:28px;height:28px;border-radius:50%;background:#fef4f5;border:1px solid #f0c0c8;display:flex;align-items:center;justify-content:center;font-size:11px;color:#df6f81;font-weight:600;">NA</div>
                        <div><p style="font-size:13px">Nadia Aulia</p><p style="color:#999;font-size:11px">+62 857-xxx</p></div>
                    </div>
                    <span style="color:#555">Camping Kit L</span><span style="color:#555">20 Mar</span>
                    <span class="tag tag-blue">Reservasi</span>
                </div>
                <div class="trow">
                    <div class="flex items-center gap-2">
                        <div style="width:28px;height:28px;border-radius:50%;background:#fef4f5;border:1px solid #f0c0c8;display:flex;align-items:center;justify-content:center;font-size:11px;color:#df6f81;font-weight:600;">DP</div>
                        <div><p style="font-size:13px">Doni Pratama</p><p style="color:#999;font-size:11px">+62 878-xxx</p></div>
                    </div>
                    <span style="color:#555">Canon EOS R5</span><span style="color:#df6f81">16 Mar !</span>
                    <span class="tag tag-red">Terlambat</span>
                </div>
                <div class="trow">
                    <div class="flex items-center gap-2">
                        <div style="width:28px;height:28px;border-radius:50%;background:#f7f8f0;border:1px solid #d8da9a;display:flex;align-items:center;justify-content:center;font-size:11px;color:#5f6826;font-weight:600;">SW</div>
                        <div><p style="font-size:13px">Sari Wulandari</p><p style="color:#999;font-size:11px">+62 821-xxx</p></div>
                    </div>
                    <span style="color:#555">Drone DJI Mini</span><span style="color:#555">22 Mar</span>
                    <span class="tag tag-amber">Proses</span>
                </div>
                <div class="trow">
                    <div class="flex items-center gap-2">
                        <div style="width:28px;height:28px;border-radius:50%;background:#f7f8f0;border:1px solid #d8da9a;display:flex;align-items:center;justify-content:center;font-size:11px;color:#5f6826;font-weight:600;">FH</div>
                        <div><p style="font-size:13px">Farhan Hidayat</p><p style="color:#999;font-size:11px">+62 895-xxx</p></div>
                    </div>
                    <span style="color:#555">Camping Kit M</span><span style="color:#555">25 Mar</span>
                    <span class="tag tag-olive">Aktif</span>
                </div>
            </div>
        </div>

        <div class="card p-5">
            <p class="section-title">Item Terpopuler</p>
            <div class="flex flex-col gap-4">
                <div>
                    <div class="flex justify-between mb-1"><span style="font-size:13px">Sony A7 III</span><span style="font-size:12px;color:#5f6826">38 rental</span></div>
                    <div class="prog-bar"><div class="fill-olive" style="width:92%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between mb-1"><span style="font-size:13px">Camping Kit L</span><span style="font-size:12px;color:#df6f81">31 rental</span></div>
                    <div class="prog-bar"><div class="fill-rose" style="width:75%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between mb-1"><span style="font-size:13px">Canon EOS R5</span><span style="font-size:12px;color:#5f6826">27 rental</span></div>
                    <div class="prog-bar"><div class="fill-olive" style="width:65%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between mb-1"><span style="font-size:13px">Drone DJI Mini 4</span><span style="font-size:12px;color:#df6f81">22 rental</span></div>
                    <div class="prog-bar"><div class="fill-rose" style="width:53%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between mb-1"><span style="font-size:13px">Tenda Dome 4P</span><span style="font-size:12px;color:#5f6826">19 rental</span></div>
                    <div class="prog-bar"><div class="fill-olive" style="width:46%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between mb-1"><span style="font-size:13px">Sleeping Bag -5°</span><span style="font-size:12px;color:#df6f81">14 rental</span></div>
                    <div class="prog-bar"><div class="fill-rose" style="width:34%"></div></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('rentalChart').getContext('2d'),{
    type:'bar',
    data:{
        labels:['Sen','Sel','Rab','Kam','Jum','Sab','Min'],
        datasets:[
            {label:'Kamera',data:[8,12,7,15,10,18,14],backgroundColor:'rgba(95,104,38,0.2)',borderColor:'#5f6826',borderWidth:1,borderRadius:5},
            {label:'Camping',data:[4,6,9,5,11,16,12],backgroundColor:'rgba(223,111,129,0.2)',borderColor:'#df6f81',borderWidth:1,borderRadius:5}
        ]
    },
    options:{
        responsive:true,maintainAspectRatio:true,
        plugins:{legend:{display:false}},
        scales:{
            x:{grid:{color:'#f5f5f0'},ticks:{color:'#999',font:{size:12}}},
            y:{grid:{color:'#f5f5f0'},ticks:{color:'#999',font:{size:12}}}
        }
    }
});

const map=L.map('map',{zoomControl:false}).setView([-2.5,117.5],4);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap',maxZoom:18}).addTo(map);
const mkOlive=L.divIcon({html:`<div style="width:10px;height:10px;border-radius:50%;background:#5f6826;border:2px solid #fff;"></div>`,className:'',iconAnchor:[5,5]});
const mkRose =L.divIcon({html:`<div style="width:10px;height:10px;border-radius:50%;background:#df6f81;border:2px solid #fff;"></div>`,className:'',iconAnchor:[5,5]});
[[-6.917,107.619,'Lembang',0],[-7.519,110.207,'Boyolali',1],[-8.340,115.507,'Bali',0],[-5.271,104.069,'Lampung',1],[-3.862,102.314,'Sumsel',0],[-0.943,100.418,'Sumbar',1]]
.forEach(([lat,lng,name,r])=>L.marker([lat,lng],{icon:r?mkRose:mkOlive}).addTo(map).bindPopup(`<b>${name}</b>`));
</script>
</body>
</html>