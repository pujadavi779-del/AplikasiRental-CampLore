@extends('admin.admin')
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CampLore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
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
            z-index: 1;
        }
    </style>
</head>

<body class="bg-white font-sans text-[#1a1a1a] antialiased">


    <main class="sm:ml-[272px] min-h-screen pt-32 pb-10 px-6 transition-all duration-300">

        <div class="fixed top-5 right-6 z-40 left-[calc(272px+24px)] max-sm:left-6 animate-fade-up">
            @include('admin.navbar', [
            'NavParent' => 'Managemen Operasional',
            'section' => 'Beranda'
            ])
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="p-5 rounded-2xl animate-fade-up" style="background:#f7f8f0; border:1px solid #d8da9a;">
                <p class="text-[11px] font-bold tracking-widest uppercase mb-2 text-[#7a8040]">Total Rental Aktif</p>
                <p class="font-serif text-4xl text-[#3d4410]">40</p>
                <div class="flex items-center gap-2 mt-3">
                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-[#5f6826]/10 text-[#3d4410] border border-[#5f6826]/20">↑ 12% minggu ini</span>
                </div>
            </div>

            <div class="p-5 rounded-2xl animate-fade-up-2" style="background:#fef4f5; border:1px solid #f0c0c8;">
                <p class="text-[11px] font-bold tracking-widest uppercase mb-2 text-[#c07888]">Kamera Tersedia</p>
                <p class="font-serif text-4xl text-[#8a2035]">23 <span class="text-lg text-[#c07888]">/ 35</span></p>
                <div class="flex items-center gap-2 mt-3">
                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-[#df6f81]/10 text-[#8a2035] border border-[#df6f81]/20">12 sedang disewa</span>
                </div>
            </div>

            <div class="p-5 rounded-2xl animate-fade-up-3" style="background:#f7f8f0; border:1px solid #d8da9a;">
                <p class="text-[11px] font-bold tracking-widest uppercase mb-2 text-[#7a8040]">Camping Tersedia</p>
                <p class="font-serif text-4xl text-[#3d4410]">17 <span class="text-lg text-[#7a8040]">/ 25</span></p>
                <div class="flex items-center gap-2 mt-3">
                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-[#1a3a80]/5 text-[#1a3a80] border border-[#1a3a80]/10">8 sedang disewa</span>
                </div>
            </div>

            <div class="p-5 rounded-2xl animate-fade-up-4" style="background:#fff5f5; border:1px solid #f5b5b5;">
                <p class="text-[11px] font-bold tracking-widest uppercase mb-2 text-[#dc2626]">Rental Overdue</p>
                <p class="font-serif text-4xl text-[#991b1b]">6</p>
                <div class="flex items-center gap-2 mt-3">
                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-red-50 text-red-700 border border-red-100 uppercase">Perlu Tindakan</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-[28px] p-6 lg:col-span-3 border border-[#e8e8e0] shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-serif text-xl text-[#1a1a1a]">Tren Rental Mingguan</h3>
                    <div class="flex gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#5f6826]"></span>
                        <span class="text-[10px] font-bold uppercase text-gray-400">Kamera</span>
                        <span class="w-3 h-3 rounded-full bg-[#df6f81] ml-2"></span>
                        <span class="text-[10px] font-bold uppercase text-gray-400">Camping</span>
                    </div>
                </div>
                <div class="relative h-[250px]">
                    <canvas id="rentalChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-[28px] p-5 lg:col-span-2 border border-[#e8e8e0] shadow-sm flex flex-col">
                <h3 class="font-serif text-xl text-[#1a1a1a] mb-4">Lokasi Camping Aktif</h3>
                <div class="flex-1 min-h-[250px] rounded-2xl overflow-hidden grayscale-[0.5] hover:grayscale-0 transition-all duration-500">
                    <div id="map"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[28px] p-8 border border-[#e8e8e0] shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <h3 class="font-serif text-2xl text-[#1a1a1a]">Transaksi Terbaru</h3>
                <button class="text-xs font-bold text-[#22543D] hover:text-[#ED64A6] transition-colors uppercase tracking-widest">Lihat Semua →</button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] border-b border-gray-50">
                            <th class="pb-4 px-2">Pelanggan</th>
                            <th class="pb-4 px-2">Item Rental</th>
                            <th class="pb-4 px-2 text-center">Tgl Kembali</th>
                            <th class="pb-4 px-2 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php
                        $transactions = [
                        ['RS','Rizky Saputra','Sony A7III','18 Mar','bg-green-50 text-green-700','Aktif'],
                        ['NA','Nadia Aulia','Camping Kit L','20 Mar','bg-blue-50 text-blue-700','Reservasi'],
                        ['DP','Doni Pratama','Canon EOS R5','16 Mar !','bg-red-50 text-red-700','Terlambat'],
                        ['SW','Sari Wulandari','Drone DJI Mini','22 Mar','bg-orange-50 text-orange-700','Proses'],
                        ];
                        @endphp
                        @foreach($transactions as $trx)
                        <tr class="group hover:bg-gray-50 transition-all">
                            <td class="py-5 px-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center font-bold text-xs text-[#22543D]">{{ $trx[0] }}</div>
                                    <span class="font-bold text-sm text-[#1a1a1a]">{{ $trx[1] }}</span>
                                </div>
                            </td>
                            <td class="py-5 px-2 text-sm text-gray-500 font-medium">{{ $trx[2] }}</td>
                            <td class="py-5 px-2 text-sm text-center font-bold {{ str_contains($trx[3], '!') ? 'text-red-500' : 'text-gray-400' }}">{{ $trx[3] }}</td>
                            <td class="py-5 px-2 text-right">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tighter {{ $trx[4] }}">{{ $trx[5] }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Chart Config
        const ctx = document.getElementById('rentalChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                        label: 'Kamera',
                        data: [8, 12, 7, 15, 10, 18, 14],
                        backgroundColor: '#5f6826',
                        borderRadius: 6,
                        barThickness: 12
                    },
                    {
                        label: 'Camping',
                        data: [4, 6, 9, 5, 11, 16, 12],
                        backgroundColor: '#df6f81',
                        borderRadius: 6,
                        barThickness: 12
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        border: {
                            display: false
                        },
                        grid: {
                            color: '#f5f5f0'
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        border: {
                            display: false
                        },
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });

        // Map Config
        const map = L.map('map', {
            zoomControl: false
        }).setView([-2.5, 118], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        // Custom Marker
        const customIcon = L.divIcon({
            className: 'custom-div-icon',
            html: "<div style='background-color:#22543D; width:12px; height:12px; border:2px solid white; border-radius:50%; box-shadow: 0 0 10px rgba(0,0,0,0.2)'></div>",
            iconSize: [12, 12],
            iconAnchor: [6, 6]
        });
        L.marker([-6.2088, 106.8456], {
            icon: customIcon
        }).addTo(map); // Jakarta
        L.marker([-7.2575, 112.7521], {
            icon: customIcon
        }).addTo(map); // Surabaya
    </script>
</body>

</html>