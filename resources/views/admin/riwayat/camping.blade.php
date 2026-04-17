@extends('layouts.admin')

@section('title', 'Riwayat Alat Camping - Camplore')
@section('page-title', 'Riwayat Alat Camping')

@section('breadcrumb')
<span class="text-gray-300">/</span>
<span class="text-gray-300">Riwayat</span>
<span class="text-gray-300">/</span>
<span class="text-[#22543D] font-semibold">Camping</span>
@endsection

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-xl font-extrabold text-gray-800">Log Penggunaan Alat Camping</h2>
        <p class="text-gray-400 text-sm mt-0.5">Histori penggunaan perlengkapan outdoor.</p>
    </div>

    {{-- Daftar Aset Camping --}}
    <div class="grid grid-cols-1 gap-6">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4" class="w-12 h-12 rounded-xl object-cover shadow-sm">
                    <div>
                        <h3 class="font-bold text-[#22543D]">Tenda Dome Arpenaz 4.1</h3>
                        <p class="text-[10px] text-gray-400 font-mono uppercase">SN: TENT-099</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Total Pakai</span>
                    <p class="text-lg font-black text-[#ED64A6]">42 <span class="text-[10px]">Hari</span></p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50/50 text-[10px] font-bold uppercase tracking-widest text-gray-400 border-b border-gray-100">
                        <tr>
                            <th class="px-8 py-3 text-left">Penyewa</th>
                            <th class="px-6 py-3 text-left">Periode Sewa</th>
                            <th class="px-6 py-3 text-center">Durasi</th>
                            <th class="px-8 py-3 text-right">Biaya</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 rounded-full bg-pink-100 text-[#ED64A6] flex items-center justify-center font-bold text-[10px]">AS</div>
                                    <span class="font-bold text-gray-700">Alice Smith</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-500">12 Apr 2026 - 17 Apr 2026</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-[10px] font-bold italic">5 Hari</span>
                            </td>
                            <td class="px-8 py-4 text-right font-bold text-[#22543D]">Rp 250.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection