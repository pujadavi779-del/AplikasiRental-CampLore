@extends('admin.admin') {{-- Pastikan ini nama layout utama kamu --}}

@section('title', 'Riwayat Kamera - Camplore')

{{-- Kita titipkan nama buat navbar ke layout utama --}}
@section('NavParent', 'Riwayat Produk')
@section('section', 'Kamera')

@section('content')
<div class="mt-6"> {{-- Pakai mt-6 biar ada jarak dikit sama navbar atas --}}
    <div class="bg-white rounded-[32px] border border-[#d7e6de] shadow-sm overflow-hidden">
        {{-- Header Card --}}
        <div class="p-6 border-b border-[#eef4f0] bg-[#f1f8f4]/50 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl overflow-hidden border-2 border-white shadow-md">
                    <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32" class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 class="text-lg font-bold text-[#22543D]">Sony A7 III (Body Only)</h3>
                    <span class="text-[10px] bg-[#22543D] text-white px-2 py-0.5 rounded-md font-bold uppercase tracking-widest">SN-CAM-001</span>
                </div>
            </div>
            <div class="text-right">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Total Durasi</p>
                <p class="text-xl font-bold text-[#ED64A6]">15 Hari</p>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50/50 text-[10px] font-bold uppercase tracking-widest text-gray-400 border-b border-[#eef4f0]">
                    <tr>
                        <th class="px-8 py-3">Nama Pelanggan</th>
                        <th class="px-4 py-3">Periode Sewa</th>
                        <th class="px-4 py-3 text-center">Durasi</th>
                        <th class="px-8 py-3 text-right">Biaya Sewa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#eef4f0]">
                    <tr class="hover:bg-[#fcfdfb] transition-colors text-[#22543D]">
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-pink-100 text-[#ED64A6] flex items-center justify-center font-bold text-[10px]">AP</div>
                                <span class="font-bold">Andi Pratama</span>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-gray-500 font-medium">14 Apr 2026 - 17 Apr 2026</td>
                        <td class="px-4 py-4 text-center">
                            <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 font-bold text-[10px]">3 Hari</span>
                        </td>
                        <td class="px-8 py-4 text-right font-bold">Rp 450.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection