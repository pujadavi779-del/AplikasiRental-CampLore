@extends('layouts.admin')

@section('title', 'Kategori Produk - Camplore Admin')

@section('content')

<div class="mb-6">
    @include('components.navbar_judul_LP', [
        'NavParent' => 'Manajemen Operasional',
        'section' => 'Kategori Produk'
    ])
</div>

<div class="max-w-full">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        
        <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden p-6">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h3l2-2h6l2 2h3a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2zm8 3a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 2a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#22543D]">Kamera</h3>
                </div>
                <div class="flex gap-2">
                    <button class="px-3 py-1.5 border border-gray-200 rounded-lg text-[11px] font-bold text-gray-500 hover:bg-gray-50 transition-colors">+ Tipe</button>
                    <button class="px-3 py-1.5 border border-gray-200 rounded-lg text-[11px] font-bold text-gray-500 hover:bg-gray-50 transition-colors">+ Merek</button>
                </div>
            </div>

            <div class="mb-8">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tipe Kamera</h4>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">{{ count($tipeKamera) }} Item</span>
                </div>
                <div class="border border-[#eef4f0] rounded-2xl overflow-hidden">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-[#fcfdfb] border-b border-[#eef4f0] text-[10px] font-black uppercase text-gray-500 tracking-wider">
                            <tr>
                                <th class="px-4 py-3">Nama Tipe</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#eef4f0]">
                            @foreach($tipeKamera as $tipe)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4 font-semibold text-[#22543D]">{{ $tipe['nama'] }}</td>
                                <td class="px-4 py-4 text-right flex justify-end gap-3 text-xs">
                                    <button class="text-gray-400 hover:text-[#22543D] font-bold">Edit</button>
                                    <button class="text-red-300 hover:text-red-500 font-bold">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Merek Kamera</h4>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">{{ count($merekKamera) }} Item</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($merekKamera as $merek)
                    <div class="px-6 py-4 bg-white border border-gray-200 rounded-xl text-sm font-bold text-[#22543D] shadow-sm min-w-[100px] text-center">
                        {{ $merek }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden p-6">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 24 24"><path d="M11.5 3L2 21h19L11.5 3zm0 4.83L17.17 19H5.83L11.5 7.83z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#22543D]">Camping</h3>
                </div>
                <div class="flex gap-2">
                    <button class="px-3 py-1.5 border border-gray-200 rounded-lg text-[11px] font-bold text-gray-500 hover:bg-gray-50 transition-colors">+ Tipe</button>
                    <button class="px-3 py-1.5 border border-gray-200 rounded-lg text-[11px] font-bold text-gray-500 hover:bg-gray-50 transition-colors">+ Merek</button>
                </div>
            </div>

            <div class="mb-8">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tipe Peralatan</h4>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">{{ count($tipeCamping) }} Item</span>
                </div>
                <div class="border border-[#eef4f0] rounded-2xl overflow-hidden">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-[#fcfdfb] border-b border-[#eef4f0] text-[10px] font-black uppercase text-gray-500 tracking-wider">
                            <tr>
                                <th class="px-4 py-3">Nama Tipe</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#eef4f0]">
                            @foreach($tipeCamping as $tipe)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4 font-semibold text-[#22543D]">{{ $tipe['nama'] }}</td>
                                <td class="px-4 py-4 text-right flex justify-end gap-3 text-xs">
                                    <button class="text-gray-400 hover:text-[#22543D] font-bold">Edit</button>
                                    <button class="text-red-300 hover:text-red-500 font-bold">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Merek Outdoor</h4>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">{{ count($merekCamping) }} Item</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($merekCamping as $merek)
                    <div class="px-6 py-4 bg-white border border-gray-200 rounded-xl text-sm font-bold text-[#22543D] shadow-sm min-w-[100px] text-center">
                        {{ $merek }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-[#F8FAFA] border border-[#d7e6de] p-6 rounded-[28px] flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-[#22543D]/5 rounded-2xl flex items-center justify-center text-[#22543D]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Total Tipe</p>
                <p class="text-xl font-black text-[#22543D]">{{ $stats['total_variasi'] }} Variasi</p>
            </div>
        </div>

        <div class="bg-[#F8FAFA] border border-[#d7e6de] p-6 rounded-[28px] flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-[#22543D]/5 rounded-2xl flex items-center justify-center text-[#22543D]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Total Merek</p>
                <p class="text-xl font-black text-[#22543D]">{{ $stats['total_brand'] }} Brand</p>
            </div>
        </div>

        <div class="bg-[#F8FAFA] border border-[#d7e6de] p-6 rounded-[28px] flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-[#22543D]/5 rounded-2xl flex items-center justify-center text-[#22543D]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Produk Tertaut</p>
                <p class="text-xl font-black text-[#22543D]">{{ $stats['produk_tertaut'] }} Unit</p>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600;700;800;900&display=swap');
    body { font-family: 'Inter', sans-serif; }
</style>

@endsection