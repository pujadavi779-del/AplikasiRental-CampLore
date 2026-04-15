<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        serif: ['DM Serif Display', 'serif'],
                    },
                    keyframes: {
                        fadeUp: {
                            from: {
                                opacity: '0',
                                transform: 'translateY(10px)'
                            },
                            to: {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        }
                    },
                    animation: {
                        'fade-up': 'fadeUp .4s ease both',
                        'fade-up-2': 'fadeUp .4s .07s ease both',
                        'fade-up-3': 'fadeUp .4s .14s ease both',
                        'fade-up-4': 'fadeUp .4s .21s ease both',
                    }
                }
            }
        }
    </script>
    <style>
        #map {
            height: 100%;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-white font-sans text-[#1a1a1a]">

    @include('sidebar_dashboard_admin')

    <div class="p-5 sm:ml-64 mt-14 min-h-screen">

        <!-- STAT CARDS -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">

            <!-- Card 1 - Olive -->
            <div class="p-4 rounded-xl animate-fade-up"
                style="background:#f7f8f0;border:.5px solid #d8da9a;">
                <p class="text-[11px] font-medium tracking-[.06em] uppercase mb-1.5"
                    style="color:#7a8040;">Total Rental Aktif</p>
                <p class="font-serif text-3xl" style="color:#3d4410;">40</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-[10px] font-medium px-2 py-0.5 rounded-full"
                        style="background:rgba(95,104,38,.12);color:#3d4410;border:.5px solid rgba(95,104,38,.3);">↑ 12% minggu ini</span>
                </div>
                <div class="h-1 rounded-full mt-3" style="background:#f0f0e8;">
                    <div class="h-full rounded-full" style="width:72%;background:linear-gradient(90deg,#5f6826,#9aa040);"></div>
                </div>
            </div>

            <!-- Card 2 - Rose -->
            <div class="p-4 rounded-xl animate-fade-up-2"
                style="background:#fef4f5;border:.5px solid #f0c0c8;">
                <p class="text-[11px] font-medium tracking-[.06em] uppercase mb-1.5"
                    style="color:#c07888;">Kamera Tersedia</p>
                <p class="font-serif text-3xl" style="color:#8a2035;">
                    23 <span class="text-[16px]" style="color:#c07888;">/ 35</span>
                </p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-[10px] font-medium px-2 py-0.5 rounded-full"
                        style="background:rgba(223,111,129,.12);color:#8a2035;border:.5px solid rgba(223,111,129,.3);">12 sedang disewa</span>
                </div>
                <div class="h-1 rounded-full mt-3" style="background:#f0f0e8;">
                    <div class="h-full rounded-full" style="width:66%;background:linear-gradient(90deg,#df6f81,#f0a0b0);"></div>
                </div>
            </div>

            <!-- Card 3 - Olive -->
            <div class="p-4 rounded-xl animate-fade-up-3"
                style="background:#f7f8f0;border:.5px solid #d8da9a;">
                <p class="text-[11px] font-medium tracking-[.06em] uppercase mb-1.5"
                    style="color:#7a8040;">Paket Camping Tersedia</p>
                <p class="font-serif text-3xl" style="color:#3d4410;">
                    17 <span class="text-[16px]" style="color:#7a8040;">/ 25</span>
                </p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-[10px] font-medium px-2 py-0.5 rounded-full"
                        style="background:rgba(60,100,200,.1);color:#1a3a80;border:.5px solid rgba(60,100,200,.2);">
                        8 sedang disewa
                    </span>
                </div>
                <div class="h-1 rounded-full mt-3" style="background:#f0f0e8;">
                    <div class="h-full rounded-full" style="width:68%;background:linear-gradient(90deg,#5f6826,#9aa040);"></div>
                </div>
            </div>

            <!-- Card 4 - Rose -->
            <!-- Card 4 - Warning Red -->
            <div class="p-4 rounded-xl animate-fade-up-4"
                style="background:#fff5f5;border:.5px solid #f5b5b5;">

                <p class="text-[11px] font-medium tracking-[.06em] uppercase mb-1.5"
                    style="color:#dc2626;">Rental Overdue</p>

                <p class="font-serif text-3xl" style="color:#991b1b;">
                    6
                </p>

                <div class="flex items-center gap-2 mt-2">
                    <span class="text-[10px] font-medium px-2 py-0.5 rounded-full"
                        style="background:rgba(220,38,38,.08);color:#b91c1c;border:.5px solid rgba(220,38,38,.2);">
                        belum dikembalikan
                    </span>
                </div>

                <div class="h-1 rounded-full mt-3" style="background:#fee2e2;">
                    <div class="h-full rounded-full" style="width:24%;background:linear-gradient(90deg,#dc2626,#ef4444);"></div>
                </div>
            </div>
        </div>

        <!-- MAIN GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-5">

            <!-- Chart -->
            <div class="bg-white rounded-xl p-5 lg:col-span-3"
                style="border:.5px solid #e8e8e0;">
                <div class="flex items-center justify-between mb-4">
                    <p class="font-serif text-[16px] text-[#1a1a1a]">Tren Rental Mingguan</p>
                    <div class="flex gap-2">
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full"
                            style="background:rgba(95,104,38,.12);color:#3d4410;border:.5px solid rgba(95,104,38,.3);">Kamera</span>
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full"
                            style="background:rgba(223,111,129,.12);color:#8a2035;border:.5px solid rgba(223,111,129,.3);">Camping</span>
                    </div>
                </div>
                <canvas id="rentalChart" height="180"></canvas>
            </div>

            <!-- Map -->
            <div class="bg-white rounded-xl p-3 lg:col-span-2"
                style="border:.5px solid #e8e8e0;min-height:280px;">
                <p class="font-serif text-[16px] text-[#1a1a1a] px-2 mb-[14px]">Lokasi Camping Aktif</p>
                <div style="height:220px;">
                    <div id="map"></div>
                </div>
            </div>
        </div>

        <!-- BOTTOM GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            <!-- Transaksi Terbaru -->
            <div class="bg-white rounded-xl p-5 lg:col-span-2"
                style="border:.5px solid #e8e8e0;">
                <p class="font-serif text-[16px] text-[#1a1a1a] mb-[14px]">Transaksi Terbaru</p>

                <!-- Table Header -->
                <div class="grid gap-2 items-center px-3 pb-2 text-[11px] font-medium tracking-[.06em] uppercase text-[#999]"
                    style="grid-template-columns:2fr 1fr 1fr 1fr;border-bottom:.5px solid #f0f0e8;">
                    <span>Pelanggan</span><span>Item</span><span>Tgl Kembali</span><span>Status</span>
                </div>

                <!-- Rows -->
                @php
                $rows = [
                ['RS','Rizky Saputra','+62 812-xxx','Sony A7III','18 Mar','olive','Aktif'],
                ['NA','Nadia Aulia','+62 857-xxx','Camping Kit L','20 Mar','blue','Reservasi'],
                ['DP','Doni Pratama','+62 878-xxx','Canon EOS R5','16 Mar !','red','Terlambat'],
                ['SW','Sari Wulandari','+62 821-xxx','Drone DJI Mini','22 Mar','amber','Proses'],
                ['FH','Farhan Hidayat','+62 895-xxx','Camping Kit M','25 Mar','olive','Aktif'],
                ];
                $tagStyles = [
                'olive' => 'background:rgba(95,104,38,.12);color:#3d4410;border:.5px solid rgba(95,104,38,.3);',
                'blue' => 'background:rgba(60,100,200,.1);color:#1a3a80;border:.5px solid rgba(60,100,200,.2);',
                'red' => 'background:rgba(200,60,60,.1);color:#7a1818;border:.5px solid rgba(200,60,60,.25);',
                'amber' => 'background:rgba(200,140,60,.12);color:#7a4a10;border:.5px solid rgba(200,140,60,.3);',
                'rose' => 'background:rgba(223,111,129,.12);color:#8a2035;border:.5px solid rgba(223,111,129,.3);',
                ];
                $avatarStyles = [
                'olive' => 'background:#f7f8f0;border:1px solid #d8da9a;color:#5f6826;',
                'blue' => 'background:#fef4f5;border:1px solid #f0c0c8;color:#df6f81;',
                'red' => 'background:#fef4f5;border:1px solid #f0c0c8;color:#df6f81;',
                'amber' => 'background:#f7f8f0;border:1px solid #d8da9a;color:#5f6826;',
                'rose' => 'background:#fef4f5;border:1px solid #f0c0c8;color:#df6f81;',
                ];
                @endphp

                @foreach($rows as $row)
                <div class="grid gap-2 items-center px-3 py-2.5 rounded-lg text-[13px] hover:bg-[#fafaf5] transition-colors"
                    style="grid-template-columns:2fr 1fr 1fr 1fr;border-bottom:.5px solid #f0f0e8;">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-[11px] font-semibold flex-shrink-0"
                            style="{{ $avatarStyles[$row[5]] }}">{{ $row[0] }}</div>
                        <div>
                            <p class="text-[13px] leading-tight">{{ $row[1] }}</p>
                            <p class="text-[11px] text-[#999] leading-tight">{{ $row[2] }}</p>
                        </div>
                    </div>
                    <span class="text-[#555]">{{ $row[3] }}</span>
                    <span class="{{ $row[5] === 'red' ? 'text-[#df6f81]' : 'text-[#555]' }}">{{ $row[4] }}</span>
                    <span class="text-[10px] font-medium px-2 py-0.5 rounded-full w-fit"
                        style="{{ $tagStyles[$row[5]] }}">{{ $row[6] }}</span>
                </div>
                @endforeach
            </div>

            <!-- Item Terpopuler -->
            <div class="bg-white rounded-xl p-5"
                style="border:.5px solid #e8e8e0;">
                <p class="font-serif text-[16px] text-[#1a1a1a] mb-[14px]">Item Terpopuler</p>
                <div class="flex flex-col gap-4">

                    @php
                    $items = [
                    ['Sony A7 III', '38 rental', 92, 'olive'],
                    ['Camping Kit L', '31 rental', 75, 'rose'],
                    ['Canon EOS R5', '27 rental', 65, 'olive'],
                    ['Drone DJI Mini 4','22 rental', 53, 'rose'],
                    ['Tenda Dome 4P', '19 rental', 46, 'olive'],
                    ['Sleeping Bag -5°','14 rental', 34, 'rose'],
                    ];
                    @endphp

                    @foreach($items as [$name, $count, $pct, $color])
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-[13px]">{{ $name }}</span>
                            <span class="text-[12px]"
                                style="color:{{ $color === 'olive' ? '#5f6826' : '#df6f81' }};">{{ $count }}</span>
                        </div>
                        <div class="h-1 rounded-full" style="background:#f0f0e8;">
                            <div class="h-full rounded-full"
                                style="width:{{ $pct }}%;background:{{ $color === 'olive'
                                ? 'linear-gradient(90deg,#5f6826,#9aa040)'
                                : 'linear-gradient(90deg,#df6f81,#f0a0b0)' }};"></div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('rentalChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                        label: 'Kamera',
                        data: [8, 12, 7, 15, 10, 18, 14],
                        backgroundColor: 'rgba(95,104,38,0.2)',
                        borderColor: '#5f6826',
                        borderWidth: 1,
                        borderRadius: 5
                    },
                    {
                        label: 'Camping',
                        data: [4, 6, 9, 5, 11, 16, 12],
                        backgroundColor: 'rgba(223,111,129,0.2)',
                        borderColor: '#df6f81',
                        borderWidth: 1,
                        borderRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: '#f5f5f0'
                        },
                        ticks: {
                            color: '#999',
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: '#f5f5f0'
                        },
                        ticks: {
                            color: '#999',
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });

        const map = L.map('map', {
            zoomControl: false
        }).setView([-2.5, 117.5], 4);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap',
            maxZoom: 18
        }).addTo(map);
        const mkOlive = L.divIcon({
            html: `<div style="width:10px;height:10px;border-radius:50%;background:#5f6826;border:2px solid #fff;"></div>`,
            className: '',
            iconAnchor: [5, 5]
        });
        const mkRose = L.divIcon({
            html: `<div style="width:10px;height:10px;border-radius:50%;background:#df6f81;border:2px solid #fff;"></div>`,
            className: '',
            iconAnchor: [5, 5]
        });
        [
            [-6.917, 107.619, 'Lembang', 0],
            [-7.519, 110.207, 'Boyolali', 1],
            [-8.340, 115.507, 'Bali', 0],
            [-5.271, 104.069, 'Lampung', 1],
            [-3.862, 102.314, 'Sumsel', 0],
            [-0.943, 100.418, 'Sumbar', 1]
        ]
        .forEach(([lat, lng, name, r]) => L.marker([lat, lng], {
            icon: r ? mkRose : mkOlive
        }).addTo(map).bindPopup(`<b>${name}</b>`));
    </script>
</body>

</html>