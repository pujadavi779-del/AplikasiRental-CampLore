@extends('layouts.admin')

@section('title', 'Riwayat Produk Kamera')

@section('content')

<div class="mb-6">
    @include('components.navbar_judul_LP', [
    'NavParent' => 'Manajemen Rental',
    'section' => 'Riwayat Kamera'
    ])
</div>

<div class="bg-[#F8FAF6] h-screen overflow-hidden">
    <div class="max-w-full">
        <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

            <div class="px-6 py-6 border-b border-[#eef4f0]">
                <div class="mb-5">
                    <h2 class="text-xl font-bold text-[#22543D] font-serif">Riwayat Unit Kamera</h2>
                    <p class="text-[11px] text-[#7c8b84] mt-0.5">Daftar kamera berdasarkan merek dan riwayat penggunaannya.</p>
                </div>

                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                    <button onclick="filterMerek('All')" class="merek-btn active-merek px-5 py-2 rounded-xl text-[10px] font-bold transition-all border border-[#d7e6de] shadow-sm uppercase tracking-wider">
                        Semua Unit
                    </button>
                    <button onclick="filterMerek('Canon')" class="merek-btn bg-white text-[#22543D] px-5 py-2 rounded-xl text-[10px] font-bold transition-all border border-[#d7e6de] shadow-sm hover:bg-[#f1f8f4] uppercase tracking-wider">
                        Canon
                    </button>
                    <button onclick="filterMerek('Sony')" class="merek-btn bg-white text-[#22543D] px-5 py-2 rounded-xl text-[10px] font-bold transition-all border border-[#d7e6de] shadow-sm hover:bg-[#f1f8f4] uppercase tracking-wider">
                        Sony
                    </button>
                    <button onclick="filterMerek('Fujifilm')" class="merek-btn bg-white text-[#22543D] px-5 py-2 rounded-xl text-[10px] font-bold transition-all border border-[#d7e6de] shadow-sm hover:bg-[#f1f8f4] uppercase tracking-wider">
                        Fujifilm
                    </button>
                    <button onclick="filterMerek('Nikon')" class="merek-btn bg-white text-[#22543D] px-5 py-2 rounded-xl text-[10px] font-bold transition-all border border-[#d7e6de] shadow-sm hover:bg-[#f1f8f4] uppercase tracking-wider">
                        Nikon
                    </button>
                </div>
            </div>

            <div class="p-6 bg-[#fcfdfb]">
                <div id="kameraGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 w-full">
                </div>
            </div>
        </div>
    </div>

    <div id="modalDetail" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-[#f1f8f4]">
                <h3 class="font-bold text-[#22543D] text-sm" id="modalTitle">Riwayat Penyewa</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>
            <div class="p-6 max-h-[350px] overflow-y-auto space-y-3" id="modalBody"></div>
            <div class="px-6 py-4 border-t border-gray-100 text-right bg-gray-50">
                <button onclick="closeModal()" class="bg-[#22543D] text-white px-6 py-2 rounded-xl text-xs font-bold">Tutup</button>
            </div>
        </div>
    </div>

    <style>
        .active-merek {
            background-color: #22543D !important;
            color: white !important;
            border-color: #22543D !important;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>

    <script>
        const dataKamera = [{
                id: 1,
                nama: 'Canon EOS R6',
                merek: 'Canon',
                img: 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&q=80&w=300',
                totalSewa: 12,
                riwayat: [{
                        nama: 'Andi Pratama',
                        periode: '12 Apr - 15 Apr 2026',
                        durasi: '3 Hari'
                    },
                    {
                        nama: 'Siti Rahayu',
                        periode: '05 Apr - 07 Apr 2026',
                        durasi: '2 Hari'
                    },
                    {
                        nama: 'Budi Santoso',
                        periode: '01 Apr - 02 Apr 2026',
                        durasi: '1 Hari'
                    }
                ]
            },
            {
                id: 2,
                nama: 'Sony A7 III',
                merek: 'Sony',
                img: 'https://images.unsplash.com/photo-1510127034890-af2752869b1c?auto=format&fit=crop&q=80&w=300',
                totalSewa: 8,
                riwayat: [{
                        nama: 'Fajar Nugroho',
                        periode: '10 Apr - 13 Apr 2026',
                        durasi: '3 Hari'
                    },
                    {
                        nama: 'Rina Wulandari',
                        periode: '02 Apr - 04 Apr 2026',
                        durasi: '2 Hari'
                    }
                ]
            },
            {
                id: 3,
                nama: 'Fujifilm X-T4',
                merek: 'Fujifilm',
                img: 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?auto=format&fit=crop&q=80&w=300',
                totalSewa: 5,
                riwayat: [{
                        nama: 'Mega Safitri',
                        periode: '15 Apr - 17 Apr 2026',
                        durasi: '2 Hari'
                    },
                    {
                        nama: 'Hendra Kusuma',
                        periode: '08 Apr - 09 Apr 2026',
                        durasi: '1 Hari'
                    }
                ]
            },
            {
                id: 4,
                nama: 'Nikon Z6 II',
                merek: 'Nikon',
                img: 'https://images.unsplash.com/photo-1612450796384-3e34df475158?auto=format&fit=crop&q=80&w=300',
                totalSewa: 3,
                riwayat: [{
                    nama: 'Dewi Lestari',
                    periode: '20 Apr - 22 Apr 2026',
                    durasi: '2 Hari'
                }]
            }
        ];

        function renderKamera(merek = 'All') {
            const grid = document.getElementById('kameraGrid');
            grid.innerHTML = '';
            const filtered = merek === 'All' ? dataKamera : dataKamera.filter(k => k.merek === merek);

            filtered.forEach(k => {
                grid.innerHTML += `
                <div class="bg-white rounded-xl border border-[#d7e6de] overflow-hidden hover:shadow-md transition-all group">
                    <div class="h-36 bg-gray-100 overflow-hidden relative">
                        <img src="${k.img}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-2 right-2">
                             <span class="bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[8px] font-black text-[#22543D] uppercase border border-[#d7e6de] shadow-sm">${k.merek}</span>
                        </div>
                    </div>
                    <div class="p-4 text-center">
                        <h4 class="text-[13px] font-bold text-[#22543D] mb-1 truncate px-2">${k.nama}</h4>
                        <p class="text-[10px] text-gray-400 mb-4">Disewa ${k.totalSewa} kali</p>
                        <button onclick="showDetail(${k.id})" class="w-full bg-[#f1f8f4] text-[#22543D] hover:bg-[#22543D] hover:text-white transition-all py-2 rounded-lg text-[10px] font-bold border border-[#d7e6de]">
                            DETAIL RIWAYAT
                        </button>
                    </div>
                </div>
            `;
            });
        }

        function filterMerek(merek) {
            document.querySelectorAll('.merek-btn').forEach(btn => btn.classList.remove('active-merek'));
            event.currentTarget.classList.add('active-merek');
            renderKamera(merek);
        }

        function showDetail(id) {
            const kamera = dataKamera.find(k => k.id === id);
            const modal = document.getElementById('modalDetail');
            const modalBody = document.getElementById('modalBody');
            document.getElementById('modalTitle').innerText = kamera.nama;

            modalBody.innerHTML = kamera.riwayat.map(r => `
        <div class="p-4 bg-white border border-[#d7e6de] rounded-2xl shadow-sm space-y-2">
            <div class="flex items-center gap-3 border-b border-gray-50 pb-2">
                <div class="w-8 h-8 rounded-full bg-[#22543D] text-white flex items-center justify-center text-[10px] font-bold">
                    ${r.nama.split(' ').map(n => n[0]).join('')}
                </div>
                <span class="text-[11px] text-[#22543D] font-bold">${r.nama}</span>
            </div>
            <div class="flex justify-between items-center px-1">
                <div>
                    <div class="text-[9px] text-gray-400 uppercase font-bold">Periode</div>
                    <div class="text-[10px] text-gray-700 font-medium">${r.periode}</div>
                </div>
                <div class="text-right">
                    <div class="text-[9px] text-gray-400 uppercase font-bold">Durasi</div>
                    <div class="text-[10px] text-[#ED64A6] font-bold">${r.durasi}</div>
                </div>
            </div>
        </div>
    `).join('');

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modalDetail').classList.add('hidden');
        }

        renderKamera();
        
    </script>

    @endsection