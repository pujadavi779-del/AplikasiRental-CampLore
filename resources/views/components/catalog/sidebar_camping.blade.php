{{-- DESKTOP SIDEBAR --}}
<aside class="w-64 shrink-0 pt-2 hidden lg:block">

    <p class="text-xs font-bold tracking-[0.14em] uppercase text-gray-400 mb-3">Kategori</p>
    <div class="space-y-2">
        @foreach(['Tenda','Sleeping Bag','Matras','Carrier / Backpack','Kompor & Alat Masak','Lampu & Penerangan','Peralatan Hiking','Semua'] as $cat)
        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer hover:text-black transition">
            <input type="checkbox" class="w-4 h-4 rounded border-gray-300 accent-gray-900"> {{ $cat }}
        </label>
        @endforeach
    </div>

    <div class="border-t my-6"></div>

    <p class="text-xs font-bold tracking-[0.14em] uppercase text-gray-400 mb-3">Merek / Tipe</p>
    <div class="grid grid-cols-3 gap-3">
        @foreach($campingBrands ?? [] as $brand)
        <div class="cursor-pointer text-center group">
            <div class="aspect-square rounded-xl border border-gray-200 bg-white flex items-center justify-center overflow-hidden group-hover:border-gray-400 group-hover:shadow-sm transition">
                <img src="{{ $brand->image ?? 'https://placehold.co/60x60/e8e7e3/aaa?text='.urlencode(substr($brand->name,0,3)) }}"
                    alt="{{ $brand->name }}" class="w-4/5 h-4/5 object-contain">
            </div>
            <p class="mt-1 text-[10px] text-gray-400 font-semibold uppercase tracking-wide">{{ $brand->name }}</p>
        </div>
        @endforeach
    </div>
</aside>

{{-- MOBILE CHIPS --}}
<div class="lg:hidden w-full mb-4 flex gap-2 overflow-x-auto no-scrollbar pb-1">
    @foreach(['kategori','merek'] as $d)
    <button onclick="openDrawer('{{$d}}')" data-drawer="{{$d}}"
        class="chip-btn shrink-0 flex items-center gap-1 px-4 py-2 rounded-full border border-gray-300 bg-white text-xs font-bold text-gray-700 transition">
        {{ $d === 'merek' ? 'Merek / Tipe' : 'Kategori' }}
        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    @endforeach
</div>

{{-- OVERLAY --}}
<div id="drawer-overlay" onclick="closeAllDrawers()" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden"></div>

{{-- DRAWER: KATEGORI --}}
<div id="drawer-kategori" class="drawer fixed bottom-0 inset-x-0 bg-white z-50 rounded-t-3xl shadow-2xl translate-y-full transition-transform duration-300 flex flex-col lg:hidden" style="max-height:80vh">
    <div class="flex justify-center pt-3 pb-1"><div class="w-10 h-1 bg-gray-200 rounded-full"></div></div>
    <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100">
        <h2 class="text-sm font-bold uppercase tracking-widest">Kategori</h2>
        <button onclick="closeAllDrawers()" class="text-gray-400 hover:text-gray-700">✕</button>
    </div>
    <div class="overflow-y-auto flex-1 px-5 py-4 grid grid-cols-2 gap-2">
        @foreach(['Tenda','Sleeping Bag','Matras','Carrier / Backpack','Kompor & Alat Masak','Lampu & Penerangan','Peralatan Hiking','Semua'] as $cat)
        <label class="flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-200 cursor-pointer hover:border-gray-400 has-[:checked]:border-gray-900 has-[:checked]:bg-gray-50 transition">
            <input type="checkbox" name="kategori[]" value="{{ $cat }}" class="w-4 h-4 rounded accent-gray-900">
            <span class="text-sm font-medium">{{ $cat }}</span>
        </label>
        @endforeach
    </div>
    <div class="grid grid-cols-2 border-t border-gray-100 shrink-0">
        <button onclick="resetDrawer('kategori')" class="py-4 text-sm font-bold uppercase tracking-widest text-gray-600 hover:bg-gray-50 border-r border-gray-100">Hapus Semua</button>
        <button onclick="applyDrawer('kategori')" class="py-4 text-sm font-bold uppercase tracking-widest text-white bg-gray-900 hover:bg-gray-700">Terapkan</button>
    </div>
</div>

{{-- DRAWER: MEREK --}}
<div id="drawer-merek" class="drawer fixed bottom-0 inset-x-0 bg-white z-50 rounded-t-3xl shadow-2xl translate-y-full transition-transform duration-300 flex flex-col lg:hidden" style="max-height:80vh">
    <div class="flex justify-center pt-3 pb-1"><div class="w-10 h-1 bg-gray-200 rounded-full"></div></div>
    <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100">
        <h2 class="text-sm font-bold uppercase tracking-widest">Merek / Tipe</h2>
        <button onclick="closeAllDrawers()" class="text-gray-400 hover:text-gray-700">✕</button>
    </div>
    <div class="overflow-y-auto flex-1 px-5 py-4 grid grid-cols-4 gap-3">
        @foreach($campingBrands ?? [] as $brand)
        <label class="cursor-pointer text-center" onclick="toggleMerek(this)">
            <div class="aspect-square rounded-xl border-2 border-gray-200 bg-white flex items-center justify-center overflow-hidden transition merek-box">
                <img src="{{ $brand->image ?? 'https://placehold.co/60x60/e8e7e3/aaa?text='.urlencode(substr($brand->name,0,3)) }}"
                    class="w-4/5 h-4/5 object-contain">
            </div>
            <p class="mt-1 text-[10px] text-gray-400 font-semibold uppercase tracking-wide merek-label">{{ $brand->name }}</p>
            <input type="checkbox" name="merek[]" value="{{ $brand->name }}" class="hidden merek-check">
        </label>
        @endforeach
    </div>
    <div class="grid grid-cols-2 border-t border-gray-100 shrink-0">
        <button onclick="resetDrawer('merek')" class="py-4 text-sm font-bold uppercase tracking-widest text-gray-600 hover:bg-gray-50 border-r border-gray-100">Hapus Semua</button>
        <button onclick="applyDrawer('merek')" class="py-4 text-sm font-bold uppercase tracking-widest text-white bg-gray-900 hover:bg-gray-700">Terapkan</button>
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
        b.classList.toggle('bg-white', !active);
        b.classList.toggle('text-gray-700', !active);
    });
};

const closeAllDrawers = (resetChips = true) => {
    document.querySelectorAll('.drawer').forEach(d => d.classList.add('translate-y-full'));
    document.getElementById('drawer-overlay').classList.add('hidden');
    document.body.style.overflow = '';
    if (resetChips) document.querySelectorAll('.chip-btn').forEach(b => {
        b.classList.replace('bg-gray-900', 'bg-white');
        b.classList.replace('text-white', 'text-gray-700');
    });
};

const resetDrawer = name => {
    document.querySelectorAll(`#drawer-${name} input`).forEach(i => i.checked = false);
    document.querySelectorAll(`#drawer-${name} .merek-box`).forEach(b => {
        b.classList.replace('border-gray-900', 'border-gray-200');
    });
    document.querySelectorAll(`#drawer-${name} .merek-label`).forEach(l => {
        l.classList.remove('text-gray-900', 'font-bold');
    });
};

const applyDrawer = () => closeAllDrawers();

const toggleMerek = label => {
    const check = label.querySelector('.merek-check');
    check.checked = !check.checked;
    label.querySelector('.merek-box').classList.toggle('border-gray-900', check.checked);
    label.querySelector('.merek-box').classList.toggle('border-gray-200', !check.checked);
    label.querySelector('.merek-label').classList.toggle('text-gray-900', check.checked);
    label.querySelector('.merek-label').classList.toggle('font-bold', check.checked);
};
</script>