{{--
    ══════════════════════════════════════════════════════════
    SECTION ULASAN — tempel tepat sebelum baris:
    @include('layouts.footer_biasa')

    Saat ini menggunakan data dummy.
    Nanti bisa diganti dengan $reviews dari controller.
    ══════════════════════════════════════════════════════════
--}}

@php
$dummyReviews = [
    [
        'name'    => 'Andi Prasetyo',
        'date'    => '2 minggu lalu',
        'rating'  => 5,
        'title'   => 'Kamera bagus, kondisi mulus!',
        'body'    => 'Sewa untuk trip ke Lombok, kondisi kamera sangat baik dan bersih. Proses penyewaan mudah dan responsif. Pasti bakal sewa lagi!',
        'avatar'  => 'AP',
        'color'   => '#1A392D',
    ],
    [
        'name'    => 'Siti Rahma',
        'date'    => '1 bulan lalu',
        'rating'  => 5,
        'title'   => 'Sangat puas, recommended!',
        'body'    => 'Produknya sesuai foto, dikirim tepat waktu. Untuk keperluan dokumentasi acara keluarga hasilnya memuaskan. Terima kasih!',
        'avatar'  => 'SR',
        'color'   => '#ED64A6',
    ],
    [
        'name'    => 'Budi Santoso',
        'date'    => '1 bulan lalu',
        'rating'  => 4,
        'title'   => 'Produk oke, pengiriman cepat',
        'body'    => 'Kualitas produk sesuai ekspektasi. Pengiriman lebih cepat dari estimasi. Ada sedikit goresan kecil tapi tidak memengaruhi fungsi sama sekali.',
        'avatar'  => 'BS',
        'color'   => '#F6A623',
    ],
    [
        'name'    => 'Dewi Kurnia',
        'date'    => '2 bulan lalu',
        'rating'  => 5,
        'title'   => 'Worth it banget!',
        'body'    => 'Daripada beli langsung, sewa di sini jauh lebih hemat untuk sekali pakai. Kondisi alat prima, pelayanan ramah. 10/10!',
        'avatar'  => 'DK',
        'color'   => '#6C63FF',
    ],
];

$totalReviews = count($dummyReviews);
$avgRating    = round(array_sum(array_column($dummyReviews, 'rating')) / $totalReviews, 1);
@endphp

<div class="max-w-6xl mx-auto px-4 lg:px-10 py-12 border-t border-gray-100" style="font-family:'DM Sans',sans-serif;">

    {{-- ── Header ──────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
            <p class="text-[10px] tracking-[0.18em] font-bold uppercase text-gray-400 mb-1">Yang mereka bilang</p>
            <h2 class="text-2xl font-bold text-gray-900">Ulasan Pelanggan</h2>
        </div>

        {{-- Rating summary --}}
        <div class="flex items-center gap-3 bg-gray-50 rounded-2xl px-5 py-3 w-fit">
            <span class="text-4xl font-black text-gray-900">{{ $avgRating }}</span>
            <div>
                <div class="flex gap-0.5 mb-1">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($avgRating))
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @else
                            <svg class="w-4 h-4 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endif
                    @endfor
                </div>
                <p class="text-xs text-gray-400">{{ $totalReviews }} ulasan</p>
            </div>
        </div>
    </div>

    {{-- ── Review list ─────────────────────────────────────────── --}}
    <div class="flex flex-col gap-6" id="reviewList">
        @foreach($dummyReviews as $i => $review)
        <div class="review-item bg-white rounded-2xl p-5 lg:p-6 border border-gray-100 shadow-sm {{ $i >= 2 ? 'hidden' : '' }}">
            <div class="flex items-start gap-4">

                {{-- Avatar --}}
                <div class="shrink-0 w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold"
                    style="background:{{ $review['color'] }};">
                    {{ $review['avatar'] }}
                </div>

                <div class="flex-1 min-w-0">
                    {{-- Name + date --}}
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <div>
                            <span class="text-sm font-bold text-gray-900">{{ $review['name'] }}</span>
                            <span class="ml-2 text-[10px] font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">✓ Terverifikasi</span>
                        </div>
                        <span class="text-xs text-gray-400 shrink-0">{{ $review['date'] }}</span>
                    </div>

                    {{-- Stars --}}
                    <div class="flex gap-0.5 mb-2">
                        @for($s = 1; $s <= 5; $s++)
                            @if($s <= $review['rating'])
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @else
                                <svg class="w-3.5 h-3.5 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endif
                        @endfor
                    </div>

                    {{-- Title + body --}}
                    <p class="text-sm font-bold text-gray-900 mb-1">{{ $review['title'] }}</p>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $review['body'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Tombol lihat semua ───────────────────────────────────── --}}
    @if($totalReviews > 2)
    <div class="mt-6 text-center">
        <button id="toggleReviews"
            onclick="toggleAllReviews()"
            class="text-xs font-bold uppercase tracking-widest border-2 border-gray-900 text-gray-900 px-6 py-3 rounded-full hover:bg-gray-900 hover:text-white transition-all duration-200">
            Lihat Semua {{ $totalReviews }} Ulasan
        </button>
    </div>
    @endif
</div>

<script>
    let reviewsExpanded = false;
    function toggleAllReviews() {
        reviewsExpanded = !reviewsExpanded;
        const items = document.querySelectorAll('.review-item');
        items.forEach((el, i) => {
            if (i >= 2) el.classList.toggle('hidden', !reviewsExpanded);
        });
        document.getElementById('toggleReviews').textContent = reviewsExpanded
            ? 'Sembunyikan Ulasan'
            : 'Lihat Semua {{ $totalReviews }} Ulasan';
    }
</script>