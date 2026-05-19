@extends('layouts.admin')

@section('title', 'Kategori Produk - Camplore Admin')

@section('content')

<div class="mb-6">
    @include('components.navbar_judul_LP', [
    'NavParent' => 'Manajemen Operasional',
    'section' => 'Kategori Produk'
    ])
</div>

<div class="max-w-full space-y-6" x-data="{ 
    activeTab: 'kamera', 
    openDetailMerek(namaMerek) {
        // Logika pemicu modal detail inventaris merek secara programmatic via Flowbite
        const modalElement = document.getElementById('detail-merek-modal');
        if (modalElement) {
            // Update nama teks di dalam modal secara reaktif
            document.getElementById('modal-merek-title').innerText = namaMerek;
            document.getElementById('modal-merek-subtitle').innerText = 'Manajemen Inventaris Sewa - ' + namaMerek;
            document.getElementById('modal-merek-badge').innerText = namaMerek.substring(0, 3);
            
            const modal = new Modal(modalElement);
            modal.show();
        }
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

        <div x-show="activeTab === 'kamera'" class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <div class="lg:col-span-7">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-[11px] font-bold text-[#2d6b50] uppercase tracking-wider">Tipe Kamera</span>
                    <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded text-[10px] font-bold uppercase tracking-wider">{{ count($tipeKamera) }} Item</span>
                </div>
                <br>
                <div class="w-full text-left text-[11px] mb-3 flex justify-between font-bold text-gray-400 uppercase tracking-wider px-1">
                    <div>Nama Tipe</div>
                    <div>Aksi</div>
                </div>

                <div class="divide-y divide-gray-100 border-t border-gray-100">
                    @foreach($tipeKamera as $tipe)
                    <div class="flex justify-between items-center py-3.5 px-1 hover:bg-gray-50/30 transition-colors">
                        <span class="font-bold text-gray-800 text-sm">{{ $tipe['nama'] }}</span>
                        <div class="flex gap-3 text-xs font-bold">
                            <button class="text-gray-400 hover:text-gray-600 transition-colors">Edit</button>
                            <button class="text-red-500 hover:text-red-600 transition-colors">Hapus</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="flex justify-between items-center mb-5">
                    <span class="text-[11px] font-bold text-[#2d6b50] uppercase tracking-wider">Merek Kamera</span>
                    <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded text-[10px] font-bold uppercase tracking-wider">{{ count($merekKamera) }} Item</span>
                </div>

                <div class="grid grid-cols-4 sm:grid-cols-5 gap-4">
                    @foreach($merekKamera as $merek)
                    <div @click="openDetailMerek('{{ $merek }}')" class="flex flex-col items-center group cursor-pointer">
                        <div class="w-14 h-14 bg-gray-100 border border-transparent rounded-xl flex items-center justify-center text-gray-400 font-bold text-sm tracking-wide group-hover:border-gray-200 group-hover:bg-white group-hover:shadow-sm transition-all duration-200">
                            {{ Str::limit($merek, 3, '') }}
                        </div>
                        <span class="mt-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center group-hover:text-gray-700 transition-colors truncate w-full">
                            {{ $merek }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'camping'" class="grid grid-cols-1 lg:grid-cols-12 gap-12" style="display: none;">
            <div class="lg:col-span-7">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-[11px] font-bold text-[#2d6b50] uppercase tracking-wider">Tipe Peralatan</span>
                    <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded text-[10px] font-bold uppercase tracking-wider">{{ count($tipeCamping) }} Item</span>
                </div>
                <br>
                <div class="w-full text-left text-[11px] mb-3 flex justify-between font-bold text-gray-400 uppercase tracking-wider px-1">
                    <div>Nama Tipe</div>
                    <div>Aksi</div>
                </div>

                <div class="divide-y divide-gray-100 border-t border-gray-100">
                    @foreach($tipeCamping as $tipe)
                    <div class="flex justify-between items-center py-3.5 px-1 hover:bg-gray-50/30 transition-colors">
                        <span class="font-bold text-gray-800 text-sm">{{ $tipe['nama'] }}</span>
                        <div class="flex gap-3 text-xs font-bold">
                            <button class="text-gray-400 hover:text-gray-600 transition-colors">Edit</button>
                            <button class="text-red-500 hover:text-red-600 transition-colors">Hapus</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="flex justify-between items-center mb-5">
                    <span class="text-[11px] font-bold text-[#2d6b50] uppercase tracking-wider">Merek camping</span>
                    <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded text-[10px] font-bold uppercase tracking-wider">{{ count($merekCamping) }} Item</span>
                </div>

                <div class="grid grid-cols-4 sm:grid-cols-5 gap-4">
                    @foreach($merekCamping as $merek)
                    <div @click="openDetailMerek('{{ $merek }}')" class="flex flex-col items-center group cursor-pointer">
                        <div class="w-14 h-14 bg-gray-100 border border-transparent rounded-xl flex items-center justify-center text-gray-400 font-bold text-sm tracking-wide group-hover:border-gray-200 group-hover:bg-white group-hover:shadow-sm transition-all duration-200">
                            {{ Str::limit($merek, 3, '') }}
                        </div>
                        <span class="mt-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center group-hover:text-gray-700 transition-colors truncate w-full">
                            {{ $merek }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

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
            <form action="#" method="POST">
                @csrf
                <div class="p-6 space-y-5">
                    <div>
                        <label for="nama_tipe" class="block mb-2 text-[11px] font-bold text-gray-900 uppercase tracking-wider">Nama Tipe</label>
                        <input type="text" name="nama_tipe" id="nama_tipe" class="bg-gray-50 border border-none text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-gray-200 block w-full p-3.5 placeholder-gray-400 placeholder:font-medium" placeholder="Contoh: Mirrorless, Dome Tent..." required>
                        <p class="mt-1.5 text-xs text-gray-400 font-medium">Pastikan nama tipe belum pernah didaftarkan sebelumnya.</p>
                    </div>
                    <div>
                        <label for="kategori" class="block mb-2 text-[11px] font-bold text-gray-900 uppercase tracking-wider">Kategori Terkait</label>
                        <div class="relative">
                            <select id="kategori" name="kategori" class="bg-gray-50 border border-none text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-gray-200 block w-full p-3.5 appearance-none font-semibold pr-10 cursor-pointer">
                                <option value="kamera">Kamera</option>
                                <option value="camping">Camping</option>
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
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-5">
                    <div>
                        <label for="nama_merek" class="block mb-2 text-[11px] font-bold text-gray-900 uppercase tracking-wider">Nama Merek</label>
                        <input type="text" name="nama_merek" id="nama_merek" class="bg-gray-50 border border-none text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-gray-200 block w-full p-3.5 placeholder-gray-400 placeholder:font-medium" placeholder="Contoh: Eiger, Consina, Naturehike" required>
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
                                <input id="logo_merek" name="logo_merek" type="file" class="hidden" accept="image/*" />
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <input id="is_active" name="is_active" type="checkbox" checked class="w-4 h-4 text-black bg-gray-50 border-gray-300 rounded-md focus:ring-0 focus:ring-offset-0 checked:bg-black accent-black cursor-pointer">
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

<div id="detail-merek-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/40 backdrop-blur-sm animate-fade-in">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-[24px] shadow-2xl border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-white">
                <div class="flex items-center gap-4">
                    <div id="modal-merek-badge" class="w-12 h-12 bg-gray-100 border border-gray-200 rounded-xl flex items-center justify-center text-gray-700 font-bold text-sm shadow-sm">
                        Can
                    </div>
                    <div>
                        <h3 id="modal-merek-title" class="text-lg font-bold text-gray-950 tracking-tight leading-tight">
                            Canon
                        </h3>
                        <p id="modal-merek-subtitle" class="text-xs font-medium text-gray-400 mt-0.5">
                            Manajemen Inventaris Sewa - Canon
                        </p>
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
                    <tbody class="divide-y divide-gray-100 text-sm font-semibold text-gray-800">
                        <tr class="hover:bg-gray-50/40 transition-colors">
                            <td class="py-4 font-bold text-gray-950">Canon EOS R6</td>
                            <td class="py-4 text-gray-500 font-medium">Mirrorless</td>
                            <td class="py-4">
                                <span class="px-2.5 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-extrabold tracking-wide uppercase">5 Unit Siap Sewa</span>
                            </td>
                            <td class="py-4 text-gray-600 italic font-medium">Rp 250rb / hari</td>
                        </tr>
                        <tr class="hover:bg-gray-50/40 transition-colors">
                            <td class="py-4 font-bold text-gray-950">Canon EOS R</td>
                            <td class="py-4 text-gray-500 font-medium">Mirrorless</td>
                            <td class="py-4">
                                <span class="px-2.5 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-extrabold tracking-wide uppercase">2 Unit Siap Sewa</span>
                            </td>
                            <td class="py-4 text-gray-600 italic font-medium">Rp 200rb / hari</td>
                        </tr>
                        <tr class="hover:bg-gray-50/40 transition-colors">
                            <td class="py-4 font-bold text-gray-950">Canon 5D Mark IV</td>
                            <td class="py-4 text-gray-500 font-medium">DSLR</td>
                            <td class="py-4">
                                <span class="px-2.5 py-1 bg-red-50 text-red-500 rounded-full text-[10px] font-extrabold tracking-wide uppercase">Sedang Disewa</span>
                            </td>
                            <td class="py-4 text-gray-600 italic font-medium">Rp 180rb / hari</td>
                        </tr>
                        <tr class="hover:bg-gray-50/40 transition-colors">
                            <td class="py-4 font-bold text-gray-950">Canon EOS 70D</td>
                            <td class="py-4 text-gray-500 font-medium">DSLR</td>
                            <td class="py-4">
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-500 rounded-full text-[10px] font-extrabold tracking-wide uppercase">Rusak/Nonaktif</span>
                            </td>
                            <td class="py-4 text-gray-400 font-medium">-</td>
                        </tr>
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

@endsection