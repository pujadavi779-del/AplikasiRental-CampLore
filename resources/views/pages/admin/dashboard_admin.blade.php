<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CampLore</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    keyframes: {
                        fadeUp: {
                            from: { opacity: '0', transform: 'translateY(10px)' },
                            to:   { opacity: '1', transform: 'translateY(0)' },
                        }
                    },
                    animation: {
                        'fade-up':   'fadeUp .4s ease both',
                        'fade-up-2': 'fadeUp .4s .07s ease both',
                        'fade-up-3': 'fadeUp .4s .14s ease both',
                        'fade-up-4': 'fadeUp .4s .21s ease both',
                    }
                }
            }
        }
    </script>

    <style>[x-cloak] { display: none !important; }</style>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-[#f8faf6] font-sans text-[#1a1a1a] antialiased">

    {{-- Sidebar --}}
    @include('components.sidebar_dashboard_admin')

    <main class="lg:ml-[272px] min-h-screen pb-10 px-6 pt-6">

        {{-- Navbar Admin --}}
        <div class="mb-4">
            @include('components.navbar_judul_LP', [
                'NavParent'      => '',
                'section'        => 'Beranda',
                'unrepliedCount' => $unrepliedCount ?? 0
            ])
        </div>

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

            <div class="p-5 rounded-2xl animate-fade-up" style="background:#f7f8f0; border:1px solid #d8da9a;">
                <p class="text-[11px] font-bold tracking-widest uppercase mb-2 text-[#7a8040]">Total Rental Aktif</p>
                <p class="font-serif text-4xl text-[#3d4410]">{{ $totalRentalAktif }}</p>
                <div class="flex items-center gap-2 mt-3">
                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-[#5f6826]/10 text-[#3d4410] border border-[#5f6826]/20">{{ $trendLabel }}</span>
                </div>
            </div>

            <div class="p-5 rounded-2xl animate-fade-up-2" style="background:#fef4f5; border:1px solid #f0c0c8;">
                <p class="text-[11px] font-bold tracking-widest uppercase mb-2 text-[#c07888]">Kamera Tersedia</p>
                <p class="font-serif text-4xl text-[#8a2035]">{{ $kameraTersedia }} <span class="text-lg text-[#c07888]">/ {{ $totalKamera }}</span></p>
                <div class="flex items-center gap-2 mt-3">
                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-[#df6f81]/10 text-[#8a2035] border border-[#df6f81]/20">{{ $kameraDipinjam }} sedang disewa</span>
                </div>
            </div>

            <div class="p-5 rounded-2xl animate-fade-up-3" style="background:#f7f8f0; border:1px solid #d8da9a;">
                <p class="text-[11px] font-bold tracking-widest uppercase mb-2 text-[#7a8040]">Camping Tersedia</p>
                <p class="font-serif text-4xl text-[#3d4410]">{{ $campingTersedia }} <span class="text-lg text-[#7a8040]">/ {{ $totalCamping }}</span></p>
                <div class="flex items-center gap-2 mt-3">
                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-[#1a3a80]/5 text-[#1a3a80] border border-[#1a3a80]/10">{{ $campingDipinjam }} sedang disewa</span>
                </div>
            </div>

            <div class="p-5 rounded-2xl animate-fade-up-4" style="background:#fff5f5; border:1px solid #f5b5b5;">
                <p class="text-[11px] font-bold tracking-widest uppercase mb-2 text-[#dc2626]">Rental Terlambat</p>
                <p class="font-serif text-4xl text-[#991b1b]">{{ $rentalTerlambat }}</p>
                <div class="flex items-center gap-2 mt-3">
                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-red-50 text-red-700 border border-red-100 uppercase">Perlu Tindakan</span>
                </div>
            </div>

        </div>

        {{-- CHART + TOP PRODUK --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">

            {{-- Bar Chart --}}
            <div class="bg-white rounded-[28px] p-6 lg:col-span-3 border border-[#e8e8e0] shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-serif text-xl text-[#1a1a1a]">Tren Rental Mingguan</h3>
                    <div class="flex items-center gap-3">
                        <span class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#5f6826] inline-block"></span>
                            <span class="text-[10px] font-bold uppercase text-gray-400">Kamera</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#df6f81] inline-block"></span>
                            <span class="text-[10px] font-bold uppercase text-gray-400">Camping</span>
                        </span>
                    </div>
                </div>
                <div class="relative h-[250px]">
                    <canvas id="rentalChart"></canvas>
                </div>
            </div>

            {{-- TOP PRODUK --}}
            <div class="bg-white rounded-[28px] p-5 lg:col-span-2 border border-[#e8e8e0] shadow-sm flex flex-col">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-serif text-xl text-[#1a1a1a]">Top Produk Disewa</h3>
                    <span class="text-[9px] font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-1 rounded-lg">
                        Bulan Ini
                    </span>
                </div>

                @php
                $barColors = ['#22543D', '#5f6826', '#df6f81', '#1a3a80', '#7a8040'];
                @endphp

                <div class="flex-1 space-y-4">
                    @forelse($topProducts as $i => $p)
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-lg flex items-center justify-center text-[10px] font-black flex-shrink-0
                            {{ $i === 0 ? 'bg-amber-100 text-amber-600' : 'bg-gray-100 text-gray-400' }}">
                            {{ $i + 1 }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-[12px] font-bold text-[#1a1a1a] truncate pr-2">{{ $p[0] }}</span>
                                <span class="text-[11px] font-black flex-shrink-0" style="color:{{ $barColors[$i] ?? '#22543D' }}">{{ $p[1] }}x</span>
                            </div>
                            <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full" style="width:{{ $p[2] }}%; background-color:{{ $barColors[$i] ?? '#22543D' }}"></div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 text-center py-4">Belum ada data bulan ini</p>
                    @endforelse
                </div>

                <div class="mt-5 pt-4 border-t border-[#f1f8f4] flex items-center justify-between">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total disewa</span>
                    <span class="text-[13px] font-black text-[#22543D]">{{ $topProducts->sum(fn($p) => $p[1]) }} item</span>
                </div>
            </div>

        </div>

        {{-- TRANSAKSI TERBARU --}}
        <div class="bg-white rounded-[28px] p-8 border border-[#e8e8e0] shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <h3 class="font-serif text-2xl text-[#1a1a1a]">Transaksi Terbaru</h3>
                <a href="{{ route('admin.pembayaran') }}" class="text-xs font-bold text-[#22543D] hover:text-[#ED64A6] transition-colors uppercase tracking-widest">
                    Lihat Semua →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] border-b border-gray-50">
                            <th class="pb-4 px-2">Pelanggan</th>
                            <th class="pb-4 px-2">Tgl Sewa</th>
                            <th class="pb-4 px-2 text-center">Tgl Kembali</th>
                            <th class="pb-4 px-2 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($transactions as $trx)
                        @php
                        $statusStyle = match(strtolower($trx->status ?? '')) {
                            'selesai', 'dikemas'  => 'bg-[#e8f8f0] text-[#4caf82] border border-[#b6e8d0]',
                            'batal'          => 'bg-[#fdf0f5] text-[#e07a9a] border border-[#f5c6d8]',
                            default               => 'bg-gray-100 text-gray-400 border border-gray-200',
                        };
                        $initials = strtoupper(substr($trx->pelanggan->nama_lengkap ?? '-', 0, 2));
                        $fotoProfil = $trx->pelanggan && $trx->pelanggan->foto_profile
                            ? asset('storage/' . $trx->pelanggan->foto_profile)
                            : null;
                        @endphp
                        <tr class="group hover:bg-gray-50 transition-all">
                            <td class="py-5 px-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center font-bold text-xs text-[#22543D]">
                                        @if($fotoProfil)
                                            <img src="{{ $fotoProfil }}" alt="{{ $trx->pelanggan->nama_lengkap ?? '-' }}" class="w-full h-full object-cover">
                                        @else
                                            {{ $initials }}
                                        @endif
                                    </div>
                                    <span class="font-bold text-sm text-[#1a1a1a]">{{ $trx->pelanggan->nama_lengkap ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="py-5 px-2 text-sm text-gray-500">
                                {{ $trx->created_at ? $trx->created_at->format('d M Y') : '-' }}
                            </td>
                            <td class="py-5 px-2 text-sm text-center font-bold text-gray-400">
                                {{ $trx->details->first()?->end_date 
                                    ? \Carbon\Carbon::parse($trx->details->first()->end_date)->format('d M Y') 
                                    : '-' }}
                            </td>
                            <td class="py-5 px-2 text-right">
                                <span class="px-4 py-1.5 rounded-full text-[11px] font-semibold {{ $statusStyle }}">
                                    {{ $trx->status === 'selesai' || $trx->status === 'dikemas' ? 'Lunas' : ($trx->status === 'dibatalkan' ? 'Batal' : ucfirst($trx->status)) }}

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-sm text-gray-400">Belum ada transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('rentalChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Kamera',
                    data: {!! json_encode($kameraPerHari) !!},
                    backgroundColor: '#5f6826',
                    borderRadius: 6,
                    barThickness: 12
                }, {
                    label: 'Camping',
                    data: {!! json_encode($campingPerHari) !!},
                    backgroundColor: '#df6f81',
                    borderRadius: 6,
                    barThickness: 12
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        border: { display: false },
                        grid: { color: '#f5f5f0' },
                        ticks: { font: { size: 10 } }
                    },
                    x: {
                        border: { display: false },
                        grid: { display: false },
                        ticks: { font: { size: 10 } }
                    }
                }
            }
        });
    </script>
</body>

</html>