@extends('layouts.admin')

@section('title', 'Transaksi Pembayaran - CampLore')

@section('content')

<div class="fixed top-5 right-6 z-40 left-[calc(272px+24px)] max-sm:left-6 animate-fade-up">
    @include('components.navbar_judul_LP', [
    'NavParent' => 'Manajemen Pesanan',
    'section' => 'Transaksi Pembayaran'
    ])
</div>

<div class="max-w-full ">
    <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0]">
            <div>
                <h2 class="text-2xl font-bold text-[#22543D] font-serif leading-tight">
                    Pembayaran
                </h2>
                <p class="text-[11px] text-[#7c8b84] mt-0.5">
                    Daftar semua transaksi pembayaran sewa unit.
                </p>
            </div>
        </div>

        {{-- SEARCH BAR --}}
        <div class="p-6 border-b border-[#f1f8f4]">
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" />
                    </svg>
                </span>
                <input type="text" placeholder="Cari Order ID atau Invoice..."
                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-[#d7e6de] rounded-xl text-xs focus:ring-1 focus:ring-[#ED64A6] focus:border-[#ED64A6] outline-none shadow-inner transition-all">
            </div>
        </div>

        {{-- DATA TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left table-fixed min-w-[1100px]">
                <thead class="bg-[#f1f8f4] text-[#22543D] uppercase text-[10px] font-bold tracking-widest border-b border-[#e4f0ea]">
                    <tr>
                        <th class="px-6 py-4 w-10 border-r border-[#e4f0ea]"><input type="checkbox" class="accent-[#22543D]"></th>
                        <th class="px-4 py-4 border-r border-[#e4f0ea] w-[15%]">ID Pesanan</th>
                        <th class="px-4 py-4 border-r border-[#e4f0ea] w-[30%]">Midtrans ID Pesanan</th>
                        <th class="px-4 py-4 border-r border-[#e4f0ea] w-[12%] text-center">Status</th>
                        <th class="px-4 py-4 border-r border-[#e4f0ea] w-[15%]">Harga yang Dibayar</th>
                        <th class="px-4 py-4 border-r border-[#e4f0ea] w-[18%]">Dibuat</th>
                        <th class="px-6 py-4 text-center w-[10%]">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#eef4f0]">

                    {{-- Row 1 --}}
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 border-r border-[#eef4f0]"><input type="checkbox" class="accent-[#22543D]"></td>
                        <td class="px-4 py-4 border-r border-[#eef4f0] text-xs font-bold text-[#22543D]">INV-2026001</td>
                        <td class="px-4 py-4 border-r border-[#eef4f0] text-[11px] font-mono text-gray-600 bg-gray-50/50">ORDER-6-1752939109</td>

                        <td class="px-4 py-4 text-center border-r border-[#eef4f0]">
                            <span class="inline-block px-3 py-1 bg-emerald-100 text-[#22543D] text-[10px] font-bold rounded-lg border border-emerald-200">
                                Dibayar
                            </span>
                        </td>

                        <td class="px-4 py-4 border-r border-[#eef4f0] text-xs font-black text-[#22543D]">IDR 150,000.00</td>
                        <td class="px-4 py-4 border-r border-[#eef4f0] text-[10px] text-gray-500 uppercase">12 Apr 2026, 14:35:10</td>

                        <td class="px-6 py-4 text-center">
                            <button class="text-[#ED64A6] hover:bg-[#ED64A6]/10 px-3 py-1.5 rounded-lg transition-colors font-bold text-[10px] flex items-center justify-center gap-1 border border-transparent hover:border-[#ED64A6]/20">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Edit
                            </button>
                        </td>
                    </tr>

                    {{-- Row 2 --}}
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 border-r border-[#eef4f0]"><input type="checkbox" class="accent-[#22543D]"></td>
                        <td class="px-4 py-4 border-r border-[#eef4f0] text-xs font-bold text-[#22543D]">INV-2026002</td>
                        <td class="px-4 py-4 border-r border-[#eef4f0] text-[11px] font-mono text-gray-600 bg-gray-50/50">ORDER-9-1752940884</td>

                        <td class="px-4 py-4 text-center border-r border-[#eef4f0]">
                            <span class="inline-block px-3 py-1 bg-[#ED64A6]/10 text-[#ED64A6] text-[10px] font-black rounded-lg border border-[#ED64A6]/20 shadow-inner">
                                Tertunda
                            </span>
                        </td>

                        <td class="px-4 py-4 border-r border-[#eef4f0] text-xs font-black text-gray-400">IDR 0.00</td>
                        <td class="px-4 py-4 border-r border-[#eef4f0] text-[10px] text-gray-500 uppercase">12 Apr 2026, 16:11:45</td>

                        <td class="px-6 py-4 text-center">
                            <button class="text-[#ED64A6] hover:bg-[#ED64A6]/10 px-3 py-1.5 rounded-lg transition-colors font-bold text-[10px] flex items-center justify-center gap-1 border border-transparent hover:border-[#ED64A6]/20">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Edit
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- PAGINATION / FOOTER --}}
        <div class="px-6 py-4 bg-[#fcfdfb] border-t border-[#f1f8f4] flex justify-between items-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">
            <span>Showing {{ $payments->count() ?? '2' }} Payments</span>
            <div class="flex gap-2">
                <button class="w-9 h-9 flex items-center justify-center border border-[#d7e6de] rounded-xl hover:bg-gray-50 transition shadow-inner">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="w-9 h-9 flex items-center justify-center bg-[#22543D] text-white rounded-xl shadow-lg shadow-[#22543D]/20">1</button>
                <button class="w-9 h-9 flex items-center justify-center border border-[#d7e6de] rounded-xl hover:bg-gray-50 transition shadow-inner">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- CSS KHUSUS --}}
<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    /* Mencegah teks Midtrans Order ID melebar */
    .table-fixed {
        table-layout: fixed;
    }

    .break-words {
        word-break: break-all;
    }
</style>

@endsection