@extends('layouts.dashboard_pelanggan')
@section('title', $product['name'].' - Camplore')

@section('content')
<section class="py-16 max-w-5xl mx-auto px-4">
    <a href="javascript:history.back()" class="text-sm text-gray-400 hover:text-[#22543D] transition">← Kembali</a>

    <div class="mt-6 bg-white rounded-3xl shadow-sm border border-pink-100 overflow-hidden grid md:grid-cols-2 gap-0">

        {{-- Foto --}}
        <div class="aspect-square overflow-hidden">
            <img src="{{ $product['img'] }}" class="w-full h-full object-cover">
        </div>

        {{-- Detail --}}
        <div class="p-8 flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold text-[#22543D] bg-emerald-100 px-3 py-1 rounded-full">{{ $product['category'] }}</span>
                <h1 class="text-3xl font-extrabold text-gray-800 mt-4 mb-2">{{ $product['name'] }}</h1>
                <p class="text-[#ED64A6] font-extrabold text-2xl mb-5">{{ $product['price_label'] }}</p>
                <p class="text-gray-600 leading-relaxed mb-6">{{ $product['desc'] }}</p>

                {{-- Spec --}}
                <div class="bg-gray-50 rounded-2xl p-4 mb-6">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Spesifikasi</p>
                    <p class="text-sm text-gray-700 font-medium">{{ $product['spec'] }}</p>
                </div>

                {{-- Tanggal --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-2">Tanggal Mulai</label>
                        <input type="date" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#22543D]" min="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-2">Tanggal Selesai</label>
                        <input type="date" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#22543D]" min="{{ date('Y-m-d') }}">
                    </div>
                </div>
            </div>

            <button class="w-full py-4 bg-[#22543D] hover:bg-[#ED64A6] text-white rounded-2xl font-bold text-base transition shadow-sm">
                🛒 Tambah ke Keranjang
            </button>
        </div>
    </div>
</section>
@endsection