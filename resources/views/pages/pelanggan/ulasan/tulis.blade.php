@extends('layouts.pelanggan')

@section('title', 'Tulis Ulasan - Camplore')

@section('content')

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 mb-6 text-xs text-[#6b7280]">
        <a href="{{ route('pelanggan.sewa') }}" class="hover:text-[#1a5c3a] font-semibold">Sewa Saya</a>
        <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 18l6-6-6-6"/>
        </svg>
        <span class="text-[#1a5c3a] font-bold">Tulis Ulasan</span>
    </div>

    <div class="max-w-[640px]">

        {{-- Product Info Card --}}
        <div class="bg-white rounded-2xl border border-[#e5e7eb] p-5 mb-5 flex items-center gap-4">
            <div class="w-16 h-16 rounded-xl overflow-hidden border border-[#e5e7eb] flex-shrink-0 bg-[#eef5f0]">
                @if($product->image)
                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-7 h-7 text-[#1a5c3a] opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        </svg>
                    </div>
                @endif
            </div>
            <div>
                <div class="text-[11px] font-semibold text-[#6b7280] uppercase tracking-wide mb-0.5">Produk yang kamu sewa</div>
                <div class="text-base font-extrabold text-[#1a1a1a]">{{ $product->name }}</div>
                @php
                    // Ambil detail pertama untuk mendapatkan tanggal & durasi sewa
                    if (!$pesanan->relationLoaded('details')) {
                        $pesanan->load('details');
                    }
                    $detailUlasan = $pesanan->details->first();
                @endphp
                <div class="text-xs text-[#6b7280] mt-0.5">
                    Sewa {{ $detailUlasan ? $detailUlasan->hari_lama_sewa : '-' }} hari &bull;
                    {{ $detailUlasan ? \Carbon\Carbon::parse($detailUlasan->start_date)->format('d M') : '-' }} &ndash;
                    {{ $detailUlasan ? \Carbon\Carbon::parse($detailUlasan->end_date)->format('d M Y') : '-' }}
                </div>
            </div>
        </div>

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="mb-4 bg-[#fef2f2] border border-[#fecaca] text-[#dc2626] text-sm px-4 py-3 rounded-xl">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Review Form --}}
        <form action="{{ route('pelanggan.ulasan.store', $pesanan->id) }}" method="POST">
            @csrf

            <div class="bg-white rounded-2xl border border-[#e5e7eb] p-6">
                <h2 class="text-lg font-extrabold text-[#1a1a1a] mb-1 font-serif">
                    Bagaimana pengalamanmu?
                </h2>
                <p class="text-xs text-[#6b7280] mb-6">
                    Ulasanmu membantu pelanggan lain memilih peralatan yang tepat.
                </p>

                {{-- Star Rating --}}
                <div class="mb-6">
                    <label class="text-sm font-bold text-[#1a1a1a] mb-3 block">
                        Rating <span class="text-[#e8567a]">*</span>
                    </label>

                    <input type="hidden" name="bintang" id="rating-input" value="{{ old('bintang', 0) }}">

                    <div class="flex items-center gap-2" id="star-container">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" data-value="{{ $i }}"
                            class="star-btn focus:outline-none transition-transform duration-150 hover:scale-110">
                            <svg width="36" height="36" viewBox="0 0 24 24"
                                fill="#e5e7eb" stroke="#d1d5db" stroke-width="1.5"
                                class="star-icon" data-index="{{ $i }}">
                                <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                            </svg>
                        </button>
                        @endfor
                        <span id="rating-label" class="text-sm font-bold text-[#f59e0b] ml-2"></span>
                    </div>

                    @error('bintang')
                        <p class="text-xs text-[#dc2626] mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Comment --}}
                <div class="mb-6">
                    <label class="text-sm font-bold text-[#1a1a1a] mb-2 block" for="komentar">
                        Komentar <span class="text-[#e8567a]">*</span>
                    </label>
                    <textarea
                        id="komentar"
                        name="komentar"
                        rows="5"
                        maxlength="1000"
                        placeholder="Ceritakan pengalamanmu menyewa produk ini. Kondisi barang, proses pengiriman, responsivitas seller, dll..."
                        class="w-full text-sm text-[#1a1a1a] bg-[#f9fafb] border border-[#e5e7eb] rounded-xl px-4 py-3
                               focus:outline-none focus:ring-2 focus:ring-[#1a5c3a] focus:border-transparent
                               resize-none transition-all placeholder-[#9ca3af]"
                    >{{ old('komentar') }}</textarea>
                    <div class="flex justify-between mt-1">
                        @error('komentar')
                            <p class="text-xs text-[#dc2626]">{{ $message }}</p>
                        @else
                            <span></span>
                        @enderror
                        <span class="text-[11px] text-[#9ca3af]" id="char-count">0 / 1000</span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-between gap-3 pt-4 border-t border-[#f3f4f6]">
                    <a href="{{ route('pelanggan.sewa') }}"
                       class="px-5 py-2.5 rounded-xl text-sm font-semibold text-[#6b7280]
                              hover:text-[#1a1a1a] transition-colors no-underline">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-[#1a5c3a] hover:bg-[#2d7a52] text-white text-sm font-bold
                               rounded-xl transition-colors duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        Kirim Ulasan
                    </button>
                </div>
            </div>
        </form>

    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = ['', 'Buruk', 'Kurang', 'Cukup', 'Bagus', 'Sangat Bagus'];
    const bintangInput = document.getElementById('rating-input');
    const bintangLabel = document.getElementById('rating-label');
    const stars = document.querySelectorAll('.star-btn');
    let currentBintang = parseInt(bintangInput.value) || 0;

    function paintStars(count) {
        stars.forEach(btn => {
            const icon = btn.querySelector('.star-icon');
            const idx = parseInt(btn.dataset.value);
            if (idx <= count) {
                icon.setAttribute('fill', '#f59e0b');
                icon.setAttribute('stroke', '#f59e0b');
            } else {
                icon.setAttribute('fill', '#e5e7eb');
                icon.setAttribute('stroke', '#d1d5db');
            }
        });
        bintangLabel.textContent = labels[count] || '';
    }

    if (currentBintang > 0) paintStars(currentBintang);

    stars.forEach(btn => {
        btn.addEventListener('click', function () {
            currentBintang = parseInt(this.dataset.value);
            bintangInput.value = currentBintang;
            paintStars(currentBintang);
        });
        btn.addEventListener('mouseenter', function () {
            paintStars(parseInt(this.dataset.value));
        });
        btn.addEventListener('mouseleave', function () {
            paintStars(currentBintang);
        });
    });

    const textarea = document.getElementById('komentar');
    const counter  = document.getElementById('char-count');
    if (textarea && counter) {
        counter.textContent = textarea.value.length + ' / 1000';
        textarea.addEventListener('input', function () {
            counter.textContent = this.value.length + ' / 1000';
        });
    }
});
</script>
@endpush