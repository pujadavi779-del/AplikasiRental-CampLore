@extends('layouts.pelanggan')

@section('title', 'Dashboard - Camplore')

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    * { box-sizing: border-box; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* Sidebar gradient (tidak tersedia di Tailwind base CDN) */
    .sidebar-gradient {
        background: linear-gradient(170deg, #22543D 0%, #1B4332 60%, #163527 100%);
    }
    /* Avatar gradient ring */
    .avatar-ring {
        background: linear-gradient(135deg, #ED64A6, #22543D);
    }

    /* Status badge classes */
    .badge-pending    { @apply bg-yellow-100 text-yellow-800; }
    .badge-processing { @apply bg-green-100 text-green-800; }
    .badge-shipped    { @apply bg-blue-100 text-blue-800; }
    .badge-arrive     { @apply bg-emerald-100 text-emerald-800; }
    .badge-cancelled  { @apply bg-red-100 text-red-800; }
    .badge-returned   { @apply bg-purple-100 text-purple-800; }

    /* Fade-slide animation */
    @keyframes fadeSlide {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .anim    { animation: fadeSlide 0.4s ease forwards; }
    .anim-d1 { animation-delay: 0.05s; opacity: 0; }
    .anim-d2 { animation-delay: 0.12s; opacity: 0; }
    .anim-d3 { animation-delay: 0.18s; opacity: 0; }
</style>
@endpush

@section('content')


{{-- ====== MAIN CONTENT ====== --}}
<main class="ml-30 min-h-screen bg-[#EEF3F0] px-9 pt-9 pb-16">

    {{-- Flash --}}
    @if(session('success'))
    <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-2xl text-sm font-semibold mb-6 anim" id="flash-msg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
        <button onclick="document.getElementById('flash-msg').remove()"
                class="ml-auto bg-transparent border-none cursor-pointer text-green-800 text-base leading-none">✕</button>
    </div>
    @endif

    {{-- Header --}}
    <div class="anim anim-d1">
        <h1 class="text-3xl font-extrabold text-green-800 tracking-tight">Rent History</h1>
        <p class="text-gray-500 text-sm mt-1">Review all your rental transactions based on their status.</p>
    </div>

    {{-- Filter pills --}}
    @php
        $activeStatus = request('status', 'all');
        $filters = [
            ['label' => 'All',        'value' => 'all'],
            ['label' => 'Pending',    'value' => 'pending'],
            ['label' => 'Processing', 'value' => 'processing'],
            ['label' => 'Shipped',    'value' => 'shipped'],
            ['label' => 'Arrive',     'value' => 'arrive'],
            ['label' => 'Cancelled',  'value' => 'cancelled'],
            ['label' => 'Returned',   'value' => 'returned'],
        ];
    @endphp
    <div class="flex flex-wrap gap-2 mt-5 mb-7 anim anim-d2">
        @foreach($filters as $f)
        <a href="?status={{ $f['value'] }}"
           class="inline-flex items-center gap-1.5 px-[18px] py-[7px] rounded-full border-[1.5px] text-xs font-semibold no-underline transition-all duration-200
                  {{ $activeStatus === $f['value']
                        ? 'bg-green-800 border-green-800 text-white'
                        : 'bg-white border-gray-300 text-gray-500 hover:border-green-800 hover:text-green-800' }}">
            <span class="w-1.5 h-1.5 rounded-full bg-current opacity-65"></span>
            {{ $f['label'] }}
        </a>
        @endforeach
    </div>

    {{-- Rental list --}}
    <div class="anim anim-d3">
        @forelse($rentals ?? [] as $rental)

        @php
            $status = strtolower($rental->status ?? 'pending');
            $badgeClass = match($status) {
                'pending'    => 'badge-pending',
                'processing' => 'badge-processing',
                'shipped'    => 'badge-shipped',
                'arrive'     => 'badge-arrive',
                'cancelled'  => 'badge-cancelled',
                'returned'   => 'badge-returned',
                default      => 'badge-pending',
            };
        @endphp

        <div class="bg-white rounded-[18px] border-[1.5px] border-gray-200 border-l-[30px] border-l-green-800 px-5 py-5 flex items-center gap-4 mb-3.5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_8px_28px_rgba(34,84,61,0.10)]">

            {{-- Thumbnail --}}
            <div class="w-20 h-20 rounded-xl border-[1.5px] border-gray-200 overflow-hidden flex-shrink-0 bg-gray-100">
                <img src="{{ $rental->product->image ?? 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&q=80&w=200' }}"
                     alt="{{ $rental->product->name ?? 'Gear' }}"
                     class="w-full h-full object-cover">
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="text-base font-bold text-gray-900">Rent {{ $rental->product->name ?? 'Produk' }}</div>
                <div class="text-xs text-gray-500 mt-0.5">Produk: {{ $rental->product->name ?? '-' }}</div>
                <div class="text-[11px] text-gray-400 mt-1 italic">
                    Dipesan: {{ \Carbon\Carbon::parse($rental->created_at)->format('d M Y, H:i') }}
                </div>
                <span class="badge {{ $badgeClass }} inline-flex items-center px-3 py-0.5 rounded-full text-[11px] font-bold mt-2">
                    {{ ucfirst($status) }}
                </span>
            </div>

            {{-- Right: price + actions --}}
            <div class="flex flex-col items-end gap-2 flex-shrink-0">
                <div class="text-[17px] font-extrabold text-green-800">
                    IDR {{ number_format($rental->total_price ?? 0, 0, ',', '.') }}
                </div>
                <div class="flex gap-2 flex-wrap justify-end">
                    <a href="{{ route('rentals.show', $rental->id) }}"
                       class="border-[1.5px] border-green-800 text-green-800 px-4 py-1.5 rounded-[9px] text-xs font-bold no-underline transition-all duration-200 hover:bg-green-800 hover:text-white">
                        → View Details
                    </a>
                    @if($status === 'arrive' && !($rental->review ?? false))
                    <a href="{{ route('reviews.create', $rental->id) }}"
                       class="bg-pink-500 text-white px-4 py-1.5 rounded-[9px] text-xs font-bold no-underline transition-all duration-200 hover:bg-pink-600">
                        ✍️ Beri Ulasan
                    </a>
                    @endif
                </div>
            </div>
        </div>

        @empty
        {{-- Empty state --}}
        <div class="bg-white rounded-[20px] border-[1.5px] border-gray-200 py-16 px-8 text-center">
            <div class="w-22 h-22 bg-[#EEF3F0] rounded-[22px] flex items-center justify-center mx-auto mb-5" style="width:88px;height:88px;">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-green-800 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="text-xl font-extrabold text-green-800 mb-2">Belum Ada Riwayat Sewa</div>
            <div class="text-gray-400 text-sm max-w-[280px] mx-auto mb-6 leading-relaxed">
                Kamu belum pernah menyewa gear apapun. Yuk mulai petualanganmu sekarang!
            </div>
            <a href="{{ url('/catalog') }}"
               class="inline-flex items-center gap-2 bg-green-800 text-white px-7 py-3 rounded-full font-bold text-sm no-underline transition-all duration-200 shadow-[0_4px_14px_rgba(34,84,61,0.25)] hover:bg-pink-500 hover:shadow-[0_4px_14px_rgba(237,100,166,0.3)]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                </svg>
                Browse Gear Sekarang
            </a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if(isset($rentals) && method_exists($rentals, 'hasPages') && $rentals->hasPages())
    <div class="mt-7">
        {{ $rentals->withQueryString()->links() }}
    </div>
    @endif

</main>

@endsection

@push('scripts')
<script>
    setTimeout(() => {
        const el = document.getElementById('flash-msg');
        if (el) {
            el.style.transition = 'opacity 0.4s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 400);
        }
    }, 4000);
</script>
@endpush