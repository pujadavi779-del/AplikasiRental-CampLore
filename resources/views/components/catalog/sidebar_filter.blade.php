@once
@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    aside,
    aside *,
    .chip-btn,
    .chip-btn *,
    .drawer,
    .drawer * {
        font-family: 'Inter', sans-serif;
    }
</style>
@endpush
@endonce

{{--
    PENGGUNAAN KOMPONEN INI:
    ========================
    Di controller, kirim dua variabel:
        $filterTipes  → Category::where('main_category', 'Kamera') (atau 'Camping')
                                  ->where('attribute_type', 'Tipe')
                                  ->where('is_active', 1)->get()
        $filterMereks → Category::where('main_category', 'Kamera') (atau 'Camping')
                                  ->where('attribute_type', 'Merek')
                                  ->where('is_active', 1)->get()

    Lalu di view halaman kamera / camping:
        @include('components.sidebar_filter')
--}}

{{-- ===== DESKTOP SIDEBAR ===== --}}
<aside class="w-64 shrink-0 pt-2 hidden lg:block">

    {{-- TIPE --}}
    <p class="text-xs font-bold tracking-[0.14em] uppercase text-gray-400 mb-3">
        Tipe
    </p>

    <div class="space-y-2">

        {{-- SEMUA --}}
        <a href="{{ route($kategori . '.LP') }}"
            class="flex items-center gap-2 text-sm hover:text-black">

            <div class="w-4 h-4 rounded border border-gray-300
            {{ !request('type') ? 'bg-black border-black' : '' }}">
            </div>

            Semua
        </a>

        @foreach($filterTipes as $tipe)
        <a href="{{ route($kategori . '.LP', [
        'type' => $tipe->id,
        'brand' => request('brand')
    ]) }}"
            class="flex items-center gap-2 text-sm hover:text-black">

            <div class="w-4 h-4 rounded border border-gray-300
            {{ request('type') == $tipe->id ? 'bg-black border-black' : '' }}">
            </div>

            {{ $tipe->name }}
        </a>
        @endforeach

    </div>

    {{-- MEREK --}}
    <p class="text-xs font-bold tracking-[0.14em] uppercase text-gray-400 mb-3">
        Merek
    </p>

    <div class="grid grid-cols-3 gap-3">

        {{-- SEMUA --}}
        <a href="{{ route($kategori . '.LP', [
        'type' => request('type')
    ]) }}"
            class="cursor-pointer text-center group">

            <div class="aspect-square rounded-xl border-2 flex items-center justify-center
            {{ !request('brand') ? 'border-black' : 'border-gray-200' }}">

                <span class="text-xs font-bold">ALL</span>
            </div>

            <p class="mt-1 text-[10px] font-semibold uppercase tracking-wide">
                Semua
            </p>
        </a>

        @foreach($filterMereks as $merek)
        <a href="{{ route($kategori . '.LP', [
        'type' => request('type'),
        'brand' => $merek->id
    ]) }}"
            class="cursor-pointer text-center group">

            <div class="aspect-square rounded-xl border-2 bg-white flex items-center justify-center overflow-hidden
            transition
            {{ request('brand') == $merek->id ? 'border-black' : 'border-gray-200' }}">

                <img
                    src="{{ $merek->logo ? asset('storage/'.$merek->logo) : 'https://placehold.co/60x60/e8e7e3/aaa?text='.urlencode(Str::limit($merek->name,3,'')) }}"
                    alt="{{ $merek->name }}"
                    class="w-4/5 h-4/5 object-contain">
            </div>

            <p class="mt-1 text-[10px] text-gray-400 font-semibold uppercase tracking-wide">
                {{ $merek->name }}
            </p>
        </a>
        @endforeach

    </div>
</aside>

{{-- ===== MOBILE FILTER CHIPS ===== --}}
<div class="lg:hidden w-full mb-4 flex gap-2 overflow-x-auto no-scrollbar pb-1">
    @foreach(['tipe' => 'Tipe', 'merek' => 'Merek'] as $key => $label)
    <button onclick="openDrawer('{{ $key }}')" data-drawer="{{ $key }}"
        class="chip-btn shrink-0 flex items-center gap-1 px-4 py-2 rounded-full border border-gray-300 bg-white text-xs font-bold text-gray-700 transition">
        {{ $label }}
        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    @endforeach
</div>

{{-- ===== OVERLAY ===== --}}
<div id="drawer-overlay" onclick="closeAllDrawers()"
    class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden"></div>

{{-- ===== DRAWER: TIPE ===== --}}
<div id="drawer-tipe"
    class="drawer fixed bottom-0 inset-x-0 bg-white z-50 rounded-t-3xl shadow-2xl translate-y-full transition-transform duration-300 flex flex-col lg:hidden"
    style="max-height:80vh">

    <div class="flex justify-center pt-3 pb-1 shrink-0">
        <div class="w-10 h-1 bg-gray-200 rounded-full"></div>
    </div>

    <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 shrink-0">
        <h2 class="text-sm font-bold uppercase tracking-widest text-gray-900">Tipe</h2>
        <button onclick="closeAllDrawers()" class="text-gray-400 hover:text-gray-700 transition">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="overflow-y-auto flex-1 px-5 py-4">
        <div class="grid grid-cols-2 gap-2">
            @foreach($filterTipes as $tipe)
            <label class="flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-200 cursor-pointer
                          hover:border-gray-400 has-[:checked]:border-gray-900 has-[:checked]:bg-gray-50 transition">
                <input type="checkbox" name="tipe[]" value="{{ $tipe->id }}"
                    class="w-4 h-4 rounded accent-gray-900">
                <span class="text-sm font-medium text-gray-800">{{ $tipe->name }}</span>
            </label>
            @endforeach
            <label class="flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-200 cursor-pointer
                          hover:border-gray-400 has-[:checked]:border-gray-900 has-[:checked]:bg-gray-50 transition">
                <input type="checkbox" name="tipe[]" value="semua"
                    class="w-4 h-4 rounded accent-gray-900">
                <span class="text-sm font-medium text-gray-800">Semua</span>
            </label>
        </div>
    </div>

    <div class="grid grid-cols-2 border-t border-gray-100 shrink-0">
        <button onclick="resetDrawer('tipe')"
            class="py-4 text-sm font-bold uppercase tracking-widest text-gray-600 hover:bg-gray-50 border-r border-gray-100 transition">
            Hapus Semua
        </button>
        <button onclick="applyDrawer('tipe')"
            class="py-4 text-sm font-bold uppercase tracking-widest text-white bg-gray-900 hover:bg-gray-700 transition">
            Terapkan
        </button>
    </div>
</div>

{{-- ===== DRAWER: MEREK ===== --}}
<div id="drawer-merek"
    class="drawer fixed bottom-0 inset-x-0 bg-white z-50 rounded-t-3xl shadow-2xl translate-y-full transition-transform duration-300 flex flex-col lg:hidden"
    style="max-height:80vh">

    <div class="flex justify-center pt-3 pb-1 shrink-0">
        <div class="w-10 h-1 bg-gray-200 rounded-full"></div>
    </div>

    <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 shrink-0">
        <h2 class="text-sm font-bold uppercase tracking-widest text-gray-900">Merek</h2>
        <button onclick="closeAllDrawers()" class="text-gray-400 hover:text-gray-700 transition">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="overflow-y-auto flex-1 px-5 py-4">
        <div class="grid grid-cols-4 gap-3">
            @foreach($filterMereks as $merek)
            <label class="cursor-pointer text-center" onclick="toggleMerek(this)">
                <div class="aspect-square rounded-xl border-2 border-gray-200 bg-white flex items-center justify-center overflow-hidden transition merek-box">
                    <img src="{{ $merek->logo ? asset('storage/'.$merek->logo) : 'https://placehold.co/60x60/e8e7e3/aaa?text='.urlencode(Str::limit($merek->name,3,'')) }}"
                        alt="{{ $merek->name }}" class="w-4/5 h-4/5 object-contain">
                </div>
                <p class="mt-1 text-[10px] text-gray-400 font-semibold uppercase tracking-wide merek-label">{{ $merek->name }}</p>
                <input type="checkbox" name="merek[]" value="{{ $merek->id }}" class="hidden merek-check">
            </label>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-2 border-t border-gray-100 shrink-0">
        <button onclick="resetDrawer('merek')"
            class="py-4 text-sm font-bold uppercase tracking-widest text-gray-600 hover:bg-gray-50 border-r border-gray-100 transition">
            Hapus Semua
        </button>
        <button onclick="applyDrawer('merek')"
            class="py-4 text-sm font-bold uppercase tracking-widest text-white bg-gray-900 hover:bg-gray-700 transition">
            Terapkan
        </button>
    </div>
</div>

<script>
    const openDrawer = name => {
        closeAllDrawers(false);
        document.getElementById('drawer-' + name).classList.remove('translate-y-full');
        document.getElementById('drawer-overlay').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        document.querySelectorAll('.chip-btn').forEach(b => {
            const active = b.dataset.drawer === name;
            b.classList.toggle('bg-gray-900', active);
            b.classList.toggle('text-white', active);
            b.classList.toggle('border-gray-900', active);
            b.classList.toggle('bg-white', !active);
            b.classList.toggle('text-gray-700', !active);
            b.classList.toggle('border-gray-300', !active);
        });
    };

    const closeAllDrawers = (resetChips = true) => {
        document.querySelectorAll('.drawer').forEach(d => d.classList.add('translate-y-full'));
        document.getElementById('drawer-overlay').classList.add('hidden');
        document.body.style.overflow = '';
        if (resetChips) {
            document.querySelectorAll('.chip-btn').forEach(b => {
                b.classList.remove('bg-gray-900', 'text-white', 'border-gray-900');
                b.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
            });
        }
    };

    const resetDrawer = name => {
        document.querySelectorAll(`#drawer-${name} input`).forEach(i => i.checked = false);
        document.querySelectorAll(`#drawer-${name} .merek-box`).forEach(b => {
            b.classList.remove('border-gray-900');
            b.classList.add('border-gray-200');
        });
        document.querySelectorAll(`#drawer-${name} .merek-label`).forEach(l => {
            l.classList.remove('text-gray-900', 'font-bold');
            l.classList.add('text-gray-400');
        });
    };

    const applyDrawer = () => closeAllDrawers();

    const toggleMerek = label => {
        const check = label.querySelector('.merek-check');
        check.checked = !check.checked;
        label.querySelector('.merek-box').classList.toggle('border-gray-900', check.checked);
        label.querySelector('.merek-box').classList.toggle('border-gray-200', !check.checked);
        label.querySelector('.merek-label').classList.toggle('text-gray-900', check.checked);
        label.querySelector('.merek-label').classList.toggle('text-gray-400', !check.checked);
        label.querySelector('.merek-label').classList.toggle('font-bold', check.checked);
    };
</script>