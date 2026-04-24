@extends('layouts.pelanggan')

@section('title', 'Riwayat Sewa')

@section('content')
<div x-data="{ activeTab: 'all' }" class="anim">
    {{-- 1. Judul Halaman (Sama dengan Alamat Pengiriman) --}}
    <div class="mb-10">
        <h1 class="text-4xl font-black text-gray-800 tracking-tight">Riwayat Sewa</h1>
        <p class="text-gray-400 font-medium mt-1">Pantau dan kelola semua transaksi rental kamera & camping Anda di satu tempat.</p>
    </div>

    {{-- 2. Container Putih (Rounded Besar & Shadow Tipis) --}}
    <div class="bg-white rounded-[40px] shadow-sm border border-gray-50 p-10">

        {{-- Tab Navigation --}}
        <div class="flex flex-wrap items-center gap-2.5 mb-10 bg-gray-50 rounded-[25px] p-4 border border-gray-100 shadow-inner">
            <button @click="activeTab = 'all'"
                :class="activeTab === 'all' ? 'bg-[#1B4332] text-white shadow-md' : 'text-gray-500 hover:bg-white hover:text-green-800'"
                class="px-6 py-2.5 rounded-full text-xs font-bold transition-all duration-200">
                Semua
            </button>
            <button @click="activeTab = 'pending'"
                :class="activeTab === 'pending' ? 'bg-pink-100 text-pink-700 border-pink-200 shadow-sm' : 'text-gray-500 hover:bg-pink-50'"
                class="px-5 py-2.5 rounded-full text-xs font-bold transition-all duration-200">
                Menunggu
            </button>
            <button @click="activeTab = 'processing'"
                :class="activeTab === 'processing' ? 'bg-pink-100 text-pink-700 border-pink-200 shadow-sm' : 'text-gray-500 hover:bg-pink-50'"
                class="px-5 py-2.5 rounded-full text-xs font-bold transition-all duration-200">
                Proses
            </button>
            <button @click="activeTab = 'arrive'"
                :class="activeTab === 'arrive' ? 'bg-green-100 text-green-700 border-green-200 shadow-sm' : 'text-gray-500 hover:bg-green-50'"
                class="px-5 py-2.5 rounded-full text-xs font-bold transition-all duration-200">
                Tiba
            </button>
            <button @click="activeTab = 'returned'"
                :class="activeTab === 'returned' ? 'bg-green-100 text-green-700 border-green-200 shadow-sm' : 'text-gray-500 hover:bg-green-50'"
                class="px-5 py-2.5 rounded-full text-xs font-bold transition-all duration-200">
                Dikembalikan
            </button>
        </div>

        {{-- List Riwayat --}}
        <div class="space-y-6">
            {{-- Item 1 --}}
            <div x-show="activeTab === 'all' || activeTab === 'arrive'" x-cloak class="group bg-white p-6 rounded-[30px] border border-gray-100 flex flex-col sm:flex-row items-center gap-6 cursor-pointer hover:bg-gray-50 transition-all duration-300">
                <div class="flex items-center justify-center flex-shrink-0 w-16 h-16 bg-green-50 rounded-2xl border border-green-100">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="flex-1 space-y-1">
                    <h4 class="font-bold text-gray-800">Sewa Kamera Mirrorless Sony A7 Mark III Kit 28-70mm</h4>
                    <p class="text-[11px] font-bold text-gray-400 tracking-wider">ID PESANAN: CL-RENT-34502</p>
                    <p class="text-[11px] text-green-700 italic font-medium">Dipesan pada: 12 Jan 2026, 14:30</p>
                </div>
                <div class="text-center sm:text-right px-4">
                    <p class="text-lg font-black text-gray-900">Rp 350.000</p>
                    <span class="inline-block mt-2 px-3 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-100 uppercase">Tiba</span>
                </div>
                <button class="px-5 py-2.5 bg-gray-50 text-gray-600 rounded-xl text-xs font-bold hover:bg-[#1B4332] hover:text-white transition-all">Detail</button>
            </div>

            {{-- Item 2 --}}
            <div x-show="activeTab === 'all' || activeTab === 'pending'" x-cloak class="group bg-white p-6 rounded-[30px] border border-gray-100 flex flex-col sm:flex-row items-center gap-6 cursor-pointer hover:bg-gray-50 transition-all duration-300">
                <div class="flex items-center justify-center flex-shrink-0 w-16 h-16 bg-pink-50 rounded-2xl border border-pink-100">
                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l10 16H2L12 2z" stroke-width="1.5" />
                    </svg>
                </div>
                <div class="flex-1 space-y-1">
                    <h4 class="font-bold text-gray-800">Sewa Tenda Camping Kapasitas 4 Orang (Tenda Dome)</h4>
                    <p class="text-[11px] font-bold text-gray-400 tracking-wider">ID PESANAN: CL-RENT-34503</p>
                    <p class="text-[11px] text-pink-700 italic font-medium">Dipesan pada: 12 Jan 2026, 10:15</p>
                </div>
                <div class="text-center sm:text-right px-4">
                    <p class="text-lg font-black text-gray-900">Rp 120.000</p>
                    <span class="inline-block mt-2 px-3 py-1 rounded-full text-[10px] font-bold bg-pink-50 text-pink-700 border border-pink-100 uppercase">Pending</span>
                </div>
                <button class="px-5 py-2.5 bg-gray-50 text-gray-600 rounded-xl text-xs font-bold hover:bg-[#1B4332] hover:text-white transition-all">Detail</button>
            </div>
        </div>

        <footer class="mt-16 text-center text-[10px] font-bold text-gray-300 uppercase tracking-widest">
            &copy; 2026 Camplore - All Rights Reserved.
        </footer>
    </div>
</div>
@endsection