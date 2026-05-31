@once
    @push('styles')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
        <style>
            .topbar-nav, .topbar-nav * {
                font-family: 'Inter', sans-serif;
            }
        </style>
    @endpush
@endonce

<nav class="topbar-nav flex items-center justify-between px-6 py-3 bg-white border border-[#d7e6de] rounded-2xl shadow-sm">
        
        <div class="flex items-center gap-2">
            <span class="text-[#22543D] text-[10px] font-bold uppercase tracking-widest">
                {{ $NavParent ?? 'Management Rental' }}
            </span>
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#22543D" stroke-width="3">
                <path d="M9 18l6-6-6-6" />
            </svg>
            <span class="text-[#ED64A6] text-[10px] font-bold uppercase tracking-widest">
                {{ $section ?? 'Kamera' }}
            </span>
        </div>

        

        <div class="flex items-center gap-4">

    {{-- Lonceng Notifikasi --}}
    <div class="relative" x-data="{ open: false, unreadCount: {{ $unrepliedCount ?? 0 }} }" @click.outside="open = false">

        <button @click="open = !open"
            class="text-[#22543D] p-1.5 hover:bg-[#f1f8f4] rounded-full transition-colors relative">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0" />
            </svg>
            <div x-show="unreadCount > 0"
                class="absolute top-1 right-1 w-4 h-4 bg-[#ED64A6] rounded-full border-2 border-white flex items-center justify-center">
                <span class="text-white text-[8px] font-bold leading-none" x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
            </div>
        </button>

        <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
            class="absolute right-0 top-full mt-2 w-80 bg-white rounded-2xl shadow-xl border border-[#e8f4ed] z-50 overflow-hidden"
            style="display:none;">

            <div class="px-4 py-3 border-b border-[#e8f4ed] flex items-center justify-between">
                <div>
                    <p class="text-[#22543D] text-sm font-bold">Ulasan Terbaru</p>
                    <p class="text-[#6b7280] text-[10px]" x-text="unreadCount + ' ulasan belum ditanggapi'"></p>
                </div>
                <a href="{{ route('admin.reviews.index') }}"
                    class="text-[10px] font-semibold text-[#ED64A6] hover:underline">
                    Lihat Semua
                </a>
            </div>

            <div class="divide-y divide-[#f0f0f0] max-h-72 overflow-y-auto">
                @forelse($recentReviews ?? [] as $review)
                    <div class="px-4 py-3 hover:bg-[#fafffe] transition-colors">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                                style="background-color: {{ ['#22543D','#ED64A6','#6366f1','#f59e0b'][$loop->index % 4] }}">
                                {{ strtoupper(substr($review->user->name ?? 'U', 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-1">
                                    <span class="text-xs font-semibold text-gray-800 truncate">{{ $review->user->name ?? 'Pengguna' }}</span>
                                    @if(!$review->is_replied)
                                        <span class="shrink-0 text-[9px] font-bold text-[#ED64A6] bg-[#fce7f3] px-1.5 py-0.5 rounded-full">Baru</span>
                                    @endif
                                </div>
                                <p class="text-[10px] text-[#6b7280] truncate">{{ $review->product->name ?? 'Produk' }}</p>
                                <div class="flex gap-0.5 my-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg width="10" height="10" viewBox="0 0 24 24"
                                            fill="{{ $i <= $review->rating ? '#f59e0b' : 'none' }}"
                                            stroke="#f59e0b" stroke-width="2">
                                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-[11px] text-gray-600 line-clamp-2 leading-snug">{{ $review->comment }}</p>
                                <p class="text-[9px] text-[#9ca3af] mt-1">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-8 text-center">
                        <p class="text-xs text-[#9ca3af]">Belum ada ulasan</p>
                    </div>
                @endforelse
            </div>

            <div class="px-4 py-3 border-t border-[#e8f4ed] bg-[#f9fdfb]">
                <a href="{{ route('admin.reviews.index') }}"
                    class="flex items-center justify-center gap-2 w-full py-2 bg-[#22543D] hover:bg-[#1a3d2e] text-white text-xs font-semibold rounded-xl transition-colors">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    Balas Semua Ulasan
                </a>
            </div>
        </div>
    </div>

</div>