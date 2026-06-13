@extends('layouts.admin')

@section('title', 'Kategori Produk - Camplore Admin')

@php
$NavParent = 'Manajemen Operasional';
$section = 'Pengguna';
@endphp
@section('content')


<div class="fixed top-5 right-5 z-[9999] space-y-3 max-w-sm w-full px-4 sm:px-0">

    {{-- 1. Alert Notifikasi Sukses (Hijau Flowbite Standar) --}}
    @if(session('success'))
    <div id="toast-success" class="flex items-center p-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200 shadow-lg" role="alert">
        <svg class="w-4 h-4 shrink-0 text-green-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <span class="sr-only">Success info</span>
        <div class="ms-3 text-sm font-bold text-green-950">
            {{ session('success') }}
        </div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 shrink-0 text-green-600" data-dismiss-target="#toast-success" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
            </svg>
        </button>
    </div>
    @endif

    {{-- 2. Alert Notifikasi Gagal/Error (Tetap Diubah Jadi Hijau Flowbite Standar) --}}
    @if(session('error'))
    <div id="toast-danger" class="flex items-center p-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200 shadow-lg" role="alert">
        <svg class="w-4 h-4 shrink-0 text-green-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <span class="sr-only">Error info</span>
        <div class="ms-3 text-sm font-bold text-green-950">
            {{ session('error') }}
        </div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 shrink-0 text-green-600" data-dismiss-target="#toast-danger" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
            </svg>
        </button>
    </div>
    @endif

</div>

<div class="max-w-full space-y-6" x-data="{
    activeTab: '{{ session("last_tab", "kamera") }}',
    perPage: 5,

    page: {
        kamera: {{ (session("last_tab") === "kamera" && session("jump_to_last")) ? (int)ceil(count($tipeKamera) / 5) : 1 }},
        camping: {{ (session("last_tab") === "camping" && session("jump_to_last")) ? (int)ceil(count($tipeCamping) / 5) : 1 }},
    },

    search: {
        kamera: '',
        camping: '',
    },

    total: {
        kamera: {{ count($tipeKamera) }},
        camping: {{ count($tipeCamping) }},
    },

    totalPages(cat) {
        return Math.ceil(this.total[cat] / this.perPage);
    },

    openDetailMerek(merekId, namaMerek) {
    const modalElement = document.getElementById('detail-merek-modal');
    if (!modalElement) return;

    document.getElementById('modal-merek-title').innerText = namaMerek;
    document.getElementById('modal-merek-subtitle').innerText = 'Manajemen Inventaris Sewa - ' + namaMerek;
    document.getElementById('modal-merek-badge').innerText = namaMerek.substring(0, 3).toUpperCase();

    const tbody = document.getElementById('modal-product-tbody');
    tbody.innerHTML = `<tr><td colspan='4' class='text-center py-6 text-gray-400 font-medium animate-pulse'>Mengambil data produk...</td></tr>`;

    let modal = FlowbiteInstances.getInstance('Modal', 'detail-merek-modal');
    if (!modal) {
        modal = new Modal(modalElement, {}, { id: 'detail-merek-modal', override: true });
    }
    modal.show();

    fetch(`/admin/kategori/merek/${merekId}/detail`)
        .then(response => response.json())
        .then(data => {
            tbody.innerHTML = '';
            if (!data.products || data.products.length === 0) {
                tbody.innerHTML = `<tr><td colspan='4' class='text-center py-8 text-gray-400 italic font-medium'>Tidak ada produk yang menggunakan merek ini.</td></tr>`;
                return;
            }
            data.products.forEach(product => {
                const hargaFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(product.price);
                const row = `
                    <tr class='hover:bg-gray-50/40 transition-colors border-b border-gray-100'>
                        <td class='py-4 font-bold text-gray-950'>${product.name}</td>
                        <td class='py-4 text-gray-500 font-medium'>${product.tipe}</td>
                        <td class='py-4'>
                            <span class='px-2.5 py-1 ${product.stok > 0 ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600'} rounded-full text-[10px] font-extrabold tracking-wide uppercase'>
                                ${product.stok} Unit Siap Sewa
                            </span>
                        </td>
                        <td class='py-4 text-gray-600 italic font-medium'>${hargaFormatted} / hari</td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            tbody.innerHTML = `<tr><td colspan='4' class='text-center py-6 text-red-500 font-bold'>Gagal memuat data produk.</td></tr>`;
        });
    }
}">

    <div class="bg-white rounded-[24px] border border-gray-100 p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)]">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-950 tracking-tight">Kategori Produk</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola hierarki tipe dan merek untuk inventaris penyewaan.</p>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div class="flex p-1 bg-gray-50 border border-gray-100 rounded-xl w-fit">
                <button @click="activeTab = 'kamera'" :class="activeTab === 'kamera' ? 'bg-white text-gray-950 shadow-sm' : 'text-gray-500 hover:text-gray-900'" class="px-5 py-2 rounded-lg text-sm font-bold transition-all">
                    Kamera
                </button>
                <button @click="activeTab = 'camping'" :class="activeTab === 'camping' ? 'bg-white text-gray-950 shadow-sm' : 'text-gray-500 hover:text-gray-900'" class="px-5 py-2 rounded-lg text-sm font-bold transition-all">
                    Camping
                </button>
            </div>

            <div class="flex gap-3">
                <button data-modal-target="tambah-tipe-modal" data-modal-toggle="tambah-tipe-modal" type="button" class="px-4 py-2 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-1.5">
                    + TIPE
                </button>
                <button data-modal-target="tambah-merek-modal" data-modal-toggle="tambah-merek-modal" type="button" class="px-4 py-2 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-1.5">
                    + MEREK
                </button>
            </div>
        </div>

        @php
            $categories = [
                'kamera' => [
                    'tipeList'   => $tipeKamera,
                    'tipeLabel'  => 'Tipe Kamera',
                    'merekList'  => $merekKamera,
                    'merekLabel' => 'Merek Kamera',
                ],
                'camping' => [
                    'tipeList'   => $tipeCamping,
                    'tipeLabel'  => 'Tipe Peralatan',
                    'merekList'  => $merekCamping,
                    'merekLabel' => 'Merek Camping',
                ],
            ];
        @endphp

        @foreach($categories as $prefix => $cat)
        @php
            $namesJson = $cat['tipeList']->map(fn($t) => "'".addslashes($t->nama_kategori)."'")->join(',');
        @endphp
        <div x-show="activeTab === '{{ $prefix }}'" class="grid grid-cols-1 lg:grid-cols-12 gap-12" @if($prefix !== 'kamera') style="display: none;" @endif>
            <div class="lg:col-span-7 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-[11px] font-bold text-[#2d6b50] uppercase tracking-wider">{{ $cat['tipeLabel'] }}</span>
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded text-[10px] font-bold uppercase tracking-wider">{{ count($cat['tipeList']) }} Item</span>
                    </div>

                    <div class="relative mb-4">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                            </svg>
                        </div>
                        <input type="text" x-model="search.{{ $prefix }}" @input="page.{{ $prefix }} = 1" placeholder="Cari {{ strtolower($cat['tipeLabel']) }}..."
                            class="w-full pl-9 pr-3 py-2 text-sm bg-gray-50 border border-gray-100 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 font-medium">
                    </div>

                    <div class="w-full text-left text-[11px] mb-3 flex justify-between font-bold text-gray-400 uppercase tracking-wider px-1">
                        <div>Nama Tipe</div>
                        <div>Aksi</div>
                    </div>

                    <div class="divide-y divide-gray-100 border-t border-gray-100">
                        @foreach($cat['tipeList'] as $tipe)
                        <div x-show="
                                '{{ addslashes($tipe->nama_kategori) }}'.toLowerCase().includes(search.{{ $prefix }}.toLowerCase()) &&
                                (() => {
                                    let filtered = [{{ $namesJson }}]
                                        .filter(n => n.toLowerCase().includes(search.{{ $prefix }}.toLowerCase()));
                                    let pos = filtered.indexOf('{{ addslashes($tipe->nama_kategori) }}');
                                    return pos >= (page.{{ $prefix }} - 1) * perPage && pos < page.{{ $prefix }} * perPage;
                                })()"
                            class="flex justify-between items-center py-3.5 px-1 hover:bg-gray-50/30 transition-colors">
                            <span class="font-bold text-gray-800 text-sm">{{ $tipe->nama_kategori }}</span>
                            <div class="flex gap-3 text-xs font-bold">
                                <button class="text-gray-400 hover:text-gray-600 transition-colors">Edit</button>
                                <form action="{{ route('admin.category.destroyType', $tipe->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tipe ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 transition-colors">Hapus</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Pagination --}}
                <div x-show="totalPages('{{ $prefix }}') > 1" class="flex items-center justify-between border-t border-gray-100 pt-4 mt-6">
                    <span class="text-xs font-semibold text-gray-400 selection:bg-transparent">
                        Halaman <span class="text-gray-900" x-text="page.{{ $prefix }}"></span> dari <span class="text-gray-900" x-text="totalPages('{{ $prefix }}')"></span>
                    </span>
                    <div class="inline-flex gap-1">
                        <button @click="if(page.{{ $prefix }} > 1) page.{{ $prefix }}--" :disabled="page.{{ $prefix }} === 1"
                            :class="page.{{ $prefix }} === 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-50 text-gray-700'"
                            class="px-2.5 py-1.5 border border-gray-200 rounded-lg text-xs font-bold transition-colors shadow-sm">
                            &lt;
                        </button>
                        <template x-for="p in totalPages('{{ $prefix }}')" :key="p">
                            <button @click="page.{{ $prefix }} = p"
                                :class="page.{{ $prefix }} === p ? 'bg-black text-white border-black shadow-sm' : 'border-gray-200 text-gray-600 hover:bg-gray-50'"
                                class="px-3 py-1.5 border rounded-lg text-xs font-bold transition-all"
                                x-text="p">
                            </button>
                        </template>
                        <button @click="if(page.{{ $prefix }} < totalPages('{{ $prefix }}')) page.{{ $prefix }}++" :disabled="page.{{ $prefix }} === totalPages('{{ $prefix }}')"
                            :class="page.{{ $prefix }} === totalPages('{{ $prefix }}') ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-50 text-gray-700'"
                            class="px-2.5 py-1.5 border border-gray-200 rounded-lg text-xs font-bold transition-colors shadow-sm">
                            &gt;
                        </button>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="flex justify-between items-center mb-5">
                    <span class="text-[11px] font-bold text-[#2d6b50] uppercase tracking-wider">{{ $cat['merekLabel'] }}</span>
                    <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded text-[10px] font-bold uppercase tracking-wider">{{ count($cat['merekList']) }} Item</span>
                </div>
                <div class="grid grid-cols-4 sm:grid-cols-5 gap-4">
                    @foreach($cat['merekList'] as $merek)
                    <div @click="openDetailMerek('{{ $merek->id }}', '{{ $merek->nama_kategori }}')" class="flex flex-col items-center group cursor-pointer">
                        <div class="w-14 h-14 bg-gray-100 border border-transparent rounded-xl flex items-center justify-center text-gray-400 font-bold text-sm tracking-wide group-hover:border-gray-200 group-hover:bg-white group-hover:shadow-sm transition-all duration-200">
                            @if($merek->foto_logo)
                            <img src="{{ asset('storage/' . $merek->foto_logo) }}" alt="{{ $merek->nama_kategori }}" class="w-10 h-10 object-contain">
                            @else
                            {{ Str::limit($merek->nama_kategori, 3, '') }}
                            @endif
                        </div>
                        <span class="mt-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center group-hover:text-gray-700 transition-colors truncate w-full">
                            {{ $merek->nama_kategori }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>

{{-- MODAL TAMBAH TIPE --}}
<div id="tambah-tipe-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/40 backdrop-blur-sm animate-fade-in">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-[24px] shadow-2xl border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 tracking-tight">Tambah Tipe Baru</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-xl text-sm w-9 h-9 ms-auto inline-flex justify-center items-center transition-colors" data-modal-hide="tambah-tipe-modal">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <form action="{{ route('admin.category.storeType') }}" method="POST">
                @csrf
                <div class="p-6 space-y-5">
                    <div>
                        <label for="name" class="block mb-2 text-[11px] font-bold text-gray-900 uppercase tracking-wider">Nama Tipe</label>
                        <input type="text" name="nama_kategori" id="name" class="bg-gray-50 border border-none text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-gray-200 block w-full p-3.5 placeholder-gray-400 placeholder:font-medium" placeholder="Contoh: Mirrorless, Dome Tent..." required>
                        <p class="mt-1.5 text-xs text-gray-400 font-medium">Pastikan nama tipe belum pernah didaftarkan sebelumnya.</p>
                    </div>
                    <div>
                        <label for="main_category" class="block mb-2 text-[11px] font-bold text-gray-900 uppercase tracking-wider">Kategori Terkait</label>
                        <div class="relative">
                            <select id="main_category" name="kategori_utama" class="bg-gray-50 border border-none text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-gray-200 block w-full p-3.5 appearance-none font-semibold pr-10 cursor-pointer">
                                <option value="Kamera">Kamera</option>
                                <option value="Camping">Camping</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end p-6 space-x-3 bg-gray-50/50 border-t border-gray-100">
                    <button data-modal-hide="tambah-tipe-modal" type="button" class="text-gray-700 bg-transparent hover:bg-gray-100 font-bold text-sm px-5 py-2.5 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="text-white bg-black hover:bg-gray-900 font-bold text-sm px-5 py-2.5 rounded-xl transition-all shadow-sm">Simpan Tipe</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH MEREK --}}
<div id="tambah-merek-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/40 backdrop-blur-sm animate-fade-in">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-[24px] shadow-2xl border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 tracking-tight">Tambah Merek Baru</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-xl text-sm w-9 h-9 ms-auto inline-flex justify-center items-center transition-colors" data-modal-hide="tambah-merek-modal">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <form action="{{ route('admin.category.storeBrand') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-5">
                    <div>
                        <label for="name_brand" class="block mb-2 text-[11px] font-bold text-gray-900 uppercase tracking-wider">Nama Merek</label>
                        <input type="text" name="name" id="name_brand" class="bg-gray-50 border border-none text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-gray-200 block w-full p-3.5 placeholder-gray-400 placeholder:font-medium" placeholder="Contoh: Eiger, Consina, Canon, Sony" required>
                    </div>
                    <div>
                        <label for="main_category_brand" class="block mb-2 text-[11px] font-bold text-gray-900 uppercase tracking-wider">Kategori Terkait</label>
                        <div class="relative">
                            <select id="main_category_brand" name="kategori_utama" class="bg-gray-50 border border-none text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-gray-200 block w-full p-3.5 appearance-none font-semibold pr-10 cursor-pointer">
                                <option value="Kamera">Kamera</option>
                                <option value="Camping">Camping</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-[11px] font-bold text-gray-900 uppercase tracking-wider">Logo Merek</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="logo_merek" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-200 border-dashed rounded-[16px] cursor-pointer bg-white hover:bg-gray-50/50 hover:border-gray-300 transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                    <div class="w-10 h-10 bg-gray-50 border border-gray-100 rounded-lg flex items-center justify-center text-gray-700 shadow-sm mb-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-bold text-gray-900">Klik untuk mengunggah logo</p>
                                    <p class="text-[11px] font-medium text-gray-400 mt-1">SVG, PNG, atau JPG (Maks. 2MB)</p>
                                </div>
                                <input id="logo_merek" name="foto_logo" type="file" class="hidden" accept="image/*" />
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <input id="is_active" name="aktif" type="checkbox" checked class="w-4 h-4 text-black bg-gray-50 border-gray-300 rounded-md focus:ring-0 focus:ring-offset-0 checked:bg-black accent-black cursor-pointer">
                        <label for="is_active" class="ms-2 text-sm font-bold text-gray-800 cursor-pointer selection:bg-transparent">Aktifkan Merek untuk produk baru</label>
                    </div>
                </div>
                <div class="flex items-center justify-end p-6 space-x-3 bg-gray-50/50 border-t border-gray-100">
                    <button data-modal-hide="tambah-merek-modal" type="button" class="text-gray-700 bg-transparent hover:bg-gray-100 font-bold text-sm px-5 py-2.5 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="text-white bg-black hover:bg-gray-900 font-bold text-sm px-5 py-2.5 rounded-xl transition-all shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        Simpan Merek
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL DETAIL MEREK (SUDAH DINAMIS AJAX) --}}
<div id="detail-merek-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/40 backdrop-blur-sm animate-fade-in">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-[24px] shadow-2xl border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-white">
                <div class="flex items-center gap-4">
                    <div id="modal-merek-badge" class="w-12 h-12 bg-gray-100 border border-gray-200 rounded-xl flex items-center justify-center text-gray-700 font-bold text-sm shadow-sm uppercase">
                        CAN
                    </div>
                    <div>
                        <h3 id="modal-merek-title" class="text-lg font-bold text-gray-950 tracking-tight leading-tight">Merek</h3>
                        <p id="modal-merek-subtitle" class="text-xs font-medium text-gray-400 mt-0.5">Manajemen Inventaris Sewa</p>
                    </div>
                </div>
                <button type="button" class="px-4 py-2 border border-gray-200 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-emerald-600 transition-all shadow-sm flex items-center gap-1.5 ms-auto">
                    <svg class="w-4 h-4 text-emerald-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    EXPORT EXCEL
                </button>
            </div>
            <div class="p-6 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-3">
                            <th class="pb-3 font-bold">Nama Produk</th>
                            <th class="pb-3 font-bold">Tipe</th>
                            <th class="pb-3 font-bold">Status Unit</th>
                            <th class="pb-3 font-bold">Laju Sewa</th>
                        </tr>
                    </thead>
                    <tbody id="modal-product-tbody" class="divide-y divide-gray-100 text-sm font-semibold text-gray-800">
                        {{-- Data produk dimasukkan otomatis via Javascript Fetch AJAX --}}
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-end p-6 border-t border-gray-100 bg-gray-50/40">
                <button data-modal-hide="detail-merek-modal" type="button" class="px-5 py-2.5 border border-gray-200 bg-white hover:bg-gray-50 rounded-xl text-sm font-bold text-gray-800 transition-colors shadow-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const successToast = document.getElementById('toast-success');
        const dangerToast = document.getElementById('toast-danger');

        if (successToast) {
            setTimeout(() => {
                successToast.remove();
            }, 4000);
        }

        if (dangerToast) {
            setTimeout(() => {
                dangerToast.remove();
            }, 4000);
        }
    });
</script>

@endsection