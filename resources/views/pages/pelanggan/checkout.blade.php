<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - Camplore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">\
</head>

<body class="text-gray-800 pb-32 font-['Plus_Jakarta_Sans'] bg-white">

    @include('layouts.landingpage')

    <main class="max-w-4xl mx-auto px-4 py-8">

        <h1 class="text-2xl font-black text-gray-900 mb-6">Checkout Pesanan</h1>

        {{-- Alamat --}}
        <div class="border border-gray-200 rounded-2xl p-5 mb-4">
            <div class="flex items-center gap-2 text-[#FF6B95] mb-3">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
                <span class="text-xs font-bold uppercase tracking-widest">Alamat Pengiriman</span>
            </div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-bold text-gray-900">
                        <span id="display-name">{{ auth()->user()->name ?? '-' }}</span>
                        <span class="text-gray-400 font-normal mx-1">·</span>
                        <span id="display-phone" class="text-gray-500 font-semibold text-sm">— Belum ada no. HP</span>
                    </p>
                    <p id="display-address" class="text-sm text-gray-500 mt-0.5">Masukkan alamat pengiriman kamu</p>
                </div>
                <button onclick="openAddressModal()" type="button"
                    class="text-xs font-bold text-blue-500 hover:underline flex-shrink-0 ml-4 relative z-10 cursor-pointer">
                    Ubah
                </button>
            </div>
        </div>

        {{-- Produk --}}
        <div class="border border-gray-200 rounded-2xl overflow-hidden mb-4">

            {{-- Header --}}
            <div class="px-5 py-3 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <p class="text-sm font-bold text-gray-900">Produk Dipesan</p>
                    @php
                    $itemNames = $carts->map(fn($c) => $c->item->name ?? '')->filter()->join(', ');
                    $waText = urlencode('Halo Admin Camplore, saya ingin tanya pesanan: ' . $itemNames);
                    @endphp
                    <a href="https://wa.me/6281276903211?text={{ $waText }}" target="_blank"
                        class="flex items-center gap-1.5 text-xs font-bold text-green-600 hover:text-green-700 transition">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.237 3.483 8.42-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.308 1.654zm6.757-4.791c1.512.897 3.035 1.347 4.516 1.348 5.409 0 9.809-4.397 9.811-9.808 0-2.618-1.02-5.08-2.87-6.932-1.85-1.851-4.311-2.872-6.93-2.873-5.41 0-9.811 4.401-9.813 9.813 0 1.748.458 3.45 1.321 4.949l-.997 3.641 3.763-.988z" />
                        </svg>
                        Chat Sekarang
                    </a>
                </div>
                <div class="hidden md:grid grid-cols-[120px_60px_100px] gap-4">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center">Harga/Hari</p>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center">Qty</p>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest text-right">Subtotal</p>
                </div>
            </div>

            {{-- Items --}}
            @php $totalSubtotal = 0; @endphp
            @forelse($carts as $cart)
            @php
            $days = ($cart->start_date && $cart->end_date)
            ? max(1, \Carbon\Carbon::parse($cart->start_date)->diffInDays($cart->end_date))
            : 1;
            $subtotal = ($cart->item->price ?? 0) * $cart->quantity * $days;
            $totalSubtotal += $subtotal;
            @endphp

            <div class="border-b border-gray-100 last:border-0">

                {{-- Baris produk --}}
                <div class="grid grid-cols-[1fr_120px_60px_100px] gap-4 items-center px-5 py-4">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0 overflow-hidden text-xl">
                            @if($cart->item && $cart->item->image)
                            <img src="{{ str_starts_with($cart->item->image, 'http') ? $cart->item->image : asset('storage/'.$cart->item->image) }}"
                                class="w-full h-full object-cover" alt="{{ $cart->item->name }}">
                            @else
                            📦
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $cart->item->name ?? '-' }}</p>
                            <p class="text-[11px] font-semibold text-[#FF6B95] mt-0.5">Kategori: {{ $cart->item->category ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="text-center">
                        <p class="text-sm font-bold text-gray-700">Rp{{ number_format($cart->item->price ?? 0, 0, ',', '.') }}</p>
                        <p class="text-[10px] text-gray-400">/ hari</p>
                    </div>

                    <div class="text-center text-sm font-bold text-gray-700">{{ $cart->quantity }}</div>

                    <div class="text-right text-sm font-bold text-[#FF6B95]">
                        Rp{{ number_format($subtotal, 0, ',', '.') }}
                    </div>
                </div>

                {{-- Tanggal sewa --}}
                <div class="mx-5 mb-4 px-4 py-2.5 bg-gray-50 rounded-xl flex items-center gap-3">
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2" />
                        <path stroke-width="2" d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                    <span class="text-[11px] text-gray-400">Sewa:</span>
                    @if($cart->start_date && $cart->end_date)
                    <span class="text-[11px] font-bold text-[#FF6B95]">
                        {{ \Carbon\Carbon::parse($cart->start_date)->format('d/m/Y') }}
                        –
                        {{ \Carbon\Carbon::parse($cart->end_date)->format('d/m/Y') }}
                    </span>
                    <span class="bg-pink-100 text-[#FF6B95] text-[10px] font-bold px-2.5 py-0.5 rounded-full">
                        {{ $days }} hari
                    </span>
                    @else
                    <span class="text-[11px] text-gray-300">— Belum ada tanggal</span>
                    @endif
                </div>

                {{-- Catatan --}}
                <div class="mx-5 mb-4">
                    <p class="text-[10px] text-gray-400 font-semibold mb-1">Catatan (opsional)</p>
                    <textarea rows="2" placeholder="Contoh: tolong bawa baterai cadangan, kondisi harus mulus, dll."
                        class="w-full text-sm p-3 border border-gray-200 rounded-xl outline-none focus:border-[#FF6B95] transition resize-none text-gray-700 placeholder-gray-300"></textarea>
                </div>

            </div>
            @empty
            <div class="p-10 text-center text-gray-400 italic">Tidak ada produk.</div>
            @endforelse

        </div>

        {{-- Metode Pembayaran --}}
        <div class="border border-gray-200 rounded-2xl p-5 mb-4">
            <div class="flex items-center gap-2 text-[#FF6B95] mb-4">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <span class="text-xs font-bold uppercase tracking-widest">Metode Pembayaran</span>
            </div>
            <div class="flex flex-wrap gap-3">
                <button onclick="selectPayment(this)"
                    class="px-6 py-2 border-2 border-[#FF6B95] text-[#FF6B95] rounded-xl font-bold text-sm bg-pink-50">
                    Transfer Bank
                </button>
                <button onclick="selectPayment(this)"
                    class="px-6 py-2 border-2 border-gray-200 text-gray-400 rounded-xl font-bold text-sm hover:border-[#FF6B95] hover:text-[#FF6B95] transition">
                    QRIS
                </button>
                <button onclick="selectPayment(this)"
                    class="px-6 py-2 border-2 border-gray-200 text-gray-400 rounded-xl font-bold text-sm hover:border-[#FF6B95] hover:text-[#FF6B95] transition">
                    Gopay
                </button>
            </div>
        </div>

        {{-- Ringkasan --}}
        <div class="border border-gray-200 rounded-2xl p-5 mb-4">

            @foreach($carts as $cart)
            @php
            $d = ($cart->start_date && $cart->end_date)
            ? max(1, \Carbon\Carbon::parse($cart->start_date)->diffInDays($cart->end_date))
            : 1;
            $sub = ($cart->item->price ?? 0) * $cart->quantity * $d;
            @endphp
            <div class="flex justify-between text-sm text-gray-500 mb-2">
                <span>{{ $cart->item->name ?? '-' }} ({{ $d }} hari)</span>
                <span class="font-semibold text-gray-700">Rp{{ number_format($sub, 0, ',', '.') }}</span>
            </div>
            @endforeach

            <div class="border-t border-gray-100 mt-3 pt-4 space-y-2">
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Subtotal Sewa Produk</span>
                    <span class="font-bold text-gray-700">Rp{{ number_format($totalSubtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Biaya Layanan Aplikasi</span>
                    <span class="font-bold text-gray-700">Rp2.000</span>
                </div>
            </div>

            <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200">
                <span class="text-base font-bold text-gray-900">Total Pembayaran</span>
                <span class="text-2xl font-black text-[#FF6B95]" id="total-pembayaran">
                    Rp{{ number_format($totalSubtotal  + 2000, 0, ',', '.') }}
                </span>
            </div>
        </div>

    </main>

    {{-- Fixed bottom bar --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 shadow-[0_-4px_20px_rgba(0,0,0,0.06)]">
        <div class="max-w-4xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
            <div>
                <p class="text-xs text-gray-400">Total Pembayaran</p>
                <p class="text-xl font-black text-[#FF6B95]" id="total-bottom">
                    Rp{{ number_format($totalSubtotal  + 2000, 0, ',', '.') }}
                </p>
            </div>
            <button onclick="handleCheckout()"
                class="bg-[#FF6B95] hover:bg-[#ff5282] text-white px-8 py-3 rounded-xl font-black text-sm uppercase tracking-widest transition-all active:scale-95">
                Buat Pesanan Sekarang
            </button>
        </div>
    </div>

    {{-- Modal Alamat --}}
    <div id="addressModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[70] px-4">
        <div class="bg-white w-full max-w-lg rounded-2xl overflow-hidden shadow-2xl">
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="font-bold text-lg text-gray-900">Ubah Data Pengiriman</h3>
                <button onclick="closeAddressModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Nama Lengkap</label>
                    <input type="text" id="input-name"
                        class="w-full p-3 border border-gray-200 rounded-xl outline-none focus:border-[#FF6B95] transition"
                        placeholder="Contoh: Rizkanur">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Nomor HP</label>
                    <input type="text" id="input-phone"
                        class="w-full p-3 border border-gray-200 rounded-xl outline-none focus:border-[#FF6B95] transition"
                        placeholder="Contoh: +62 812-3456-7890">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Alamat Lengkap</label>
                    <textarea id="input-address" rows="3"
                        class="w-full p-3 border border-gray-200 rounded-xl outline-none focus:border-[#FF6B95] transition"
                        placeholder="Jl. Nama Jalan, Kelurahan, Kecamatan, Kota, Provinsi"></textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button onclick="closeAddressModal()"
                        class="flex-1 py-3 border border-gray-200 rounded-xl font-bold text-gray-400 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button onclick="saveAddress()"
                        class="flex-1 py-3 bg-[#FF6B95] text-white rounded-xl font-bold hover:brightness-110 transition">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Peringatan KTP --}}
    <div id="ktpWarningModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[80] px-4">
        <div class="bg-white w-full max-w-sm rounded-2xl p-6 text-center shadow-2xl">
            <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-black text-gray-900 mb-2">Data Diri Belum Lengkap</h3>
            <p class="text-sm text-gray-500 mb-6">
                Kamu belum menambahkan nomor KTP. Lengkapi data diri dulu sebelum melanjutkan pesanan.
            </p>
            <div class="flex gap-3">
                <button onclick="document.getElementById('ktpWarningModal').classList.remove('!flex')"
                    class="flex-1 py-3 border border-gray-200 rounded-xl font-bold text-gray-400 text-sm">
                    Nanti Saja
                </button>
                <button onclick="window.location.href='/profile'"
                    class="flex-1 py-3 bg-[#FF6B95] text-white rounded-xl font-bold text-sm">
                    Lengkapi Sekarang
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentShipping = 30000;
        const serviceFee = 2000;
        const baseSubtotal = {{ $totalSubtotal }};

        function updateTotals() {
            const total = baseSubtotal + currentShipping + serviceFee;
            const fmt = n => 'Rp' + n.toLocaleString('id-ID');
            const shippingEl = document.getElementById('summary-shipping');
            if (shippingEl) shippingEl.innerText = currentShipping === 0 ? 'Gratis' : fmt(currentShipping);
            document.getElementById('total-pembayaran').innerText = fmt(total);
            document.getElementById('total-bottom').innerText = fmt(total);
        }

        function selectPayment(btn) {
            document.querySelectorAll('[onclick="selectPayment(this)"]').forEach(b => {
                b.className = 'px-6 py-2 border-2 border-gray-200 text-gray-400 rounded-xl font-bold text-sm hover:border-[#FF6B95] hover:text-[#FF6B95] transition';
            });
            btn.className = 'px-6 py-2 border-2 border-[#FF6B95] text-[#FF6B95] rounded-xl font-bold text-sm bg-pink-50';
        }

        function openAddressModal() {
            const phone = document.getElementById('display-phone').innerText;
            const address = document.getElementById('display-address').innerText;
            document.getElementById('input-name').value = document.getElementById('display-name').innerText;
            document.getElementById('input-phone').value = phone === '— Belum ada no. HP' ? '' : phone;
            document.getElementById('input-address').value = address === 'Masukkan alamat pengiriman kamu' ? '' : address;
            document.getElementById('addressModal').classList.add('!flex');
        }

        function closeAddressModal() {
            document.getElementById('addressModal').classList.remove('!flex');
        }

        function saveAddress() {
            const name = document.getElementById('input-name').value.trim();
            const phone = document.getElementById('input-phone').value.trim();
            const address = document.getElementById('input-address').value.trim();
            if (!name || !phone || !address) {
                alert('Harap isi semua data!');
                return;
            }
            document.getElementById('display-name').innerText = name;
            document.getElementById('display-phone').innerText = phone;
            document.getElementById('display-address').innerText = address;
            closeAddressModal();
        }

        const ktpSudahAda = "{{ auth()->user()->ktp_number }}";

        function handleCheckout() {
            if (!ktpSudahAda) {
                document.getElementById('ktpWarningModal').classList.add('!flex');
                return;
            }
            window.location.href = '/success';
        }
    </script>

</body>

</html>