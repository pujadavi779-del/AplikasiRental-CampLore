@extends('admin.admin')

@section('title', 'List Barang Camera')

@section('content')

<div class="fixed top-5 right-6 z-40 left-[calc(272px+24px)] max-sm:left-6 animate-fade-up">
    @include('admin.navbar', [
    'NavParent' => 'Managemen Rental',
    'section' => 'Kamera'
    ])
</div>

<div class="bg-[#F8FAF6] min-h-screen">
    <div class="max-w-full">
        <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

            <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0]">

                <div>
                    <h2 class="text-2xl font-bold text-[#22543D] leading-tight font-serif">
                        Data Inventaris Kamera
                    </h2>

                    <p class="text-[11px] text-[#7c8b84]">
                        Pantau dan kelola stok unit kamera tersedia.
                    </p>
                </div>

                <button class="flex items-center gap-2 bg-[#22543D] hover:bg-[#1B4332] text-white px-5 py-2.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <path d="M12 5v14M5 12h14" />
                    </svg>

                    Tambah Kamera
                </button>
            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse">

                    <thead class="bg-[#f1f8f4] text-[#22543D] uppercase text-[10px] font-bold tracking-[0.1em]">
                        <tr>
                            <th class="px-8 py-4">Unit Kamera</th>
                            <th class="px-6 py-4 text-center">Kategori</th>
                            <th class="px-6 py-4 text-center">Harga Sewa</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>


                    <tbody class="divide-y divide-[#eef4f0]">

                        @foreach($items as $item)

                        <tr class="hover:bg-[#fcfdfb] transition-colors">

                            <td class="px-8 py-5 flex items-center gap-4">

                                <div class="w-12 h-12 rounded-xl bg-black overflow-hidden border border-[#d7e6de]">

                                    @php
                                    $cameraImages = [
                                    'Canon R6' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=200',
                                    'Sony A7III' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?q=80&w=200',
                                    ];

                                    $displayImage = $cameraImages[$item->name] ?? 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=200';
                                    @endphp

                                    <img src="{{ $displayImage }}"
                                        class="object-cover w-full h-full"
                                        alt="{{ $item->name }}">
                                </div>

                                <div>
                                    <div class="font-bold text-[#22543D] text-sm">
                                        {{ $item->name }}
                                    </div>

                                    <div class="text-[9px] text-[#7c8b84] mt-1 italic uppercase tracking-wider">
                                        Unit Inventaris
                                    </div>
                                </div>

                            </td>


                            <td class="px-6 py-5 text-center text-[#22543D] text-xs font-medium">
                                {{ $item->category ?? 'Kamera' }}
                            </td>


                            <td class="px-6 py-5 text-center">
                                <span class="font-bold text-[#22543D] text-sm">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </span>

                                <span class="text-[9px] text-gray-300 ml-1">
                                    /hari
                                </span>
                            </td>


                            <td class="px-6 py-5 text-center">

                                @if($item->stock > 0)
                                <span class="px-3 py-1 rounded-full text-[9px] font-bold bg-[#f1f8f4] text-[#22543D] border border-[#d7e6de]">
                                    Tersedia ({{ $item->stock }})
                                </span>
                                @else
                                <span class="px-3 py-1 rounded-full text-[9px] font-bold bg-[#FDF4F8] text-[#D977A8] border border-[#f3d6e5]">
                                    Habis
                                </span>
                                @endif

                            </td>


                            <td class="px-6 py-5 text-center">
                                <div class="flex justify-center gap-1">

                                    <a href="{{ route('camera.edit', $item->id) }}"
                                        class="p-2 text-gray-400 hover:text-[#D977A8] transition-colors">
                                        ✏️
                                    </a>

                                    <form action="{{ route('camera.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus?')"
                                            class="p-2 text-gray-300 hover:text-red-400 transition-colors">
                                            🗑️
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                        @endforeach

                    </tbody>
                </table>

            </div>


            <div class="p-5 bg-[#fcfdfb] border-t border-[#eef4f0] flex items-center justify-between">

                <p class="text-[10px] font-bold text-[#22543D] uppercase tracking-widest">
                    Halaman 1 dari 3
                </p>

                <div class="flex gap-2">
                    <button class="w-8 h-8 flex items-center justify-center border border-[#d7e6de] rounded-lg text-[#22543D] bg-white hover:bg-[#f1f8f4]">
                        ←
                    </button>

                    <button class="w-8 h-8 flex items-center justify-center border border-[#d7e6de] rounded-lg text-[#22543D] bg-white hover:bg-[#f1f8f4]">
                        →
                    </button>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection