{{-- ===== DESKTOP SIDEBAR ===== --}}
<aside class="w-64 shrink-0 pt-2 hidden lg:block">
    <div>
        <p class="text-xs font-bold tracking-[0.14em] uppercase text-gray-400 mb-3">Kategori</p>
        <div class="space-y-2">
            @foreach(['DSLR','Mirrorless','Kamera Aksi','Kamera Instan (Polaroid)','Kamera Video','Semua'] as $cat)
            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer hover:text-black transition">
                <input type="checkbox" class="w-4 h-4 border-gray-300 rounded text-black focus:ring-black">
                {{ $cat }}
            </label>
            @endforeach
        </div>
    </div>
    <div class="border-t my-6"></div>
    <div>
        <p class="text-xs font-bold tracking-[0.14em] uppercase text-gray-400 mb-3">Merek</p>
        <div class="grid grid-cols-3 gap-3">
            @foreach($ipCategories as $ip)
            <div class="cursor-pointer text-center group">
                <div class="aspect-square rounded-xl border border-gray-200 bg-white flex items-center justify-center overflow-hidden transition-all duration-300 group-hover:border-gray-400 group-hover:shadow-sm">
                    <img src="{{ $ip->image ? asset('storage/'.$ip->image) : 'https://placehold.co/60x60/e8e7e3/aaa?text='.urlencode(Str::limit($ip->name,3,'')) }}"
                        alt="{{ $ip->name }}" class="w-4/5 h-4/5 object-contain">
                </div>
                <p class="mt-1 text-[10px] text-gray-400 font-semibold uppercase tracking-wide">{{ $ip->name }}</p>
            </div>
            @endforeach
        </div>
    </div>
</aside>

{{-- ===== MOBILE FILTER CHIPS ===== --}}
<div class="lg:hidden w-full mb-4">
    <div class="flex gap-2 overflow-x-auto no-scrollbar pb-1">
        <button onclick="openDrawer('kategori')"
            class="chip-btn flex items-center gap-1 shrink-0 px-4 py-2 rounded-full border border-gray-300 bg-white text-xs font-bold text-gray-700 hover:border-gray-900 transition"
            data-drawer="kategori">
            Kategori
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <button onclick="openDrawer('merek')"
            class="chip-btn flex items-center gap-1 shrink-0 px-4 py-2 rounded-full border border-gray-300 bg-white text-xs font-bold text-gray-700 hover:border-gray-900 transition"
            data-drawer="merek">
            Merek
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    </div>
</div>

{{-- ===== OVERLAY ===== --}}
<div id="drawer-overlay" onclick="closeAllDrawers()"
    class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden"></div>

{{-- ===== DRAWER: KATEGORI ===== --}}
<div id="drawer-kategori"
    class="fixed bottom-0 left-0 right-0 bg-white z-50 rounded-t-3xl shadow-2xl translate-y-full transition-transform duration-300 ease-out lg:hidden flex flex-col"
    style="max-height: 80vh;">

    {{-- Handle --}}
    <div class="flex justify-center pt-3 pb-1 shrink-0">
        <div class="w-10 h-1 bg-gray-200 rounded-full"></div>
    </div>

    {{-- Header --}}
    <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 shrink-0">
        <h2 class="text-sm font-bold uppercase tracking-widest text-gray-900">Kategori</h2>
        <button onclick="closeAllDrawers()" class="text-gray-400 hover:text-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Content --}}
    <div class="overflow-y-auto flex-1 px-5 py-4">
        <div class="grid grid-cols-2 gap-2">
            @foreach(['DSLR','Mirrorless','Kamera Aksi','Kamera Instan (Polaroid)','Kamera Video','Semua'] as $cat)
            <label class="flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-200 cursor-pointer
                          hover:border-gray-400 transition has-[:checked]:border-gray-900 has-[:checked]:bg-gray-50">
                <input type="checkbox" name="kategori[]" value="{{ $cat }}"
                    class="w-4 h-4 rounded border-gray-300 accent-gray-900">
                <span class="text-sm text-gray-800 font-medium">{{ $cat }}</span>
            </label>
            @endforeach
        </div>
    </div>

    {{-- Footer Buttons --}}
    <div class="grid grid-cols-2 border-t border-gray-100 shrink-0">
        <button onclick="resetDrawer('kategori')"
            class="py-4 text-sm font-bold uppercase tracking-widest text-gray-600 hover:bg-gray-50 transition border-r border-gray-100">
            Hapus Semua
        </button>
        <button onclick="applyDrawer('kategori')"
            class="py-4 text-sm font-bold uppercase tracking-widest text-white bg-gray-900 hover:bg-gray-700 transition">
            Terapkan
        </button>
    </div>
</div>

{{-- ===== DRAWER: MEREK ===== --}}
<div id="drawer-merek"
    class="fixed bottom-0 left-0 right-0 bg-white z-50 rounded-t-3xl shadow-2xl translate-y-full transition-transform duration-300 ease-out lg:hidden flex flex-col"
    style="max-height: 80vh;">

    {{-- Handle --}}
    <div class="flex justify-center pt-3 pb-1 shrink-0">
        <div class="w-10 h-1 bg-gray-200 rounded-full"></div>
    </div>

    {{-- Header --}}
    <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 shrink-0">
        <h2 class="text-sm font-bold uppercase tracking-widest text-gray-900">Merek</h2>
        <button onclick="closeAllDrawers()" class="text-gray-400 hover:text-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Content --}}
    <div class="overflow-y-auto flex-1 px-5 py-4">
        <div class="grid grid-cols-4 gap-3">
            @foreach($ipCategories as $ip)
            <label class="cursor-pointer text-center group" onclick="toggleMerek(this)">
                <div class="aspect-square rounded-xl border-2 border-gray-200 bg-white flex items-center justify-center overflow-hidden transition-all duration-200 group-hover:border-gray-400 merek-box">
                    <img src="{{ $ip->image ? asset('storage/'.$ip->image) : 'https://placehold.co/60x60/e8e7e3/aaa?text='.urlencode(Str::limit($ip->name,3,'')) }}"
                        alt="{{ $ip->name }}" class="w-4/5 h-4/5 object-contain">
                </div>
                <p class="mt-1 text-[10px] text-gray-400 font-semibold uppercase tracking-wide merek-label">{{ $ip->name }}</p>
                <input type="checkbox" name="merek[]" value="{{ $ip->name ?? $ip->brand ?? '' }}" class="hidden merek-check">
            </label>
            @endforeach
        </div>
    </div>

    {{-- Footer Buttons --}}
    <div class="grid grid-cols-2 border-t border-gray-100 shrink-0">
        <button onclick="resetDrawer('merek')"
            class="py-4 text-sm font-bold uppercase tracking-widest text-gray-600 hover:bg-gray-50 transition border-r border-gray-100">
            Hapus Semua
        </button>
        <button onclick="applyDrawer('merek')"
            class="py-4 text-sm font-bold uppercase tracking-widest text-white bg-gray-900 hover:bg-gray-700 transition">
            Terapkan
        </button>
    </div>
</div>

<script>
function openDrawer(name) {
    closeAllDrawers(false);
    document.getElementById('drawer-' + name).classList.remove('translate-y-full');
    document.getElementById('drawer-overlay').classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Tandai chip aktif
    document.querySelectorAll('.chip-btn').forEach(btn => {
        btn.classList.remove('border-gray-900', 'bg-gray-900', 'text-white');
        btn.classList.add('border-gray-300', 'bg-white', 'text-gray-700');
    });
    const activeChip = document.querySelector(`[data-drawer="${name}"]`);
    if (activeChip) {
        activeChip.classList.add('border-gray-900', 'bg-gray-900', 'text-white');
        activeChip.classList.remove('border-gray-300', 'bg-white', 'text-gray-700');
    }
}

function closeAllDrawers(resetChips = true) {
    ['kategori', 'merek'].forEach(name => {
        document.getElementById('drawer-' + name).classList.add('translate-y-full');
    });
    document.getElementById('drawer-overlay').classList.add('hidden');
    document.body.style.overflow = '';

    if (resetChips) {
        document.querySelectorAll('.chip-btn').forEach(btn => {
            btn.classList.remove('border-gray-900', 'bg-gray-900', 'text-white');
            btn.classList.add('border-gray-300', 'bg-white', 'text-gray-700');
        });
    }
}

function resetDrawer(name) {
    const drawer = document.getElementById('drawer-' + name);
    drawer.querySelectorAll('input[type=checkbox]').forEach(cb => cb.checked = false);
    // Reset visual merek
    drawer.querySelectorAll('.merek-box').forEach(box => {
        box.classList.remove('border-gray-900');
        box.classList.add('border-gray-200');
    });
    drawer.querySelectorAll('.merek-label').forEach(lbl => {
        lbl.classList.remove('text-gray-900', 'font-bold');
        lbl.classList.add('text-gray-400');
    });
}

function applyDrawer(name) {
    closeAllDrawers();
    // Tambah logic submit filter di sini
}

function toggleMerek(label) {
    const box = label.querySelector('.merek-box');
    const lbl = label.querySelector('.merek-label');
    const check = label.querySelector('.merek-check');
    const isChecked = !check.checked;
    check.checked = isChecked;

    if (isChecked) {
        box.classList.add('border-gray-900');
        box.classList.remove('border-gray-200');
        lbl.classList.add('text-gray-900', 'font-bold');
        lbl.classList.remove('text-gray-400');
    } else {
        box.classList.remove('border-gray-900');
        box.classList.add('border-gray-200');
        lbl.classList.remove('text-gray-900', 'font-bold');
        lbl.classList.add('text-gray-400');
    }
}
</script>