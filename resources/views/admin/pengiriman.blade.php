<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengiriman - CampLore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
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
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-white font-sans text-[#1a1a1a] antialiased">

    {{-- 1. SIDEBAR --}}
    @include('sidebar_dashboard_admin')

    {{-- 2. MAIN CONTENT WRAPPER (Disamakan dengan Dashboard: ml-272px dan pt-32) --}}
    <main class="sm:ml-[272px] min-h-screen pt-32 pb-10 px-6 bg-[#F8FAF6] transition-all duration-300">

        {{-- 3. NAVBAR AREA (FIXED) - Koordinat disamakan persis --}}
        <div class="fixed top-5 right-6 z-40 left-[calc(272px+24px)] max-sm:left-6 animate-fade-up">
            @include('admin.navbar', [
            'NavParent' => 'Managemen Operasional',
            'section' => 'Pengiriman'
            ])
        </div>

        {{-- CONTAINER KONTEN (Model Card Putih Dashboard) --}}
        <div class="max-w-full animate-fade-up">
            <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

                {{-- Header Halaman --}}
                <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0]">
                    <div>
                        <h2 class="text-2xl font-bold text-[#22543D] font-serif leading-tight">
                            Data Pengiriman Unit
                        </h2>
                        <p class="text-[11px] text-[#7c8b84] mt-0.5">
                            Pantau dan kelola semua status logistik pengiriman barang.
                        </p>
                    </div>
                </div>

                {{-- Area Pencarian (Search Bar) --}}
                <div class="p-5 bg-[#fcfdfb]">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" />
                            </svg>
                        </span>
                        <input type="text" placeholder="Cari nama pelanggan atau produk..."
                            class="w-full bg-white border border-[#d7e6de] text-sm py-2.5 pl-11 pr-4 rounded-xl outline-none focus:ring-2 focus:ring-[#22543D]/10 focus:border-[#22543D] transition-all shadow-sm">
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-[#f1f8f4] text-[#22543D] uppercase text-[10px] font-bold tracking-[0.15em]">
                            <tr>
                                <th class="px-8 py-4">Pemesan</th>
                                <th class="px-6 py-4">Alamat</th>
                                <th class="px-6 py-4 text-center">Barang</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#eef4f0]">
                            @forelse($pengiriman as $item)
                            <tr class="hover:bg-[#fcfdfb] transition-colors group">
                                <td class="px-8 py-5 flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-xl bg-[#22543D] flex items-center justify-center text-white font-bold text-xs shadow-sm border border-[#d7e6de]">
                                        {{ substr($item['pemesan'], 0, 1) }}{{ substr(explode(' ', $item['pemesan'])[1] ?? '', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-[#22543D] text-sm">{{ $item['pemesan'] }}</div>
                                        <div class="text-[9px] text-[#7c8b84] mt-1 italic uppercase tracking-wider">{{ $item['no_hp'] }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-[11px] leading-relaxed max-w-[200px] text-[#4a5038]">{{ $item['alamat'] }}</p>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="font-bold text-[#22543D] text-sm">{{ $item['barang'] }}</div>
                                    <div class="text-[9px] text-[#7c8b84] mt-1 italic tracking-wider uppercase">{{ $item['tanggal_mulai'] }}</div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-bold bg-[#FDF4F8] text-[#D977A8] border border-[#f3d6e5]">
                                        H{{ $item['h_plus'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <button onclick="openModal()" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-[#f1f8f4] hover:bg-[#22543D] hover:text-white border border-[#d7e6de] text-[#22543D] rounded-lg text-[10px] font-bold transition-all active:scale-95 shadow-sm">
                                        Tandai Sudah Tiba
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-16 text-center text-xs text-[#7c8b84] italic tracking-wide">Belum ada data pengiriman hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination / Footer --}}
                <div class="p-5 bg-[#fcfdfb] border-t border-[#eef4f0] flex items-center justify-between">
                    <p class="text-[10px] font-bold text-[#22543D] uppercase tracking-widest">
                        Menampilkan {{ count($pengiriman ?? []) }} data pengiriman
                    </p>
                    <div class="flex gap-1.5">
                        <button class="w-9 h-9 flex items-center justify-center border border-gray-100 rounded-xl text-gray-400 hover:bg-gray-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M15 19l-7-7 7-7" stroke-width="2" />
                            </svg>
                        </button>
                        <button class="w-9 h-9 flex items-center justify-center bg-[#22543D] text-white font-bold text-xs rounded-xl shadow-lg shadow-[#22543D]/20">1</button>
                        <button class="w-9 h-9 flex items-center justify-center border border-gray-100 rounded-xl text-gray-400 hover:bg-gray-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 5l7 7-7 7" stroke-width="2" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </main>

    {{-- MODAL KONFIRMASI (Hidden by default) --}}
    <div id="modalConfirm" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#1a2e23]/40 backdrop-blur-sm transition-all duration-300 opacity-0">
        <div class="bg-[#f4f5ed] w-[90%] max-w-sm rounded-[28px] p-8 shadow-2xl border border-[#c8c9b4] text-center relative transform scale-95 transition-all duration-300" id="modalCard">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-[#22543D] rounded-full flex items-center justify-center border-4 border-[#dff0c0] shadow-sm">
                    <svg class="w-8 h-8 text-[#dff0c0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" stroke-width="3" />
                    </svg>
                </div>
            </div>
            <h3 class="text-[#22543D] text-xl font-serif mb-2">Tandai Sudah Tiba</h3>
            <p class="text-[#6a7858] text-[11px] mb-8 leading-relaxed">Apakah Anda yakin ingin menandai barang ini telah sampai ke pemesan?</p>
            <div class="flex gap-3">
                <button onclick="closeModal()" class="flex-1 py-3 bg-white border border-[#c8c9b4] text-[#4a5038] rounded-2xl font-bold hover:bg-gray-50 transition text-[11px]">Batal</button>
                <button onclick="confirmAction()" class="flex-1 py-3 bg-[#22543D] text-white rounded-2xl font-bold hover:bg-[#1B4332] transition shadow-lg shadow-[#22543D]/20 text-[11px]">Konfirmasi</button>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            const modal = document.getElementById('modalConfirm');
            const card = document.getElementById('modalCard');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                card.classList.remove('scale-95');
                card.classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('modalConfirm');
            const card = document.getElementById('modalCard');
            modal.classList.remove('opacity-100');
            card.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function confirmAction() {
            alert('Status Berhasil Diperbarui!');
            closeModal();
        }
    </script>
</body>

</html>