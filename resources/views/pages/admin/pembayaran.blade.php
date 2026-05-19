@extends('layouts.admin')

@section('title', 'Transaksi Pembayaran - CampLore')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap');

    * { font-family: 'Inter', sans-serif; }
    .font-serif { font-family: 'Playfair Display', serif !important; }
    [x-cloak] { display: none !important; }
</style>

<div x-data="{ openDetail: false, selectedData: {} }" class="max-w-full">

    <div class="mb-6">
        @include('components.navbar_judul_LP', [
            'NavParent' => 'Manajemen Pesanan',
            'section'   => 'Transaksi Pembayaran'
        ])
    </div>

    <div class="max-w-full">
        <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

            {{-- HEADER --}}
            <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0]">
                <div>
                    <h2 class="text-2xl font-bold text-[#22543D] font-serif leading-tight">Pembayaran</h2>
                    <p class="text-[11px] text-[#7c8b84] mt-0.5">Daftar semua transaksi pembayaran sewa unit.</p>
                </div>
            </div>

            {{-- SEARCH --}}
            <div class="p-6 border-b border-[#f1f8f4]">
                <div class="relative w-full md:w-80">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"/>
                        </svg>
                    </span>
                    <input type="text"
                        placeholder="Cari ID Pesanan atau Tanggal..."
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-[#d7e6de] rounded-xl text-xs focus:ring-1 focus:ring-[#ED64A6] focus:border-[#ED64A6] outline-none shadow-inner">
                </div>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left table-fixed min-w-[1000px]">
                    <thead class="bg-[#f1f8f4] text-[#22543D] uppercase text-[10px] font-bold tracking-widest border-b border-[#e4f0ea]">
                        <tr>
                            <th class="px-4 py-4 border-r border-[#e4f0ea] w-[20%]">ID Pesanan</th>
                            <th class="px-4 py-4 border-r border-[#e4f0ea] w-[12%] text-center">Status</th>
                            <th class="px-4 py-4 border-r border-[#e4f0ea] w-[20%]">Harga yang Dibayar</th>
                            <th class="px-4 py-4 border-r border-[#e4f0ea] w-[25%]">Tanggal Dibuat</th>
                            <th class="px-4 py-4 w-[15%] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#eef4f0]">

                        {{-- ROW 1 --}}
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 border-r text-xs font-bold text-[#22543D]">CMP-20250722-001</td>
                            <td class="px-4 py-4 border-r text-center">
                                <span class="px-3 py-1 bg-emerald-100 text-[#22543D] text-[10px] font-bold rounded-lg border border-emerald-200">Dibayar</span>
                            </td>
                            <td class="px-4 py-4 border-r text-xs font-black text-[#22543D]">Rp 150,000.00</td>
                            <td class="px-4 py-4 border-r text-[10px] text-gray-500 uppercase">12 Apr 2026, 14:35:10</td>
                            <td class="px-4 py-4 text-center">
                                <button @click="selectedData = {
                                    id: 'CMP-20250722-001',
                                    nama: 'Ahmad Fauzi',
                                    inisial: 'AF',
                                    status: 'Dibayar',
                                    statusColor: 'emerald',
                                    metode: 'Transfer Bank',
                                    total: 'Rp 150.000',
                                    mulai: '10 Mei 2026',
                                    selesai: '13 Mei 2026',
                                    items: [
                                        { nama: 'Canon EOS R6', kategori: 'Kamera' },
                                        { nama: 'Sony A7III', kategori: 'Kamera' }
                                    ]
                                }; openDetail = true"
                                class="px-4 py-1.5 bg-[#22543D] text-white text-[10px] font-bold rounded-xl hover:bg-[#1a402e] transition-all shadow-sm active:scale-95">
                                    Detail
                                </button>
                            </td>
                        </tr>

                        {{-- ROW 2 --}}
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 border-r text-xs font-bold text-[#22543D]">CMP-20250722-002</td>
                            <td class="px-4 py-4 border-r text-center">
                                <span class="px-3 py-1 bg-[#ED64A6]/10 text-[#ED64A6] text-[10px] font-black rounded-lg border border-[#ED64A6]/20">Tertunda</span>
                            </td>
                            <td class="px-4 py-4 border-r text-xs font-black text-gray-400">Rp 60,000.00</td>
                            <td class="px-4 py-4 border-r text-[10px] text-gray-500 uppercase">12 Apr 2026, 16:11:45</td>
                            <td class="px-4 py-4 text-center">
                                <button @click="selectedData = {
                                    id: 'CMP-20250722-002',
                                    nama: 'Siti Rahayu',
                                    inisial: 'SR',
                                    status: 'Tertunda',
                                    statusColor: 'pink',
                                    metode: 'QRIS',
                                    total: 'Rp 60.000',
                                    mulai: '14 Mei 2026',
                                    selesai: '15 Mei 2026',
                                    items: [
                                        { nama: 'Sleeping Bag', kategori: 'Camping' }
                                    ]
                                }; openDetail = true"
                                class="px-4 py-1.5 bg-[#22543D] text-white text-[10px] font-bold rounded-xl hover:bg-[#1a402e] transition-all shadow-sm active:scale-95">
                                    Detail
                                </button>
                            </td>
                        </tr>

                        {{-- ROW 3 --}}
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 border-r text-xs font-bold text-[#22543D]">CMP-20250722-003</td>
                            <td class="px-4 py-4 border-r text-center">
                                <span class="px-3 py-1 bg-orange-50 text-orange-700 text-[10px] font-black rounded-lg border border-orange-200">Proses</span>
                            </td>
                            <td class="px-4 py-4 border-r text-xs font-black text-[#22543D]">Rp 50,000.00</td>
                            <td class="px-4 py-4 border-r text-[10px] text-gray-500 uppercase">12 Apr 2026, 16:11:45</td>
                            <td class="px-4 py-4 text-center">
                                <button @click="selectedData = {
                                    id: 'CMP-20250722-003',
                                    nama: 'Rizka Nur',
                                    inisial: 'RN',
                                    status: 'Diproses',
                                    statusColor: 'orange',
                                    metode: 'Transfer Bank',
                                    total: 'Rp 175.000',
                                    mulai: '12 Mei 2026',
                                    selesai: '15 Mei 2026',
                                    items: [
                                        { nama: 'Canon EOS R6', kategori: 'Kamera' }
                                    ]
                                }; openDetail = true"
                                class="px-4 py-1.5 bg-[#22543D] text-white text-[10px] font-bold rounded-xl hover:bg-[#1a402e] transition-all shadow-sm active:scale-95">
                                    Detail
                                </button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            {{-- FOOTER --}}
            <div class="px-6 py-4 bg-[#fcfdfb] border-t border-[#f1f8f4] flex justify-between items-center text-[10px] font-bold text-gray-400 uppercase">
                <span>Menampilkan 3 Pembayaran</span>
                <div class="flex gap-2">
                    <button class="w-9 h-9 border rounded-xl hover:bg-gray-50 transition-colors">‹</button>
                    <button class="w-9 h-9 bg-[#22543D] text-white rounded-xl shadow-md">1</button>
                    <button class="w-9 h-9 border rounded-xl hover:bg-gray-50 transition-colors">›</button>
                </div>
            </div>

        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div x-show="openDetail"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-[#22543D]/20 backdrop-blur-sm"
         x-cloak>

        <div @click.away="openDetail = false" class="bg-white w-full max-w-sm rounded-2xl shadow-xl overflow-hidden border border-gray-100">

            {{-- Header --}}
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-gray-800">Detail Transaksi</h2>
                    <p class="text-[11px] text-gray-400 mt-0.5">Admin Panel</p>
                </div>
            </div>

            {{-- deskripsi --}}
            <div class="px-5 py-4 flex flex-col gap-4 max-h-[70vh] overflow-y-auto">

                {{-- Info Pelanggan --}}
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center text-sm font-semibold text-emerald-700 shrink-0"
                         x-text="selectedData.inisial"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800" x-text="selectedData.nama"></p>
                        <p class="text-[11px] text-gray-400 font-mono" x-text="selectedData.id"></p>
                    </div>
                    <span class="text-[11px] px-2 py-1 rounded-lg shrink-0 border"
                          :class="{
                              'bg-emerald-50 text-emerald-600 border-emerald-100': selectedData.statusColor === 'emerald',
                              'bg-orange-50 text-orange-500 border-orange-100': selectedData.statusColor === 'orange',
                              'bg-pink-50 text-pink-500 border-pink-100': selectedData.statusColor === 'pink'
                          }"
                          x-text="selectedData.status"></span>
                </div>

                {{-- Pembayaran --}}
                <table class="w-full text-sm">
                    <tr>
                        <td class="py-1.5 text-gray-400">Metode</td>
                        <td class="py-1.5 text-right text-gray-700" x-text="selectedData.metode"></td>
                    </tr>
                    <tr>
                        <td class="py-1.5 text-gray-400">Total Bayar</td>
                        <td class="py-1.5 text-right font-semibold text-emerald-600" x-text="selectedData.total"></td>
                    </tr>
                </table>

                {{-- Unit Disewa --}}
                <div>
                    <p class="text-[11px] text-gray-400 font-medium mb-2 flex items-center gap-1.5">
                        Unit disewa
                        <span class="bg-gray-100 text-gray-500 text-[10px] px-2 py-0.5 rounded-full" x-text="selectedData.items ? selectedData.items.length : 0"></span>
                    </p>
                    <div class="flex flex-col gap-1.5">
                        <template x-for="item in selectedData.items" :key="item.nama">
                            <div class="flex items-center justify-between px-3 py-2 border border-gray-100 rounded-xl">
                                <span class="text-sm text-gray-700" x-text="item.nama"></span>
                                <span class="text-[11px] px-2 py-0.5 rounded-full"
                                      :class="{
                                          'bg-blue-50 text-blue-500': item.kategori === 'Kamera',
                                          'bg-emerald-50 text-emerald-600': item.kategori === 'Lensa',
                                          'bg-orange-50 text-orange-500': item.kategori === 'Mikrofon',
                                          'bg-gray-100 text-gray-500': !['Kamera','Lensa','Mikrofon'].includes(item.kategori)
                                      }"
                                      x-text="item.kategori"></span>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Tanggal --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="p-3 bg-emerald-50 border border-emerald-100 rounded-xl">
                        <p class="text-[10px] font-semibold text-emerald-600 mb-1">Mulai</p>
                        <p class="text-xs font-semibold text-emerald-700" x-text="selectedData.mulai"></p>
                    </div>
                    <div class="p-3 bg-orange-50 border border-orange-100 rounded-xl">
                        <p class="text-[10px] font-semibold text-orange-500 mb-1">Selesai</p>
                        <p class="text-xs font-semibold text-orange-600" x-text="selectedData.selesai"></p>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="px-5 py-3 border-t border-gray-100 text-center">
                <button @click="openDetail = false" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
                    Tutup
                </button>
            </div>

        </div>
    </div>

</div>

@endsection