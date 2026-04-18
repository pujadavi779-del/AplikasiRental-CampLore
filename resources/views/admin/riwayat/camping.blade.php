@extends('admin.admin')

@section('title', 'Riwayat Produk Alat Camping')

@section('content')

<div class="fixed top-5 left-6 right-6 sm:left-[296px] z-40">
    @include('admin.navbar', [
    'NavParent' => 'Managemen Rental',
    'section' => 'Riwayat Alat Camping'
    ])
</div>

<div class="bg-[#F8FAF6] h-screen overflow-hidden">
    <div class="max-w-full">
        <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

            {{-- HEADER --}}
            <div class="px-6 py-6 border-b border-[#eef4f0]">
                <div class="mb-5">
                    <h2 class="text-xl font-bold text-[#22543D] font-serif">Riwayat Alat Camping</h2>
                    <p class="text-[11px] text-[#7c8b84] mt-0.5">Daftar alat camping berdasarkan kategori dan riwayat penggunaannya.</p>
                </div>

                {{-- FILTER --}}
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                    <button onclick="filterKategori('All')" class="merek-btn active-merek px-5 py-2 rounded-xl text-[10px] font-bold border border-[#d7e6de] shadow-sm uppercase">
                        Semua Alat
                    </button>
                    <button onclick="filterKategori('Tenda')" class="merek-btn border border-[#d7e6de] px-5 py-2 rounded-xl text-[10px] font-bold uppercase">
                        Tenda
                    </button>
                    <button onclick="filterKategori('Sleeping Bag')" class="merek-btn border border-[#d7e6de] px-5 py-2 rounded-xl text-[10px] font-bold uppercase">
                        Sleeping Bag
                    </button>
                    <button onclick="filterKategori('Kompor')" class="merek-btn border border-[#d7e6de] px-5 py-2 rounded-xl text-[10px] font-bold uppercase">
                        Kompor
                    </button>
                    <button onclick="filterKategori('Carrier')" class="merek-btn border border-[#d7e6de] px-5 py-2 rounded-xl text-[10px] font-bold uppercase">
                        Carrier
                    </button>
                </div>
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
        .active-merek {
            background-color: #22543D !important;
            color: white !important;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>

    <script>
        const dataAlat = [{
                id: 1,
                nama: 'Tenda Eiger 4 Orang',
                kategori: 'Tenda',
                img: 'https://images.unsplash.com/photo-1504280390368-397dcf1c1d81?auto=format&fit=crop&q=80&w=300',
                totalSewa: 10,
                riwayat: [{
                    nama: 'Andi',
                    periode: '10 Apr - 12 Apr',
                    durasi: '2 Hari'
                }]
            },
            {
                id: 2,
                nama: 'Sleeping Bag Rei',
                kategori: 'Sleeping Bag',
                img: 'https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?auto=format&fit=crop&q=80&w=300',
                totalSewa: 7,
                riwayat: [{
                    nama: 'Siti',
                    periode: '05 Apr - 06 Apr',
                    durasi: '1 Hari'
                }]
            },
            {
                id: 3,
                nama: 'Kompor Portable',
                kategori: 'Kompor',
                img: 'https://images.unsplash.com/photo-1501706362039-c6e08bff8a1c?auto=format&fit=crop&q=80&w=300',
                totalSewa: 5,
                riwayat: [{
                    nama: 'Budi',
                    periode: '01 Apr - 02 Apr',
                    durasi: '1 Hari'
                }]
            },
            {
                id: 4,
                nama: 'Carrier 60L',
                kategori: 'Carrier',
                img: 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&q=80&w=300',
                totalSewa: 3,
                riwayat: [{
                    nama: 'Dewi',
                    periode: '20 Apr - 22 Apr',
                    durasi: '2 Hari'
                }]
            }
        ];

        function renderAlat(kategori = 'All') {
            const grid = document.getElementById('alatGrid');
            grid.innerHTML = '';

            const filtered = kategori === 'All' ?
                dataAlat :
                dataAlat.filter(k => k.kategori === kategori);

            filtered.forEach(k => {
                grid.innerHTML += `
                <div class="bg-white rounded-xl border border-[#d7e6de] overflow-hidden hover:shadow-md transition-all group">
                    <div class="h-36 bg-gray-100 overflow-hidden relative">
                        <img src="${k.img}" class="w-full h-full object-cover">
                        <div class="absolute top-2 right-2">
                             <span class="bg-white px-2 py-0.5 rounded text-[8px] font-black text-[#22543D] border">${k.kategori}</span>
                        </div>
                    </div>
                    <div class="p-4 text-center">
                        <h4 class="text-[13px] font-bold text-[#22543D] mb-1">${k.nama}</h4>
                        <p class="text-[10px] text-gray-400 mb-4">Disewa ${k.totalSewa} kali</p>
                        <button onclick="showDetail(${k.id})" class="w-full bg-[#f1f8f4] text-[#22543D] py-2 rounded-lg text-[10px] font-bold border">
                            DETAIL RIWAYAT
                        </button>
                    </div>
                </div>
                `;
            });
        }

        function filterKategori(kategori) {
            document.querySelectorAll('.merek-btn').forEach(btn => btn.classList.remove('active-merek'));
            event.currentTarget.classList.add('active-merek');
            renderAlat(kategori);
        }

        function showDetail(id) {
            const alat = dataAlat.find(k => k.id === id);
            const modal = document.getElementById('modalDetail');
            const modalBody = document.getElementById('modalBody');

            document.getElementById('modalTitle').innerText = alat.nama;

            modalBody.innerHTML = alat.riwayat.map(r => `
                <div class="p-4 border rounded-xl">
                    <div class="font-bold">${r.nama}</div>
                    <div class="text-xs text-gray-500">${r.periode}</div>
                    <div class="text-xs">${r.durasi}</div>
                </div>
            `).join('');

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modalDetail').classList.add('hidden');
        }

        renderAlat();
    </script>

    @endsection