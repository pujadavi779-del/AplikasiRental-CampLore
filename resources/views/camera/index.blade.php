@extends('admin.admin')

@section('title', 'List Barang Camera')
@section('page-title', 'Koleksi Kamera')

@section('content')
<div class="relative overflow-hidden rounded-2xl border border-[rgba(106,170,42,0.18)] bg-[#0e1a06] p-6 shadow-2xl">
    {{-- Header Tabel --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <div>
            <h2 class="text-xl font-semibold text-[#d4f0a0] font-['DM_Serif_Display']">Data Inventaris Kamera</h2>
            <p class="text-sm text-[#6a8a50]">Kelola stok dan unit kamera tersedia untuk disewa.</p>
        </div>
        <button class="n-add !w-fit">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M12 5v14M5 12h14" />
            </svg>
            Tambah Kamera Baru
        </button>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-[#a8c880]">
            <thead class="bg-[#243810] text-[#d4f0a0] uppercase text-xs font-bold tracking-wider">
                <tr>
                    <th class="px-6 py-4 rounded-tl-xl">Unit Kamera</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Harga Sewa</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 rounded-tr-xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[rgba(106,170,42,0.1)]">
                {{-- Contoh Data 1 --}}
                <tr class="hover:bg-[#182808] transition-colors">
                    <td class="px-6 py-4 flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg bg-gray-800 border border-[#6aaa2a33] flex items-center justify-center overflow-hidden">
                             <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=100" alt="camera">
                        </div>
                        <div>
                            <div class="font-medium text-[#e8f5d0]">Sony A7 III</div>
                            <div class="text-[10px] text-[#6a8a50]">Mirrorless Full Frame</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">Professional</td>
                    <td class="px-6 py-4 text-[#8acc44]">Rp 350.000 <span class="text-[10px] text-gray-500">/hari</span></td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-[10px] bg-[#6aaa2a22] text-[#8acc44] border border-[#6aaa2a44]">Tersedia</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <button class="p-2 hover:bg-[#6aaa2a22] rounded-lg transition-colors text-[#8acc44]">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                            </button>
                            <button class="p-2 hover:bg-red-900/20 rounded-lg transition-colors text-red-400">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>

                {{-- Contoh Data 2 --}}
                <tr class="hover:bg-[#182808] transition-colors">
                    <td class="px-6 py-4 flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg bg-gray-800 border border-[#6aaa2a33] flex items-center justify-center overflow-hidden">
                             <img src="https://images.unsplash.com/photo-1502920917128-1aa500764cbd?q=80&w=100" alt="camera">
                        </div>
                        <div>
                            <div class="font-medium text-[#e8f5d0]">Fujifilm X-T4</div>
                            <div class="text-[10px] text-[#6a8a50]">APS-C Mirrorless</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">Semi-Pro</td>
                    <td class="px-6 py-4 text-[#8acc44]">Rp 250.000 <span class="text-[10px] text-gray-500">/hari</span></td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-[10px] bg-yellow-500/10 text-yellow-500 border border-yellow-500/30">Disewa</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
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

    {{-- Footer Tabel / Pagination --}}
    <div class="mt-6 flex items-center justify-between">
        <p class="text-xs text-[#6a8a50]">Menampilkan 2 dari 12 kamera</p>
        <div class="flex gap-2">
            <button class="px-3 py-1 border border-[#6aaa2a44] rounded text-[#8acc44] hover:bg-[#6aaa2a11] text-xs transition-all">Prev</button>
            <button class="px-3 py-1 border border-[#6aaa2a44] rounded text-[#8acc44] hover:bg-[#6aaa2a11] text-xs transition-all">Next</button>
        </div>
    </div>
</div>
@endsection