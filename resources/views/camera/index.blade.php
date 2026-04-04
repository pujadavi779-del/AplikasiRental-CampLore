@extends('admin.admin')

@section('title', 'List Barang Camera')

@section('content')
<style>
    /* Paksa background body transparan agar mengikuti warna sage dari sidebar/dashboard */
    body,
    .antialiased,
    main {
        background-color: #f8faf6 !important;
    }

    /* Font khusus untuk judul */
    .font-serif-display {
        font-family: 'DM Serif Display', serif;
    }

    /* Menghilangkan scrollbar pada tabel agar lebih rapi */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    /* Penyesuaian posisi Navbar karena induk sudah punya pt-24 */
    .custom-nav {
        position: fixed;
        top: 20px;
        /* Jarak dari paling atas */
        right: 24px;
        left: calc(16rem + 24px);
        /* 16rem adalah lebar sm:ml-64 sidebar kamu */
        z-index: 40;
    }

    @media (max-width: 640px) {
        .custom-nav {
            left: 24px;
        }
    }
</style>

{{-- NAVBAR ATAS --}}
<div class="custom-nav">
    <nav class="flex items-center justify-between px-6 py-3 bg-white border border-[#e2e8da] rounded-2xl shadow-sm">
        <div class="flex items-center gap-2">
            <span class="text-[#7a8a6e] text-[10px] font-bold uppercase tracking-widest">Management</span>
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#7a8a6e" stroke-width="3">
                <path d="M9 18l6-6-6-6" />
            </svg>
            <span class="text-[#2d3a24] text-[10px] font-bold uppercase tracking-widest">Kamera</span>
        </div>

        <div class="flex items-center gap-4">
            <div class="relative hidden md:block">
                <span class="absolute inset-y-0 left-3 flex items-center text-[#7a8a6e]">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </span>
                <input type="text" placeholder="Cari unit..." class="pl-9 pr-4 py-1.5 bg-[#f4f7f0] border-none rounded-lg text-xs w-40 focus:w-56 transition-all focus:ring-1 focus:ring-[#5d6e4a]">
            </div>
            <button class="text-[#5d6e4a] p-1.5 hover:bg-[#f4f7f0] rounded-full transition-colors relative">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
                <div class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-red-400 rounded-full border border-white text-[0px]">.</div>
            </button>
        </div>
    </nav>
</div>

{{-- AREA KONTEN UTAMA --}}
<div class="max-w-full">
    <div class="bg-white rounded-[28px] border border-[#e2e8da] shadow-sm overflow-hidden">

        {{-- Header Card --}}
        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#f0f4e8]">
            <div>
                <h2 class="text-2xl font-bold text-[#2d3a24] font-serif-display leading-tight">Data Inventaris Kamera</h2>
                <p class="text-[11px] text-[#7a8a6e]">Pantau dan kelola stok unit kamera tersedia.</p>
            </div>
            <button class="flex items-center gap-2 bg-[#5d6e4a] hover:bg-[#4a583b] text-white px-5 py-2.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Tambah Kamera
            </button>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead class="bg-[#f4f7f0]/60 text-[#5d6e4a] uppercase text-[10px] font-bold tracking-[0.1em]">
                    <tr>
                        <th class="px-8 py-4">Unit Kamera</th>
                        <th class="px-6 py-4 text-center">Kategori</th>
                        <th class="px-6 py-4 text-center">Harga Sewa</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0f4e8]">
                    @foreach($items as $item)
                    <tr class="hover:bg-[#fcfdfb] transition-colors group">
                        <td class="px-8 py-5 flex items-center gap-4">
                            {{-- Foto Kamera --}}
                            <div class="w-12 h-12 rounded-xl bg-black overflow-hidden shadow-inner shrink-0 border border-[#e2e8da]">
                                @php
                                $cameraImages = [
                                'Canon R6' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=200',
                                'Sony A7III' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?q=80&w=200',
                                ];

                                // default kalau nama tidak cocok
                                $displayImage = $cameraImages[$item->name] ?? 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=200';
                                @endphp


                                <img src="{{ $displayImage }}"
                                    class="object-cover w-full h-full opacity-90"
                                    alt="{{ $item->name }}">
                            </div>
                            <div>
                                <div class="font-bold text-[#2d3a24] text-sm leading-none">{{ $item->name }}</div>
                                <div class="text-[9px] text-[#7a8a6e] mt-1 italic uppercase tracking-wider">Unit Inventaris</div>
                            </div>
                        </td>

                        <td class="px-6 py-5 text-center text-[#5d6e4a] text-xs font-medium">
                            {{ $item->category ?? 'Kamera' }}
                        </td>

                        <td class="px-6 py-5 text-center">
                            <span class="font-bold text-[#2d3a24] text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            <span class="text-[9px] text-gray-300 font-normal ml-0.5">/hari</span>
                        </td>

                        <td class="px-6 py-5 text-center">
                            {{-- Logika Warna Status Berdasarkan Stok --}}
                            @if($item->stock > 0)
                            <span class="px-3 py-1 rounded-full text-[9px] font-bold bg-[#eef5e8] text-[#5d6e4a] border border-[#dce8d0]">
                                Tersedia ({{ $item->stock }})
                            </span>
                            @else
                            <span class="px-3 py-1 rounded-full text-[9px] font-bold bg-[#fdf2f2] text-[#e67e7e] border border-[#f9e2e2]">
                                Habis
                            </span>
                            @endif
                        </td>

                        <td class="px-6 py-5 text-center">
                            <div class="flex justify-center gap-1">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('camera.edit', $item->id) }}" class="p-2 text-gray-400 hover:text-[#5d6e4a] transition-colors">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('camera.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="p-2 text-gray-300 hover:text-red-400 transition-colors">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Footer Card --}}
        <div class="p-5 bg-[#fcfdfb] border-t border-[#f0f4e8] flex items-center justify-between">
            <p class="text-[10px] font-bold text-[#7a8a6e] uppercase tracking-widest">Halaman 1 dari 3</p>
            <div class="flex gap-2">
                <button class="w-8 h-8 flex items-center justify-center border border-[#e2e8da] rounded-lg text-[#5d6e4a] bg-white hover:bg-[#f4f7f0] transition-all"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M15 18l-6-6 6-6" />
                    </svg></button>
                <button class="w-8 h-8 flex items-center justify-center border border-[#e2e8da] rounded-lg text-[#5d6e4a] bg-white hover:bg-[#f4f7f0] transition-all"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M9 18l6-6-6-6" />
                    </svg></button>
            </div>
        </div>
    </div>
</div>
@endsection