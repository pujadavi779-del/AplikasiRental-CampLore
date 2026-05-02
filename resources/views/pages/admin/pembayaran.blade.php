@extends('layouts.admin')

@section('title', 'Transaksi Pembayaran - CampLore')

@section('content')

<div class="mb-6">
    @include('components.navbar_judul_LP', [
        'NavParent' => 'Manajemen Pesanan',
        'section' => 'Transaksi Pembayaran'
    ])
</div>

<div class="max-w-full">
    <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

        {{-- HEADER --}}
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

        {{-- SEARCH --}}
        <div class="p-6 border-b border-[#f1f8f4]">
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" />
                    </svg>
                </span>
                <input type="text"
                    placeholder="Cari Order ID atau Invoice..."
                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-[#d7e6de] rounded-xl text-xs focus:ring-1 focus:ring-[#ED64A6] focus:border-[#ED64A6] outline-none shadow-inner">
            </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left table-fixed min-w-[900px]">
                <thead class="bg-[#f1f8f4] text-[#22543D] uppercase text-[10px] font-bold tracking-widest border-b border-[#e4f0ea]">
                    <tr>
                        <th class="px-6 py-4 w-10 border-r border-[#e4f0ea]">
                            <input type="checkbox" class="accent-[#22543D]">
                        </th>
                        <th class="px-4 py-4 border-r border-[#e4f0ea] w-[20%]">
                            ID Pesanan
                        </th>
                        <th class="px-4 py-4 border-r border-[#e4f0ea] w-[15%] text-center">
                            Status
                        </th>
                        <th class="px-4 py-4 border-r border-[#e4f0ea] w-[25%]">
                            Harga yang Dibayar
                        </th>
                        <th class="px-4 py-4 w-[30%]">
                            Dibuat
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#eef4f0]">

                    {{-- ROW 1 --}}
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 border-r">
                            <input type="checkbox" class="accent-[#22543D]">
                        </td>
                        <td class="px-4 py-4 border-r text-xs font-bold text-[#22543D]">
                            CMP-20250722-001
                        </td>
                        <td class="px-4 py-4 border-r text-center">
                            <span class="px-3 py-1 bg-emerald-100 text-[#22543D] text-[10px] font-bold rounded-lg border border-emerald-200">
                                Dibayar
                            </span>
                        </td>
                        <td class="px-4 py-4 border-r text-xs font-black text-[#22543D]">
                            IDR 150,000.00
                        </td>
                        <td class="px-4 py-4 text-[10px] text-gray-500 uppercase">
                            12 Apr 2026, 14:35:10
                        </td>
                    </tr>

                    {{-- ROW 2 --}}
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 border-r">
                            <input type="checkbox" class="accent-[#22543D]">
                        </td>
                        <td class="px-4 py-4 border-r text-xs font-bold text-[#22543D]">
                            CMP-20250722-001
                        </td>
                        <td class="px-4 py-4 border-r text-center">
                            <span class="px-3 py-1 bg-[#ED64A6]/10 text-[#ED64A6] text-[10px] font-black rounded-lg border border-[#ED64A6]/20">
                                Tertunda
                            </span>
                        </td>
                        <td class="px-4 py-4 border-r text-xs font-black text-gray-400">
                            IDR 0.00
                        </td>
                        <td class="px-4 py-4 text-[10px] text-gray-500 uppercase">
                            12 Apr 2026, 16:11:45
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        {{-- FOOTER --}}
        <div class="px-6 py-4 bg-[#fcfdfb] border-t border-[#f1f8f4] flex justify-between items-center text-[10px] font-bold text-gray-400 uppercase">
            <span>Showing {{ $payments->count() ?? 2 }} Payments</span>
            <div class="flex gap-2">
                <button class="w-9 h-9 border rounded-xl">‹</button>
                <button class="w-9 h-9 bg-[#22543D] text-white rounded-xl">1</button>
                <button class="w-9 h-9 border rounded-xl">›</button>
            </div>
        </div>

    </div>
</div>

@endsection