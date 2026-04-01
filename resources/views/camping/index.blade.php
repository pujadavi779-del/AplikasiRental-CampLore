@extends('admin.admin')

@section('title', 'List Barang Camping')
@section('page-title', 'Peralatan Camping')

@section('content')
<div class="relative overflow-hidden rounded-2xl border border-[rgba(106,170,42,0.18)] bg-[#0e1a06] p-6 shadow-2xl">
    {{-- Header Tabel --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <div>
            <h2 class="text-xl font-semibold text-[#d4f0a0] font-['DM_Serif_Display']">Inventaris Alat Outdoor</h2>
            <p class="text-sm text-[#6a8a50]">Manajemen stok perlengkapan mendaki dan berkemah.</p>
        </div>
        <button class="n-add !w-fit">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M12 5v14M5 12h14" />
            </svg>
            Tambah Alat Baru
        </button>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-[#a8c880]">
            <thead class="bg-[#243810] text-[#d4f0a0] uppercase text-xs font-bold tracking-wider">
                <tr>
                    <th class="px-6 py-4 rounded-tl-xl">Nama Alat</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Stok</th>
                    <th class="px-6 py-4">Harga Sewa</th>
                    <th class="px-6 py-4">Kondisi</th>
                    <th class="px-6 py-4 rounded-tr-xl text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[rgba(106,170,42,0.1)]">
                {{-- Data 1: Tenda --}}
                <tr class="hover:bg-[#182808] transition-colors">
                    <td class="px-6 py-4 flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg bg-gray-800 border border-[#6aaa2a33] flex items-center justify-center overflow-hidden">
                             <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=100" alt="tent">
                        </div>
                        <div>
                            <div class="font-medium text-[#e8f5d0]">Tenda Eiger Guardian 4P</div>
                            <div class="text-[10px] text-[#6a8a50]">Double Layer / Waterproof</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">Shelter</td>
                    <td class="px-6 py-4 font-mono">08 unit</td>
                    <td class="px-6 py-4 text-[#8acc44]">Rp 85.000</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-[10px] bg-[#6aaa2a22] text-[#8acc44] border border-[#6aaa2a44]">Sangat Baik</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-2">
                            <button class="p-2 hover:bg-[#6aaa2a22] rounded-lg transition-colors text-[#8acc44]">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                            </button>
                            <button class="p-2 hover:bg-red-900/20 rounded-lg transition-colors text-red-400">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>

                {{-- Data 2: Carrier --}}
                <tr class="hover:bg-[#182808] transition-colors">
                    <td class="px-6 py-4 flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg bg-gray-800 border border-[#6aaa2a33] flex items-center justify-center overflow-hidden">
                             <img src="https://images.unsplash.com/photo-1622260614153-03223fb72052?q=80&w=100" alt="backpack">
                        </div>
                        <div>
                            <div class="font-medium text-[#e8f5d0]">Carrier Osprey Atmos 65L</div>
                            <div class="text-[10px] text-[#6a8a50]">Anti-Gravity System</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">Backpack</td>
                    <td class="px-6 py-4 font-mono text-red-400">02 unit</td>
                    <td class="px-6 py-4 text-[#8acc44]">Rp 120.000</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-[10px] bg-yellow-500/10 text-yellow-500 border border-yellow-500/30">Butuh Cuci</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-2">
                             <button class="p-2 hover:bg-[#6aaa2a22] rounded-lg transition-colors text-[#8acc44]">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                            </button>
                            <button class="p-2 hover:bg-red-900/20 rounded-lg transition-colors text-red-400">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-xs text-[#6a8a50]">
            Menunjukkan stok barang aktif di gudang utama.
        </div>
        <div class="flex items-center gap-4">
            <span class="text-xs text-[#a8c880]">Page 1 of 5</span>
            <div class="flex gap-1">
                <button class="w-8 h-8 flex items-center justify-center border border-[#6aaa2a44] rounded text-[#8acc44] hover:bg-[#6aaa2a11] transition-all cursor-not-allowed opacity-50">&lt;</button>
                <button class="w-8 h-8 flex items-center justify-center border border-[#6aaa2a44] rounded text-[#8acc44] hover:bg-[#6aaa2a11] transition-all">&gt;</button>
            </div>
        </div>
    </div>
</div>
@endsection