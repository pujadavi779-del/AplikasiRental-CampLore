@extends('layouts.admin')

@section('title', 'Riwayat Produk')

@php
    $NavParent = 'Manajemen Rental';
    $section = 'Riwayat Produk';
@endphp
@section('content')

<div class="bg-[#F8FAF6] h-screen overflow-hidden">
    <div class="max-w-full">
        <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

            {{-- HEADER --}}
            <div class="px-6 py-6 border-b border-[#eef4f0]">
                <div class="mb-5">
                    <h2 class="text-xl font-bold text-[#22543D] font-serif">Riwayat Produk</h2>
                    <p class="text-[11px] text-[#7c8b84] mt-0.5">Daftar produk berdasarkan kategori dan riwayat penggunaannya.</p>
                </div>

                {{-- FILTER --}}
                <button onclick="filterKategori('All', this)"
                    class="merek-btn active-merek px-5 py-2 rounded-xl text-[10px] font-bold border border-[#d7e6de] shadow-sm uppercase">
                    Semua Produk
                </button>

                <button onclick="filterKategori('Kamera', this)"
                    class="merek-btn border border-[#d7e6de] px-5 py-2 rounded-xl text-[10px] font-bold uppercase">
                    Kamera
                </button>

                <button onclick="filterKategori('Camping', this)"
                    class="merek-btn border border-[#d7e6de] px-5 py-2 rounded-xl text-[10px] font-bold uppercase">
                    Alat Camping
                </button>
            </div>

            {{-- GRID --}}
            <div class="p-6 bg-[#fcfdfb] h-[calc(100vh-220px)] overflow-y-auto no-scrollbar">
                <div id="alatGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 w-full">
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div id="modalDetail" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-[#f1f8f4]">
                <h3 class="font-bold text-[#22543D] text-sm" id="modalTitle"></h3>
                <button onclick="closeModal()" class="text-gray-400 text-xl">&times;</button>
            </div>
            <div class="p-6 max-h-[350px] overflow-y-auto space-y-3" id="modalBody"></div>
            <div class="px-6 py-4 border-t text-right bg-gray-50">
                <button onclick="closeModal()" class="bg-[#22543D] text-white px-6 py-2 rounded-xl text-xs font-bold">Tutup</button>
            </div>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .font-serif {
            font-family: 'Playfair Display', serif !important;
        }

        .active-merek {
            background-color: #22543D !important;
            color: white !important;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>

    <script>
        const dataAlat = @json($dataAlat);

        function renderAlat(kategori = 'All') {

            const grid = document.getElementById('alatGrid');
            grid.innerHTML = '';

            const filtered = kategori === 'All' ?
                dataAlat :
                dataAlat.filter(item => item.kategori === kategori);

            if (filtered.length === 0) {
                grid.innerHTML = `
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-400 text-sm">
                        Tidak ada data alat pada kategori ini
                    </p>
                </div>
            `;
                return;
            }

            filtered.forEach(k => {

                grid.innerHTML += `
                <div class="bg-white rounded-xl border border-[#d7e6de] overflow-hidden hover:shadow-md transition-all duration-300">

                    <div class="h-40 bg-gray-100 overflow-hidden relative">

                        <img
                            src="${k.img}"
                            alt="${k.nama}"
                            class="w-full h-full object-cover"
                            onerror="this.src='https://placehold.co/400x300?text=No+Image'"
                        >

                        <div class="absolute top-2 right-2">
                            <span class="bg-white px-2 py-1 rounded text-[8px] font-black text-[#22543D] border">
                                ${k.kategori}
                            </span>
                        </div>

                    </div>

                    <div class="p-4 text-center">

                        <h4 class="text-[13px] font-bold text-[#22543D] mb-1">
                            ${k.nama}
                        </h4>

                        <p class="text-[10px] text-gray-400 mb-4">
                            Disewa ${k.totalSewa} kali
                        </p>

                        <button
                            onclick="showDetail(${k.id})"
                            class="w-full bg-[#f1f8f4] text-[#22543D] py-2 rounded-lg text-[10px] font-bold border hover:bg-[#22543D] hover:text-white transition"
                        >
                            DETAIL RIWAYAT
                        </button>

                    </div>

                </div>
            `;
            });
        }

        function filterKategori(kategori, button) {

            document.querySelectorAll('.merek-btn')
                .forEach(btn => btn.classList.remove('active-merek'));

            button.classList.add('active-merek');

            renderAlat(kategori);
        }

        function showDetail(id) {

            const alat = dataAlat.find(item => item.id === id);

            if (!alat) return;

            document.getElementById('modalTitle').innerText = alat.nama;

            const modalBody = document.getElementById('modalBody');

            modalBody.innerHTML = alat.riwayat.length ?
                alat.riwayat.map(r => `

                <div class="border border-gray-200 rounded-xl p-4">

                    <div class="font-bold text-[#22543D] text-sm">
                        ${r.nama}
                    </div>

                    <div class="mt-3 flex justify-between">

                        <div>
                            <div class="text-[10px] text-gray-400 uppercase">
                                Periode
                            </div>

                            <div class="text-xs">
                                ${r.periode}
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="text-[10px] text-gray-400 uppercase">
                                Durasi
                            </div>

                            <div class="text-xs font-bold text-pink-500">
                                ${r.durasi}
                            </div>
                        </div>

                    </div>

                </div>

            `).join('') :
                `
                <div class="text-center py-8 text-sm text-gray-500">
                    Belum ada riwayat penyewaan
                </div>
            `;

            document.getElementById('modalDetail')
                .classList.remove('hidden');
        }

        function closeModal() {

            document.getElementById('modalDetail')
                .classList.add('hidden');
        }

        renderAlat();
    </script>

    @endsection