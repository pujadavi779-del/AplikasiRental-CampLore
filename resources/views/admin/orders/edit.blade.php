@extends('admin.admin')

@section('title', 'Edit Pemesanan - ' . $order->id)

@section('content')

{{-- Navbar Breadcrumb --}}
<div class="fixed top-5 right-6 z-40 left-[calc(272px+24px)] max-sm:left-6 animate-fade-up">
    @include('admin.navbar', [
    'NavParent' => 'Managemen Rental',
    'section' => 'Edit Pemesanan'
    ])
</div>

<div class="max-w-full pb-10">
    <div class="bg-white rounded-[32px] border border-[#d7e6de] shadow-sm overflow-hidden">

        {{-- Header: Padding Luas --}}
        <div class="px-10 py-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0] bg-[#fcfdfb]">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-[#22543D]/5 flex items-center justify-center text-[#22543D]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-[#22543D] font-serif leading-tight">Edit Detail Pesanan</h2>
                    <p class="text-[11px] text-[#7c8b84] mt-0.5 uppercase tracking-widest font-semibold">Order ID: {{ $order->id }}</p>
                </div>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-gray-400 hover:text-[#22543D] transition-colors flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
                Batal & Kembali
            </a>
        </div>

        {{-- Main Form Body: Padding p-10 agar tidak mepet ke garis luar --}}
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="p-10">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

                {{-- Sisi Kiri: Data Relasi --}}
                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] font-bold text-[#22543D] uppercase tracking-widest mb-3 px-1">Informasi Pelanggan</label>
                        <select name="user_id" class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50 text-sm focus:ring-4 focus:ring-[#22543D]/5 focus:border-[#22543D] outline-none transition-all">
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $order->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} — {{ $user->email }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-[#22543D] uppercase tracking-widest mb-3 px-1">Produk Disewa</label>
                        <div class="p-1 rounded-2xl bg-gray-50 border border-gray-100">
                            <select name="product_id" id="product_id" class="w-full px-4 py-3 bg-transparent text-sm font-semibold text-gray-700 outline-none">
                                @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                    data-price="{{ $product->price }}"
                                    {{ $order->product_id == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (Rp {{ number_format($product->price, 0, ',', '.') }}/hari)
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-bold text-[#22543D] uppercase tracking-widest mb-3 px-1">Mulai Sewa</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $order->start_date }}" class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50 text-sm focus:ring-4 focus:ring-[#22543D]/5 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-[#22543D] uppercase tracking-widest mb-3 px-1">Berakhir</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $order->end_date }}" class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50 text-sm focus:ring-4 focus:ring-[#22543D]/5 outline-none transition-all">
                        </div>
                    </div>
                </div>

                {{-- Sisi Kanan: Status & Billing --}}
                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] font-bold text-[#22543D] uppercase tracking-widest mb-3 px-1">Status Transaksi</label>
                        <select name="status" class="w-full px-5 py-4 rounded-2xl border-2 border-[#22543D]/10 bg-[#f1f8f4] text-sm font-bold text-[#22543D] focus:border-[#22543D] outline-none transition-all shadow-sm">
                            <option value="Menunggu" {{ $order->status == 'Menunggu' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="Aktif" {{ $order->status == 'Aktif' ? 'selected' : '' }}>Aktif (Sedang Sewa)</option>
                            <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>Selesai / Kembali</option>
                            <option value="Dibatalkan" {{ $order->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    {{-- Billing Summary Card dengan padding p-8 internal --}}
                    <div class="p-8 rounded-[32px] bg-[#22543D] text-white shadow-xl shadow-[#22543D]/20">
                        <div class="flex justify-between items-start mb-8">
                            <label class="text-[10px] font-bold opacity-60 uppercase tracking-widest">Kalkulasi Biaya</label>
                            <span class="px-2 py-1 bg-white/10 rounded text-[9px] font-bold uppercase tracking-tighter">Auto-Update</span>
                        </div>

                        <div class="space-y-5">
                            <div class="flex justify-between text-xs">
                                <span class="opacity-70">Harga Sewa / Hari</span>
                                <span id="display-price" class="font-semibold text-sm">Rp {{ number_format($order->price_per_day, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="opacity-70">Durasi Sewa</span>
                                <span id="display-days" class="font-semibold text-sm">{{ $order->days }} Hari</span>
                            </div>
                            <div class="pt-6 border-t border-white/10 flex justify-between items-center">
                                <span class="text-xs font-bold uppercase tracking-widest opacity-80">Total Tagihan</span>
                                <span id="display-total" class="text-3xl font-serif font-bold tracking-tight">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <input type="hidden" name="total_price" id="input-total" value="{{ $order->total_price }}">
                    </div>
                </div>

            </div>

            {{-- Footer Buttons --}}
            <div class="mt-14 pt-8 border-t border-[#eef4f0] flex items-center justify-between">
                <p class="text-[10px] text-gray-300 italic">Terakhir diupdate: {{ $order->updated_at->format('d M Y, H:i') }}</p>
                <div class="flex gap-4">
                    <button type="submit" class="bg-[#22543D] hover:bg-[#1B4332] text-white text-xs font-bold px-12 py-4 rounded-2xl transition-all shadow-lg active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
    const productSelect = document.getElementById('product_id');
    const startInput = document.getElementById('start_date');
    const endInput = document.getElementById('end_date');

    function updateBilling() {
        const pricePerDay = productSelect.options[productSelect.selectedIndex].dataset.price || 0;
        const start = new Date(startInput.value);
        const end = new Date(endInput.value);

        if (start && end && end >= start) {
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            const total = diffDays * pricePerDay;

            document.getElementById('display-price').innerText = `Rp ${parseInt(pricePerDay).toLocaleString('id-ID')}`;
            document.getElementById('display-days').innerText = `${diffDays} Hari`;
            document.getElementById('display-total').innerText = `Rp ${total.toLocaleString('id-ID')}`;
            document.getElementById('input-total').value = total;
        }
    }

    [productSelect, startInput, endInput].forEach(el => el.addEventListener('change', updateBilling));
</script>

@endsection