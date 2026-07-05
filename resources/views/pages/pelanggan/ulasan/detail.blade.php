@extends('layouts.pelanggan')

@section('title', 'Penilaian Saya - Camplore')

@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 mb-6 text-xs text-[#6b7280]">
    <a href="{{ route('pelanggan.sewa') }}" class="hover:text-[#1a5c3a] font-semibold">Sewa Saya</a>
    <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M9 18l6-6-6-6" />
    </svg>
    <span class="text-[#1a5c3a] font-bold">Penilaian Saya</span>
</div>

<div class="max-w-[680px]">

    {{-- Header --}}
    <h1 class="text-2xl font-extrabold text-[#1a1a1a] mb-1 font-serif">Penilaian Saya</h1>
    <p class="text-xs text-[#6b7280] mb-6">Ulasan yang kamu berikan untuk produk ini.</p>

    {{-- Product Info --}}
    {{-- Product Info --}}
    <div class="bg-white rounded-2xl border border-[#e5e7eb] p-5 mb-4 flex items-center gap-4">
        <div class="w-16 h-16 rounded-xl overflow-hidden border border-[#e5e7eb] flex-shrink-0 bg-[#eef5f0]">
            @if(optional($review->product)->gambar_barang)
            <img src="{{ asset($review->product->gambar_barang) }}"
                alt="{{ optional($review->product)->name }}"
                class="w-full h-full object-cover">
            @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-7 h-7 text-[#1a5c3a] opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                </svg>
            </div>
            @endif
        </div>
        <div>
            <div class="text-[11px] font-semibold text-[#6b7280] uppercase tracking-wide mb-0.5">Produk yang disewa</div>
            <div class="text-base font-extrabold text-[#1a1a1a]">{{ optional($review->product)->name ?? 'Produk tidak tersedia' }}</div>
            <div class="text-xs text-[#6b7280] mt-0.5">{{ $review->created_at->translatedFormat('d F Y') }}</div>
        </div>
    </div>

    {{-- Review Card --}}
    <div class="bg-white rounded-2xl border border-[#e5e7eb] overflow-hidden">

        {{-- Header Review --}}
        <div class="px-6 py-5 border-b border-[#f3f4f6]">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                        @if(optional($review->pelanggan)->foto_profile)
                        <img src="{{ asset('storage/' . $review->pelanggan->foto_profile) }}"
                            alt="{{ $review->pelanggan->nama_lengkap }}"
                            class="w-full h-full object-cover">
                        @else
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold"
                            style="background: linear-gradient(135deg,#22543D,#38a169)">
                            {{ strtoupper(substr(optional($review->pelanggan)->nama_lengkap ?? 'U', 0, 2)) }}
                        </div>
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-[#1a1a1a]">{{ optional($review->pelanggan)->nama_lengkap ?? '-' }}</span>
                            
                        </div>
                        <div class="text-[11px] text-[#9ca3af] mt-0.5">{{ $review->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>

            {{-- Stars --}}
            <div class="flex items-center gap-1 mb-3">
                @for($i = 1; $i <= 5; $i++)
                    <svg width="20" height="20" viewBox="0 0 24 24"
                    fill="{{ $i <= $review->bintang ? '#f59e0b' : '#e5e7eb' }}"
                    stroke="{{ $i <= $review->bintang ? '#f59e0b' : '#d1d5db' }}"
                    stroke-width="1.5">
                    <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" />
                    </svg>
                    @endfor
                    <span class="text-sm font-bold text-[#f59e0b] ml-1">
                        {{ ['','Buruk','Kurang','Cukup','Bagus','Sangat Bagus'][$review->bintang] }}
                    </span>
            </div>

            {{-- Comment --}}
            <p class="text-sm text-[#1a1a1a] leading-relaxed">{{ $review->komentar }}</p>
        </div>

        {{-- Admin Reply --}}
        @if($review->is_replied && $review->balas_pesan)
        <div class="px-6 py-5 bg-[#f9fdfb]">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-full bg-[#1a5c3a] flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-sm font-bold text-[#1a5c3a]">Camplore Official</span>
                        <span class="text-[10px] text-[#6b7280]">
                            {{ $review->replied_at ? \Carbon\Carbon::parse($review->replied_at)->diffForHumans() : '' }}
                        </span>
                    </div>
                    <p class="text-sm text-[#374151] leading-relaxed">{{ $review->balas_pesan }}</p>
                </div>
            </div>
        </div>
        @else
        <div class="px-6 py-4 bg-[#fafafa] flex items-center gap-2">
            <svg class="w-4 h-4 text-[#9ca3af]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <p class="text-xs text-[#9ca3af]">Belum ada respon dari penjual.</p>
        </div>
        @endif

    </div>

    {{-- Back button --}}
    <div class="mt-5">
        <a href="{{ route('pelanggan.sewa') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-[#6b7280] hover:text-[#1a5c3a] transition-colors no-underline">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Sewa Saya
        </a>
    </div>

</div>

@endsection