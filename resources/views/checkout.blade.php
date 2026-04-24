<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Camplore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        .text-camplore-pink {
            color: #FF6B95;
        }

        .bg-camplore-pink {
            background-color: #FF6B95;
        }

        .border-camplore-pink {
            border-color: #FF6B95;
        }

        .bg-camplore-green {
            background-color: #1A392D;
        }

        .modal-active {
            display: flex !important;
        }
    </style>
</head>

<body class="text-gray-800 pb-20">

    @include('layouts.navbar_LP')

    <main class="max-w-5xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-black text-[#1A392D] mb-8 flex items-center gap-2">
            <span class="bg-camplore-pink w-2 h-8 rounded-full"></span>
            Checkout Pesanan
        </h1>

        <div class="bg-white rounded-2xl shadow-sm border-t-4 border-camplore-pink p-6 mb-6">
            <div class="flex items-center gap-2 text-camplore-pink mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
                <h2 class="font-bold uppercase tracking-wider text-sm">Alamat Pengiriman</h2>
            </div>
            <div class="flex justify-between items-start">
                <div id="display-address-container">
                    <p id="display-name-phone" class="font-bold text-[#1A392D]">Rizkanur_20 (+62) 812-3456-7890</p>
                    <p id="display-address-detail" class="text-sm text-gray-500 mt-1">Jl. Sungai Langkai No. 19, Sagulung, Kota Batam, Kepulauan Riau, ID 29439</p>
                </div>
                <button onclick="openAddressModal()" class="text-xs font-bold text-blue-500 hover:underline transition">Ubah</button>
            </div>
        </div>

        <div id="addressModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[70] px-4">
            <div class="bg-white w-full max-w-lg rounded-2xl overflow-hidden shadow-2xl animate-in fade-in zoom-in duration-200">
                <div class="p-6 border-b flex justify-between items-center">
                    <h3 class="font-bold text-lg text-[#1A392D]">Ubah Alamat Pengiriman</h3>
                    <button onclick="closeAddressModal()" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Nama Lengkap & Nomor HP</label>
                        <input type="text" id="input-name-phone" class="w-full p-3 border border-gray-200 rounded-xl outline-none focus:border-camplore-pink transition" placeholder="Contoh: Rizkanur (+62) 812...">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Alamat Lengkap</label>
                        <textarea id="input-address-detail" rows="3" class="w-full p-3 border border-gray-200 rounded-xl outline-none focus:border-camplore-pink transition" placeholder="Masukkan alamat lengkap pengiriman..."></textarea>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button onclick="closeAddressModal()" class="flex-1 py-3 border border-gray-200 rounded-xl font-bold text-gray-400 hover:bg-gray-50 transition">Batal</button>
                        <button onclick="saveAddress()" class="flex-1 py-3 bg-camplore-pink text-white rounded-xl font-bold hover:brightness-110 transition shadow-lg shadow-pink-100">Simpan Alamat</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-50 flex items-center bg-gray-50/50">
                <div class="w-full md:w-1/2 flex items-center gap-4">
                    <h2 class="font-bold text-[#1A392D]">Produk Dipesan</h2>
                    <a id="wa-link" href="#" target="_blank" class="flex items-center gap-1 text-xs font-bold text-green-600 hover:text-green-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.237 3.483 8.42-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.308 1.654zm6.757-4.791c1.512.897 3.035 1.347 4.516 1.348 5.409 0 9.809-4.397 9.811-9.808 0-2.618-1.02-5.08-2.87-6.932-1.85-1.851-4.311-2.872-6.93-2.873-5.41 0-9.811 4.401-9.813 9.813 0 1.748.458 3.45 1.321 4.949l-.997 3.641 3.763-.988z" />
                        </svg>
                        Chat Sekarang
                    </a>
                </div>
                <div class="hidden md:flex w-1/2 items-center text-[11px] font-extrabold text-gray-400 uppercase tracking-widest">
                    <span class="w-1/3 text-center">Harga Satuan</span>
                    <span class="w-1/3 text-center">Jumlah</span>
                    <span class="w-1/3 text-right">Subtotal Produk</span>
                </div>
            </div>

            <div id="checkout-items-container"></div>

            <div class="p-6 bg-gray-50/50 flex flex-col md:flex-row justify-between gap-6 border-t border-gray-100">
                <div class="md:w-1/3">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-2">Pesan Untuk Admin:</label>
                    <input type="text" placeholder="(Opsional) Contoh: Baterai cadangan ya.." class="w-full text-sm p-3 border border-gray-200 rounded-xl outline-none focus:border-camplore-pink focus:ring-1 focus:ring-camplore-pink/20 transition">
                </div>

                <div onclick="openShippingModal()" class="md:w-1/2 bg-white p-4 rounded-xl border border-gray-100 flex justify-between items-center shadow-sm cursor-pointer hover:border-camplore-pink transition group">
                    <div>
                        <span class="text-[10px] font-bold text-camplore-green uppercase tracking-tighter">Opsi Pengiriman:</span>
                        <p id="selected-shipping-name" class="text-sm font-bold text-green-600 mt-1 uppercase">Kirim oleh Kurir</p>
                        <p id="selected-shipping-desc" class="text-[10px] text-gray-400 italic">Estimasi diterima: 14 - 15 Apr</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span id="selected-shipping-price" class="text-sm font-black text-[#1A392D]">Rp30.000</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300 group-hover:text-camplore-pink transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6 border border-gray-50">
            <h2 class="font-bold text-[#1A392D] mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-camplore-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                Metode Pembayaran
            </h2>
            <div class="flex flex-wrap gap-3">
                <button class="px-6 py-2 border-2 border-camplore-pink text-camplore-pink rounded-xl font-bold text-sm bg-pink-50 transition shadow-sm">Transfer Bank</button>
                <button class="px-6 py-2 border-2 border-gray-100 text-gray-400 rounded-xl font-bold text-sm hover:border-camplore-pink hover:text-camplore-pink transition">QRIS</button>
                <button class="px-6 py-2 border-2 border-gray-100 text-gray-400 rounded-xl font-bold text-sm hover:border-camplore-pink hover:text-camplore-pink transition">Gopay</button>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-50">
            <div class="flex flex-col items-end gap-3 text-sm">
                <div class="flex justify-between w-full md:w-80">
                    <span class="text-gray-500">Subtotal Sewa Produk</span>
                    <span class="font-bold text-gray-700" id="subtotal-produk">Rp0</span>
                </div>
                <div class="flex justify-between w-full md:w-80">
                    <span class="text-gray-500">Biaya Pengiriman</span>
                    <span class="font-bold text-gray-700" id="summary-shipping">Rp30.000</span>
                </div>
                <div class="flex justify-between w-full md:w-80">
                    <span class="text-gray-500">Biaya Layanan Aplikasi</span>
                    <span class="font-bold text-gray-700">Rp2.000</span>
                </div>
                <div class="flex justify-between w-full md:w-80 mt-4 pt-4 border-t border-gray-100 items-center">
                    <span class="text-lg font-bold text-[#1A392D]">Total Pembayaran</span>
                    <span class="text-3xl font-black text-camplore-pink tracking-tighter" id="total-pembayaran">Rp0</span>
                </div>
                <button onclick="window.location.href='/success'" class="w-full md:w-80 bg-camplore-pink text-white py-4 rounded-2xl font-black uppercase tracking-widest mt-6 hover:brightness-110 active:scale-95 transition-all shadow-xl shadow-pink-200/50">
                    Buat Pesanan Sekarang
                </button>
            </div>
        </div>
    </main>

    <div id="shippingModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[60] px-4">
        <div class="bg-white w-full max-w-md rounded-2xl overflow-hidden shadow-2xl animate-in fade-in zoom-in duration-200">
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="font-bold text-lg text-[#1A392D]">Pilih Opsi Pengiriman</h3>
                <button onclick="closeShippingModal()" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-4 space-y-3">
                <div onclick="selectShipping('Ambil di Toko', 'Gratis', 0, 'Ambil langsung di gerai Camplore terdekat')"
                    class="p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:border-camplore-pink hover:bg-pink-50 transition-all flex justify-between items-center group">
                    <div>
                        <p class="font-bold text-sm text-[#1A392D] group-hover:text-camplore-pink transition">Ambil di Toko</p>
                        <p class="text-xs text-gray-500">Gratis biaya pengiriman</p>
                    </div>
                    <span class="text-sm font-bold text-green-600">Gratis</span>
                </div>

                <div onclick="selectShipping('Kirim oleh Kurir', 'Rp30.000', 30000, 'Estimasi diterima: 14 - 15 Apr')"
                    class="p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:border-camplore-pink hover:bg-pink-50 transition-all flex justify-between items-center group">
                    <div>
                        <p class="font-bold text-sm text-[#1A392D] group-hover:text-camplore-pink transition">Kirim oleh Kurir</p>
                        <p class="text-xs text-gray-500">Reguler (Kurir Lokal)</p>
                    </div>
                    <span class="text-sm font-bold text-gray-400 group-hover:text-camplore-pink transition">Rp30.000</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentSubtotal = 0;
        let currentShipping = 30000;
        const serviceFee = 2000;

        function updateTotals() {
            document.getElementById('subtotal-produk').innerText = `Rp${currentSubtotal.toLocaleString('id-ID')}`;
            document.getElementById('summary-shipping').innerText = currentShipping === 0 ? 'Gratis' : `Rp${currentShipping.toLocaleString('id-ID')}`;
            document.getElementById('total-pembayaran').innerText = `Rp${(currentSubtotal + currentShipping + serviceFee).toLocaleString('id-ID')}`;
        }

        // Modal Logic
        function openShippingModal() {
            document.getElementById('shippingModal').classList.add('modal-active');
        }

        function closeShippingModal() {
            document.getElementById('shippingModal').classList.remove('modal-active');
        }

        function selectShipping(name, priceLabel, priceValue, desc) {
            currentShipping = priceValue;
            document.getElementById('selected-shipping-name').innerText = name;
            document.getElementById('selected-shipping-price').innerText = priceLabel;
            document.getElementById('selected-shipping-desc').innerText = desc;
            updateTotals();
            closeShippingModal();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const itemsData = urlParams.get('items');

            if (itemsData) {
                try {
                    const items = JSON.parse(decodeURIComponent(itemsData));
                    const container = document.getElementById('checkout-items-container');

                    items.forEach(item => {
                        let harga = item.name.toLowerCase().includes('sony') ? 250000 : 150000;
                        let img = item.name.toLowerCase().includes('sony') ?
                            'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=200' :
                            'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=200';

                        let totalRow = harga * parseInt(item.qty);
                        currentSubtotal += totalRow;

                        container.insertAdjacentHTML('beforeend', `
                            <div class="p-6 flex flex-col md:flex-row md:items-center border-b border-gray-50 hover:bg-gray-50/30 transition">
                                <div class="flex gap-4 w-full md:w-1/2">
                                    <img src="${img}" class="w-16 h-16 object-cover rounded-xl border border-gray-100 shadow-sm">
                                    <div class="flex flex-col justify-center">
                                        <h3 class="text-sm font-bold text-[#1A392D] leading-tight">${item.name.toUpperCase()}</h3>
                                        <p class="text-xs text-gray-400 mt-1 italic uppercase">Kategori: Rental</p>
                                    </div>
                                </div>
                                <div class="flex justify-between w-full md:w-1/2 items-center mt-4 md:mt-0">
                                    <div class="w-1/3 text-center text-sm font-semibold text-gray-600">Rp${harga.toLocaleString('id-ID')}</div>
                                    <div class="w-1/3 text-center text-sm font-semibold text-gray-600">${item.qty}</div>
                                    <div class="w-1/3 text-right pr-4 text-sm font-bold text-camplore-pink">Rp${totalRow.toLocaleString('id-ID')}</div>
                                </div>
                            </div>
                        `);
                    });

                    updateTotals();

                    const waLink = document.getElementById('wa-link');
                    const textWA = encodeURIComponent(`Halo Admin Camplore, saya tanya pesanan: ${items.map(i => i.name).join(', ')}`);
                    waLink.href = `https://wa.me/6281276903211?text=${textWA}`;

                } catch (e) {
                    console.error(e);
                }
            }
        });

        // Modal Alamat Logic
        function openAddressModal() {
            // Ambil data lama dan masukkan ke input
            const currentName = document.getElementById('display-name-phone').innerText;
            const currentAddress = document.getElementById('display-address-detail').innerText;

            document.getElementById('input-name-phone').value = currentName;
            document.getElementById('input-address-detail').value = currentAddress;

            document.getElementById('addressModal').classList.add('modal-active');
        }

        function closeAddressModal() {
            document.getElementById('addressModal').classList.remove('modal-active');
        }

        function saveAddress() {
            const newName = document.getElementById('input-name-phone').value;
            const newAddress = document.getElementById('input-address-detail').value;

            if (newName.trim() === "" || newAddress.trim() === "") {
                alert("Harap isi semua data alamat!");
                return;
            }

            // Update tampilan di halaman utama
            document.getElementById('display-name-phone').innerText = newName;
            document.getElementById('display-address-detail').innerText = newAddress;

            // Tutup modal
            closeAddressModal();
        }
    </script>
</body>

</html>