@extends('layouts.dashboard_pelanggan')
@section('title', 'Camping - Camplore')

@section('content')
<section class="py-16 max-w-7xl mx-auto px-4">
    <div class="mb-10" data-aos="fade-up">
        <a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-[#22543D] transition">← Kembali</a>
        <h1 class="text-4xl font-extrabold text-[#22543D] mt-3"> Camping Collection</h1>
        <p class="text-gray-500 mt-2">Lengkapi gear campingmu dari sini.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach($products as $i => $item)
        <a href="{{ route('product.detail', $item['id']) }}" class="bg-white rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all border border-pink-100 group" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
            <div class="overflow-hidden rounded-2xl mb-5 aspect-[4/3] bg-gray-100">
                <img src="{{ $item['img'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            </div>
            <span class="text-xs font-bold text-[#22543D] bg-emerald-100 px-3 py-1 rounded-full">{{ $item['category'] }}</span>
            <h3 class="font-bold text-lg text-gray-800 mt-3">{{ $item['name'] }}</h3>
            <p class="text-[#ED64A6] font-extrabold text-xl mt-1 mb-4">{{ $item['price_label'] }}</p>
            <div class="w-full py-2.5 bg-[#22543D] text-white rounded-xl font-bold text-sm text-center group-hover:bg-[#ED64A6] transition">Lihat Detail →</div>
        </a>
        @endforeach
    </div>
</section>
@endsection