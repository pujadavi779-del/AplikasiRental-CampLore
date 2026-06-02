@extends('layouts.admin')

@section('title', 'Transaksi Pembayaran - CampLore')

@php
    $NavParent = 'Manajemen Operasional';
    $section = 'Pengguna';
@endphp

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap');
    * { font-family: 'Inter', sans-serif; }
    .font-serif { font-family: 'Playfair Display', serif !important; }
    [x-cloak] { display: none !important; }
</style>

<div x-data="{ openDetail: false, selectedData: {} }" class="max-w-full">

    <div class="max-w-full">
        <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

            {{-- HEADER --}}
            <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0]">
                <div>
                    <h2 class="text-2xl font-bold text-[#22543D] font-serif leading-tight">Pembayaran</h2>
                    <p class="text-[11px] text-[#7c8b84] mt-0.5">Daftar semua transaksi pembayaran sewa unit.</p>
                </div>
            </div>

            {{-- SEARCH --}}
            <div class="p-6 border-b border-[#f1f8f4]">
                <form method="GET" action="{{ route('admin.pembayaran') }}">
                    <div class="relative w-full md:w-80">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"/>
                            </svg>
                        </span>
                        <input type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari ID Pesanan atau Tanggal..."
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-[#d7e6de] rounded-xl text-xs focus:ring-1 focus:ring-[#ED64A6] focus:border-[#ED64A6] outline-none shadow-inner">
                    </div>
                </form>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left table-fixed min-w-[1000px]">
                    <thead class="bg-[#f1f8f4] text-[#22543D] uppercase text-[10px] font-bold tracking-widest border-b border-[#e4f0ea]">
                        <tr>
                            <th class="px-4 py-4 border-r border-[#e4f0ea] w-[22%]">ID Pesanan</th>
                            <th class="px-4 py-4 border-r border-[#e4f0ea] w-[18%]">Pelanggan</th>
                            <th class="px-4 py-4 border-r border-[#e4f0ea] w-[13%] text-center">Status</th>
                            <th class="px-4 py-4 border-r border-[#e4f0ea] w-[18%]">Harga yang Dibayar</th>
                            <th class="px-4 py-4 border-r border-[#e4f0ea] w-[18%]">Tanggal Dibuat</th>
                            <th class="px-4 py-4 w-[11%] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#eef4f0]">

                        @forelse($payments as $order)
                        @php
                            // Mapping status order ke label tampilan
                            $statusMap = [
                                'belum_bayar'  => ['label' => 'Belum Bayar', 'bg' => 'bg-gray-100',       'text' => 'text-gray-500',    'border' => 'border-gray-200'],
                                'dikemas'      => ['label' => 'Dikemas',      'bg' => 'bg-orange-50',      'text' => 'text-orange-700',  'border' => 'border-orange-200'],
                                'dikirim'      => ['label' => 'Dikirim',      'bg' => 'bg-blue-50',        'text' => 'text-blue-700',    'border' => 'border-blue-200'],
                                'selesai'      => ['label' => 'Selesai',      'bg' => 'bg-emerald-100',    'text' => 'text-[#22543D]',   'border' => 'border-emerald-200'],
                                'pengembalian' => ['label' => 'Pengembalian', 'bg' => 'bg-purple-50',      'text' => 'text-purple-700',  'border' => 'border-purple-200'],
                                'dibatalkan'   => ['label' => 'Dibatalkan',   'bg' => 'bg-red-50',         'text' => 'text-red-600',     'border' => 'border-red-200'],
                            ];
                            $st = $statusMap[$order->status] ?? ['label' => ucfirst($order->status), 'bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'border' => 'border-gray-200'];

                            // Hitung total order (semua order dengan order_id yang sama)
                            $allOrderItems = \App\Models\Order::where('order_id', $order->order_id)->get();
                            $totalBayar = $allOrderItems->sum('total_price') + $order->shipping_cost + $order->service_fee;

                            // Nama & inisial user
                            $namaUser = $order->user->name ?? 'Pelanggan';
                            $parts = explode(' ', $namaUser);
                            $inisial = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));

                            // Produk-produk dalam order ini
                            $orderItems = $allOrderItems->map(fn($o) => [
                                'nama'     => $o->product->name ?? 'Produk',
                                'kategori' => $o->product->category ?? 'Lainnya',
                            ]);
                        @endphp

                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 border-r text-xs font-bold text-[#22543D]">
                                {{ $order->order_id }}
                            </td>
                            <td class="px-4 py-4 border-r text-xs text-gray-700 truncate">
                                {{ $namaUser }}
                            </td>
                            <td class="px-4 py-4 border-r text-center">
                                <span class="px-3 py-1 {{ $st['bg'] }} {{ $st['text'] }} text-[10px] font-bold rounded-lg border {{ $st['border'] }}">
                                    {{ $st['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-4 border-r text-xs font-black text-[#22543D]">
                                Rp {{ number_format($totalBayar, 2, ',', '.') }}
                            </td>
                            <td class="px-4 py-4 border-r text-[10px] text-gray-500 uppercase">
                                {{ $order->created_at->format('d M Y, H:i:s') }}
                            </td>
                            <td class="px-4 py-4 text-center">
                                <button
                                    @click="selectedData = {
                                        id: '{{ $order->order_id }}',
                                        nama: '{{ addslashes($namaUser) }}',
                                        email: '{{ $order->user->email ?? '' }}',
                                        inisial: '{{ $inisial }}',
                                        status: '{{ $st['label'] }}',
                                        statusColor: '{{ in_array($order->status, ['selesai','dikemas']) ? 'emerald' : (in_array($order->status, ['dikirim']) ? 'blue' : (in_array($order->status, ['dibatalkan']) ? 'red' : 'orange')) }}',
                                        metode: 'QRIS / Transfer',
                                        total: 'Rp {{ number_format($totalBayar, 0, ',', '.') }}',
                                        mulai: '{{ optional($order->start_date)->format('d M Y') ?? '-' }}',
                                        selesai: '{{ optional($order->end_date)->format('d M Y') ?? '-' }}',
                                        noHp: '{{ $order->customer_phone ?? '-' }}',
                                        alamat: '{{ addslashes($order->customer_address ?? '-') }}',
                                        items: {{ json_encode($orderItems->values()) }}
                                    }; openDetail = true"
                                    class="px-4 py-1.5 bg-[#22543D] text-white text-[10px] font-bold rounded-xl hover:bg-[#1a402e] transition-all shadow-sm active:scale-95">
                                    Detail
                                </button>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-400 text-sm">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="font-medium">Belum ada transaksi pembayaran</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- FOOTER / PAGINATION --}}
            <div class="px-6 py-4 bg-[#fcfdfb] border-t border-[#f1f8f4] flex justify-between items-center text-[10px] font-bold text-gray-400 uppercase">
                <span>Menampilkan {{ $payments->count() }} dari {{ $payments->total() }} Pembayaran</span>
                <div class="flex gap-2 items-center">
                    {{-- Prev --}}
                    @if($payments->onFirstPage())
                        <button disabled class="w-9 h-9 border rounded-xl text-gray-300 cursor-not-allowed">‹</button>
                    @else
                        <a href="{{ $payments->previousPageUrl() }}" class="w-9 h-9 border rounded-xl hover:bg-gray-50 transition-colors flex items-center justify-center">‹</a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach($payments->getUrlRange(1, $payments->lastPage()) as $page => $url)
                        @if($page == $payments->currentPage())
                            <button class="w-9 h-9 bg-[#22543D] text-white rounded-xl shadow-md">{{ $page }}</button>
                        @else
                            <a href="{{ $url }}" class="w-9 h-9 border rounded-xl hover:bg-gray-50 transition-colors flex items-center justify-center text-gray-600">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if($payments->hasMorePages())
                        <a href="{{ $payments->nextPageUrl() }}" class="w-9 h-9 border rounded-xl hover:bg-gray-50 transition-colors flex items-center justify-center">›</a>
                    @else
                        <button disabled class="w-9 h-9 border rounded-xl text-gray-300 cursor-not-allowed">›</button>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div x-show="openDetail"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-[#22543D]/20 backdrop-blur-sm"
         x-cloak>

        <div @click.away="openDetail = false" class="bg-white w-full max-w-sm rounded-2xl shadow-xl overflow-hidden border border-gray-100">

            {{-- Header --}}
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-gray-800">Detail Transaksi</h2>
                    <p class="text-[11px] text-gray-400 mt-0.5" x-text="selectedData.id"></p>
                </div>
                <button @click="openDetail = false" class="text-gray-300 hover:text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="px-5 py-4 flex flex-col gap-4 max-h-[70vh] overflow-y-auto">

                {{-- Info Pelanggan --}}
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center text-sm font-semibold text-emerald-700 shrink-0"
                         x-text="selectedData.inisial"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800" x-text="selectedData.nama"></p>
                        <p class="text-[11px] text-gray-400" x-text="selectedData.email"></p>
                    </div>
                    <span class="text-[11px] px-2 py-1 rounded-lg shrink-0 border"
                          :class="{
                              'bg-emerald-50 text-emerald-600 border-emerald-100': selectedData.statusColor === 'emerald',
                              'bg-orange-50 text-orange-500 border-orange-100': selectedData.statusColor === 'orange',
                              'bg-red-50 text-red-500 border-red-100': selectedData.statusColor === 'red',
                              'bg-blue-50 text-blue-500 border-blue-100': selectedData.statusColor === 'blue',
                              'bg-pink-50 text-pink-500 border-pink-100': !['emerald','orange','red','blue'].includes(selectedData.statusColor)
                          }"
                          x-text="selectedData.status"></span>
                </div>

                {{-- Info Pembayaran --}}
                <table class="w-full text-sm">
                    <tr>
                        <td class="py-1.5 text-gray-400">Metode</td>
                        <td class="py-1.5 text-right text-gray-700" x-text="selectedData.metode"></td>
                    </tr>
                    <tr>
                        <td class="py-1.5 text-gray-400">Total Bayar</td>
                        <td class="py-1.5 text-right font-semibold text-emerald-600" x-text="selectedData.total"></td>
                    </tr>
                    <tr>
                        <td class="py-1.5 text-gray-400">No. HP</td>
                        <td class="py-1.5 text-right text-gray-700" x-text="selectedData.noHp"></td>
                    </tr>
                    <tr>
                        <td class="py-1.5 text-gray-400 align-top">Alamat</td>
                        <td class="py-1.5 text-right text-gray-700 text-xs" x-text="selectedData.alamat"></td>
                    </tr>
                </table>

                {{-- Unit Disewa --}}
                <div>
                    <p class="text-[11px] text-gray-400 font-medium mb-2 flex items-center gap-1.5">
                        Unit disewa
                        <span class="bg-gray-100 text-gray-500 text-[10px] px-2 py-0.5 rounded-full"
                              x-text="selectedData.items ? selectedData.items.length : 0"></span>
                    </p>
                    <div class="flex flex-col gap-1.5">
                        <template x-for="item in selectedData.items" :key="item.nama">
                            <div class="flex items-center justify-between px-3 py-2 border border-gray-100 rounded-xl">
                                <span class="text-sm text-gray-700" x-text="item.nama"></span>
                                <span class="text-[11px] px-2 py-0.5 rounded-full bg-gray-100 text-gray-500"
                                      x-text="item.kategori"></span>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Tanggal Sewa --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="p-3 bg-emerald-50 border border-emerald-100 rounded-xl">
                        <p class="text-[10px] font-semibold text-emerald-600 mb-1">Mulai</p>
                        <p class="text-xs font-semibold text-emerald-700" x-text="selectedData.mulai"></p>
                    </div>
                    <div class="p-3 bg-orange-50 border border-orange-100 rounded-xl">
                        <p class="text-[10px] font-semibold text-orange-500 mb-1">Selesai</p>
                        <p class="text-xs font-semibold text-orange-600" x-text="selectedData.selesai"></p>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="px-5 py-3 border-t border-gray-100 text-center">
                <button @click="openDetail = false" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
                    Tutup
                </button>
            </div>

        </div>
    </div>

</div>

@endsection