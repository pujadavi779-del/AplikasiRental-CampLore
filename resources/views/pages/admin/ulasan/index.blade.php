@extends('layouts.admin')

@section('title', 'Ulasan Pelanggan - Camplore Admin')

@php
    $NavParent = 'Manajemen Operasional';
    $section   = 'Ulasan Pelanggan';
@endphp

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="mb-6 flex items-start justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-[#22543D]" style="font-family:'Playfair Display',serif;">Ulasan Pelanggan</h1>
        <p class="text-sm text-gray-400 mt-1">{{ $reviews->total() }} ulasan &bull; {{ $unrepliedCount }} belum ditanggapi</p>
    </div>

    {{-- Filter Pills --}}
    <div class="flex items-center gap-1 bg-white border border-[#e8f4ed] rounded-xl p-1 flex-shrink-0">
        @foreach([['all','Semua'],['unreplied','Belum Dibalas'],['replied','Sudah Dibalas']] as [$val,$label])
        <a href="{{ request()->fullUrlWithQuery(['filter' => $val]) }}"
            class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-colors no-underline
            {{ request('filter','all') == $val
                ? ($val=='unreplied' ? 'bg-[#ED64A6] text-white' : ($val=='replied' ? 'bg-[#6366f1] text-white' : 'bg-[#22543D] text-white'))
                : 'text-gray-400 hover:text-gray-700' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
<div class="mb-5 flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium px-4 py-3 rounded-xl">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

@if($reviews->isEmpty())
<div class="bg-white rounded-2xl border border-gray-100 px-8 py-20 text-center">
    <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
    </svg>
    <p class="text-gray-400 font-medium">Tidak ada ulasan ditemukan</p>
</div>

@else

{{-- Group ulasan per produk --}}
@php
    $grouped = $reviews->getCollection()->groupBy('product_id');
@endphp

<div class="space-y-5">
@foreach($grouped as $productId => $productReviews)
@php
    $product   = $productReviews->first()->product;
    $avgBintang = round($productReviews->avg('bintang'), 1);
    $totalUlasan = $productReviews->count();
@endphp

{{-- Card per produk --}}
<div class="bg-white rounded-2xl border border-[#e5e7eb] overflow-hidden">

    {{-- Product Header --}}
    <div class="flex items-center gap-4 px-5 py-4 border-b border-[#f0f0f0] bg-[#fafafa]">
        {{-- Foto produk --}}
        <div class="w-16 h-16 rounded-xl border border-gray-100 overflow-hidden flex-shrink-0 bg-gray-50">
            @if($product && $product->gambar_barang)
            <img src="{{ Str::startsWith($product->gambar_barang, 'http') 
                ? $product->gambar_barang 
                : asset($product->gambar_barang) }}" 
                alt="{{ $product->name}}"
                class="w-full h-full object-cover">
            @else                                                                                           
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                </svg>
            </div>
            @endif
        </div>

        <div class="flex-1 min-w-0">
            <p class="text-sm font-bold text-gray-900">{{ $product->name?? 'Produk Dihapus' }}</p>
            <div class="flex items-center gap-2 mt-1">
                <div class="flex items-center gap-0.5">
                    @for($i = 1; $i <= 5; $i++)
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24"
                        fill="{{ $i <= round($avgBintang) ? '#EF9F27' : '#e5e7eb' }}"
                        stroke="{{ $i <= round($avgBintang) ? '#EF9F27' : '#d1d5db' }}"
                        stroke-width="1.5">
                        <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                    </svg>
                    @endfor
                </div>
                <span class="text-xs font-bold text-[#BA7517]">{{ $avgBintang }}</span>
                <span class="text-xs text-gray-400">&bull; {{ $totalUlasan }} ulasan</span>
            </div>
        </div>

        {{-- Badge kategori --}}
        <!-- @if($product)
        <span class="flex-shrink-0 px-3 py-1 rounded-full text-[11px] font-bold
            {{ strtolower($product->Kategori_data ?? '') === 'kamera'
                ? 'bg-blue-50 text-blue-600'
                : 'bg-emerald-50 text-emerald-700' }}">
            {{ $product->Kategori_data ?? 'Produk' }}
        </span>
        @endif -->
    </div>

    {{-- List komentar --}}
<div class="divide-y divide-[#f5f5f5]">
@foreach($productReviews as $review)
<div class="px-5 py-4" x-data="{ showReply: false }">

    {{-- Baris atas: avatar + nama + waktu + status --}}
    <div class="flex items-center gap-3 mb-3">
        @php
        $avatarColors  = ['#22543D','#ED64A6','#6366f1','#f59e0b','#ef4444'];
        $aColor        = $avatarColors[$loop->index % 5];
        $fotoPelanggan = $review->pelanggan->foto_profile ?? null;
        @endphp
        <div class="w-9 h-9 rounded-full overflow-hidden flex-shrink-0 border border-gray-100">
            @if($fotoPelanggan)
                <img src="{{ asset('storage/'.$fotoPelanggan) }}"
                    alt="{{ $review->pelanggan->nama_lengkap}}"
                    class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-white text-xs font-bold"
                    style="background: {{ $aColor }}">
                    {{ strtoupper(substr($review->pelanggan->nama_lengkap?? 'U', 0, 2)) }}
                </div>
            @endif
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <span class="text-sm font-semibold text-gray-800">{{ $review->pelanggan->nama_lengkap ?? 'Pengguna' }}</span>
            <span class="text-[11px] text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
            @if($review->is_replied)
            <span class="text-[10px] font-bold text-[#0F6E56] bg-[#E1F5EE] px-2 py-0.5 rounded-full">✓ Dibalas</span>
            @else
            <span class="text-[10px] font-bold text-[#993556] bg-[#FBEAF0] px-2 py-0.5 rounded-full">Belum Dibalas</span>
            @endif
        </div>
        <div class="ml-auto">
            <button @click="showReply = !showReply"
                class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-xl transition-all border"
                :class="showReply ? 'bg-gray-100 border-gray-200 text-gray-400' : '{{ $review->is_replied ? 'bg-white border-gray-200 text-gray-500' : 'bg-[#22543D] border-[#22543D] text-white' }}'">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <span x-text="showReply ? 'Batal' : '{{ $review->is_replied ? 'Edit' : 'Balas' }}'"></span>
            </button>
        </div>
    </div>

    {{-- Bintang --}}
    <div class="flex items-center gap-0.5 mb-2 pl-12">
        @for($i = 1; $i <= 5; $i++)
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24"
            fill="{{ $i <= $review->bintang ? '#EF9F27' : '#e5e7eb' }}"
            stroke="{{ $i <= $review->bintang ? '#EF9F27' : '#d1d5db' }}"
            stroke-width="1.5">
            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
        </svg>
        @endfor
    </div>

    {{-- Komentar --}}
    <p class="text-sm text-gray-700 leading-relaxed pl-12 mb-3">{{ $review->komentar }}</p>

    {{-- Balasan admin --}}
    @if($review->is_replied && $review->balas_pesan)
    <div class="ml-12 bg-[#f9fdfb] border-l-[3px] border-[#22543D] rounded-r-lg px-3 py-2.5 mb-3">
        <p class="text-[10px] font-bold text-[#22543D] uppercase tracking-wide mb-1">Balasan Admin</p>
        <p class="text-xs text-gray-600 leading-relaxed">{{ $review->balas_pesan }}</p>
    </div>
    @endif

    {{-- Form balas --}}
    <div x-show="showReply" x-cloak class="ml-12 mt-2"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0">
        <form action="{{ route('admin.reviews.balas_pesan', $review->id_review) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-gray-50 rounded-xl border border-gray-100 p-3">
                <textarea name="balas_pesan" rows="2" placeholder="Tulis balasan..."
                    class="w-full text-sm text-gray-700 bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#22543D] resize-none">{{ $review->balas_pesan ?? '' }}</textarea>
                <div class="flex justify-end gap-2 mt-2">
                    <button type="button" @click="showReply = false"
                        class="px-3 py-1.5 text-xs text-gray-400 hover:text-gray-600 transition">Batal</button>
                    <button type="submit"
                        class="flex items-center gap-1.5 px-4 py-1.5 bg-[#22543D] hover:bg-[#1a3d2e] text-white text-xs font-semibold rounded-lg transition">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                        </svg>
                        Kirim
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
@endforeach
</div>
    </div>

</div>
@endforeach
</div>

{{-- Pagination --}}
<div class="mt-6">{{ $reviews->withQueryString()->links() }}</div>

@endif

@endsection