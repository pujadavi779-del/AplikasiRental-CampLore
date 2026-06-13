<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan Pelanggan - CampLore</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
        * { font-family: 'Inter', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif !important; }
    </style>
</head>

<body class="bg-[#f4f9f6] text-[#1a1a1a] antialiased">

    {{-- Sidebar --}}
    @include('components.sidebar_dashboard_admin')

    <main class="lg:ml-[272px] min-h-screen px-6 pt-6 pb-10">

        {{-- Navbar Admin (lonceng notifikasi) --}}
        <div class="mb-4">
            @include('components.navbar_admin')
        </div>

        {{-- Page Header --}}
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="text-[#22543D] text-xs hover:underline">Dashboard</a>
                <svg width="10" height="10" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                <span class="text-[#ED64A6] text-xs font-semibold">Ulasan Pelanggan</span>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="font-serif text-2xl font-bold text-[#22543D]">Ulasan Pelanggan</h1>
                    <p class="text-sm text-[#6b7280] mt-0.5">{{ $reviews->total() }} ulasan &bull; {{ $unrepliedCount }} belum ditanggapi</p>
                </div>
                {{-- Filter Tabs --}}
                <div class="flex items-center gap-1 bg-white border border-[#e8f4ed] rounded-xl p-1">
                    <a href="{{ request()->fullUrlWithQuery(['filter' => 'all']) }}"
                        class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-colors {{ request('filter','all') == 'all' ? 'bg-[#22543D] text-white' : 'text-[#6b7280] hover:text-[#22543D]' }}">
                        Semua
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['filter' => 'unreplied']) }}"
                        class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-colors {{ request('filter') == 'unreplied' ? 'bg-[#ED64A6] text-white' : 'text-[#6b7280] hover:text-[#ED64A6]' }}">
                        Belum Dibalas
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['filter' => 'replied']) }}"
                        class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-colors {{ request('filter') == 'replied' ? 'bg-[#6366f1] text-white' : 'text-[#6b7280] hover:text-[#6366f1]' }}">
                        Sudah Dibalas
                    </a>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-4 flex items-center gap-2 bg-[#d1fae5] border border-[#6ee7b7] text-[#065f46] text-sm font-medium px-4 py-3 rounded-xl">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Reviews List --}}
        @if($reviews->isEmpty())
            <div class="text-center py-20">
                <svg class="w-12 h-12 text-[#d1fae5] mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                <p class="text-[#9ca3af] font-medium">Tidak ada ulasan ditemukan</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($reviews as $review)
                    <div class="bg-white rounded-2xl border {{ !$review->is_replied ? 'border-[#fce7f3]' : 'border-[#e8f4ed]' }} shadow-sm overflow-hidden"
                        x-data="{
                            showReply: false,
                            replied: {{ $review->is_replied ? 'true' : 'false' }},
                            toggleReply() {
                                this.showReply = !this.showReply;
                                if (this.showReply) {
                                    this.$nextTick(() => {
                                        this.$el.querySelector('textarea')?.focus();
                                    });
                                }
                            }
                        }">

                        <div class="p-5">
                            <div class="flex items-start gap-4">

                                {{-- Avatar --}}
                                <div class="w-11 h-11 rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0"
                                    style="background: {{ ['linear-gradient(135deg,#22543D,#38a169)','linear-gradient(135deg,#ED64A6,#f43f8e)','linear-gradient(135deg,#6366f1,#8b5cf6)','linear-gradient(135deg,#f59e0b,#ef4444)'][$loop->index % 4] }}">
                                    {{ strtoupper(substr($review->user->name ?? 'U', 0, 2)) }}
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-1">
                                        <span class="font-bold text-gray-800 text-sm">{{ $review->user->name ?? 'Pengguna' }}</span>
                                        <span class="text-[10px] text-[#6b7280] bg-[#f3f4f6] px-2 py-0.5 rounded-full">{{ $review->created_at->diffForHumans() }}</span>
                                        @if(!$review->is_replied)
                                            <span class="text-[10px] font-bold text-[#ED64A6] bg-[#fce7f3] px-2 py-0.5 rounded-full">● Belum Dibalas</span>
                                        @else
                                            <span class="text-[10px] font-bold text-[#22543D] bg-[#d1fae5] px-2 py-0.5 rounded-full">✓ Sudah Dibalas</span>
                                        @endif
                                    </div>

                                    {{-- Product Info --}}
                                    <div class="flex items-center gap-1.5 mb-2">
                                        <svg width="11" height="11" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zM16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/>
                                        </svg>
                                        <span class="text-[11px] text-[#6b7280]">{{ $review->product->name ?? 'Produk' }}</span>
                                    </div>

                                    {{-- Stars --}}
                                    <div class="flex items-center gap-1 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg width="14" height="14" viewBox="0 0 24 24"
                                                fill="{{ $i <= $review->bintang ? '#f59e0b' : '#e5e7eb' }}"
                                                stroke="{{ $i <= $review->bintang ? '#f59e0b' : '#d1d5db' }}"
                                                stroke-width="1.5">
                                                <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                                            </svg>
                                        @endfor
                                        <span class="text-xs font-bold text-[#f59e0b] ml-1">{{ number_format($review->bintang, 1) }}</span>
                                    </div>

                                    {{-- Comment --}}
                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $review->comment }}</p>

                                    {{-- Existing Reply --}}
                                    @if($review->is_replied && $review->balas_pesan)
                                        <div class="mt-3 bg-[#f9fdfb] border-l-4 border-[#22543D] rounded-r-xl px-4 py-3">
                                            <p class="text-[10px] font-bold text-[#22543D] uppercase tracking-wide mb-1">Balasan Admin</p>
                                            <p class="text-sm text-gray-600 leading-relaxed">{{ $review->balas_pesan }}</p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Action Button --}}
                                <div class="shrink-0">
                                    <button @click="toggleReply"
                                        class="flex items-center gap-1.5 px-3 py-2 text-xs font-semibold rounded-xl transition-all"
                                        :class="showReply
                                            ? 'bg-gray-100 text-gray-500'
                                            : (replied ? 'bg-[#f0fdf4] text-[#22543D] hover:bg-[#d1fae5]' : 'bg-[#22543D] text-white hover:bg-[#1a3d2e]')">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                        </svg>
                                        <span x-text="showReply ? 'Batal' : (replied ? 'Edit Balasan' : 'Balas')"></span>
                                    </button>
                                </div>
                            </div>

                            {{-- Reply Box (inline) --}}
                            <div x-show="showReply"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                style="display:none; padding-left: 60px;"
                                class="mt-4">

                                <form action="{{ route('admin.reviews.balas_pesan', $review->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="bg-[#f9fdfb] rounded-xl border border-[#d7e6de] p-4">
                                        <p class="text-xs font-semibold text-[#22543D] mb-2">
                                            Balas ulasan dari <span class="text-[#ED64A6]">{{ $review->user->name ?? 'Pengguna' }}</span>
                                        </p>
                                        <textarea
                                            name="balas_pesan"
                                            rows="3"
                                            placeholder="Tulis balasan Anda di sini..."
                                            class="w-full text-sm text-gray-700 bg-white border border-[#d7e6de] rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#22543D] focus:border-transparent resize-none transition-all">{{ $review->balas_pesan ?? '' }}</textarea>

                                        <div class="flex items-center justify-between mt-3">
                                            <p class="text-[10px] text-[#9ca3af]">Balasan akan terlihat oleh pelanggan di halaman produk</p>
                                            <div class="flex items-center gap-2">
                                                <button type="button" @click="toggleReply"
                                                    class="px-3 py-1.5 text-xs font-semibold text-[#6b7280] hover:text-gray-800 transition-colors">
                                                    Batal
                                                </button>
                                                <button type="submit"
                                                    class="px-4 py-1.5 bg-[#22543D] hover:bg-[#1a3d2e] text-white text-xs font-semibold rounded-lg transition-colors flex items-center gap-1.5">
                                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                                                    </svg>
                                                    Kirim Balasan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $reviews->withQueryString()->links() }}
            </div>
        @endif

    </main>

</body>
</html>