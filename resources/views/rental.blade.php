<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Saya - Camplore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .tab-active {
            border-bottom: 2px solid #FF6B95;
            color: #FF6B95;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 overflow-x-hidden">

    @include('navbar')

    <main class="max-w-7xl mx-auto px-4 py-12">
        <div class="flex border-b border-gray-200 mb-8 text-sm font-bold uppercase tracking-widest text-gray-400">
            <div class="px-6 py-4 cursor-pointer">Pop Upon Delivery(0)</div>
            <div class="px-6 py-4 cursor-pointer tab-active">Local Express(2)</div>
            <div class="px-6 py-4 cursor-pointer">Store Pickup(0)</div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="flex-grow">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                    <input type="checkbox" id="selectAll" checked class="w-5 h-5 accent-[#FF6B95] cursor-pointer">
                    <label for="selectAll" class="text-sm font-bold text-gray-600 cursor-pointer">Select All</label>
                </div>

                <div class="space-y-6">
                    <!-- Barang 1: Kamera -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-pink-50 flex gap-6 items-center item-card" data-id="1">
                        <input type="checkbox" checked class="item-checkbox w-5 h-5 accent-[#FF6B95] cursor-pointer" data-price="250000">
                        <div class="w-32 h-32 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-lg font-bold text-[#1A392D]">Sony Alpha A7 III</h3>
                            <p class="text-sm text-gray-500 mb-4">Single Body Unit</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-[#FF6B95]">Rp 250.000 <span class="text-xs text-gray-400">/hari</span></span>
                                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                    <button onclick="changeQty(this, -1)" class="px-3 py-1 hover:bg-gray-100 transition text-[#1A392D] font-bold">-</button>
                                    <span class="qty-val px-4 font-bold text-sm">1</span>
                                    <button onclick="changeQty(this, 1)" class="px-3 py-1 hover:bg-gray-100 transition text-[#1A392D] font-bold">+</button>
                                </div>
                            </div>
                        </div>
                        <!-- Tambahkan onclick="removeItem(this)" -->
                        <button onclick="removeItem(this)" class="text-gray-300 hover:text-red-500 transition self-start">
                            <p class="text-[10px] font-bold underline uppercase tracking-tighter">Remove</p>
                        </button>
                    </div>

                    <!-- Barang 2: Tenda -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-pink-50 flex gap-6 items-center item-card" data-id="2">
                        <input type="checkbox" checked class="item-checkbox w-5 h-5 accent-[#FF6B95] cursor-pointer" data-price="150000">
                        <div class="w-32 h-32 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-lg font-bold text-[#1A392D]">Tenda Arpenaz 4.1</h3>
                            <p class="text-sm text-gray-500 mb-4">Kapasitas 4 Orang</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-[#FF6B95]">Rp 150.000 <span class="text-xs text-gray-400">/hari</span></span>
                                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                    <button onclick="changeQty(this, -1)" class="px-3 py-1 hover:bg-gray-100 transition text-[#1A392D] font-bold">-</button>
                                    <span class="qty-val px-4 font-bold text-sm">1</span>
                                    <button onclick="changeQty(this, 1)" class="px-3 py-1 hover:bg-gray-100 transition text-[#1A392D] font-bold">+</button>
                                </div>
                            </div>
                        </div>
                        <!-- Tambahkan onclick="removeItem(this)" -->
                        <button onclick="removeItem(this)" class="text-gray-300 hover:text-red-500 transition self-start">
                            <p class="text-[10px] font-bold underline uppercase tracking-tighter">Remove</p>
                        </button>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-96">
                <div class="bg-[#1A392D] text-white p-8 rounded-3xl shadow-xl sticky top-24">
                    <h2 class="text-xl font-extrabold mb-6 border-b border-white/10 pb-4">Ringkasan <span class="text-[#FF6B95]">Sewa</span></h2>

                    <div class="space-y-4 mb-8 text-sm">
                        <div class="flex justify-between opacity-80">
                            <span>Subtotal Sewa</span>
                            <span id="subtotal">Rp 400.000</span>
                        </div>
                        <div class="flex justify-between opacity-80">
                            <span>Biaya Layanan</span>
                            <span id="serviceFeeDisplay">Rp 10.000</span>
                        </div>
                        <div class="pt-6 border-t border-white/10 mt-4">
                            <div class="flex justify-between items-center text-lg font-black">
                                <span>Total Harga</span>
                                <span id="totalPrice" class="text-[#FF6B95] text-2xl">Rp 410.000</span>
                            </div>
                        </div>
                    </div>

                    <button class="w-full bg-[#FF6B95] text-white py-4 rounded-2xl font-bold hover:brightness-110 transition-all transform active:scale-95 shadow-lg shadow-pink-900/20 uppercase tracking-widest text-xs">
                        Lanjut ke Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Fungsi Hapus Barang
        function removeItem(btn) {
            const card = btn.closest('.item-card');
            card.remove();
            updateSummary();
        }

        // Fungsi Tambah & Kurang Quantity
        function changeQty(btn, delta) {
            const qtyContainer = btn.parentElement;
            const qtySpan = qtyContainer.querySelector('.qty-val');
            let currentQty = parseInt(qtySpan.innerText);

            // Minimal 1 hari sewa
            currentQty += delta;
            if (currentQty < 1) currentQty = 1;

            qtySpan.innerText = currentQty;
            updateSummary();
        }

        // Fungsi Hitung Total
        function updateSummary() {
            // Kita ambil ulang checkbox di sini agar item yang sudah dihapus tidak terhitung
            const currentCheckboxes = document.querySelectorAll('.item-checkbox');
            let subtotal = 0;
            let anyChecked = false;

            currentCheckboxes.forEach(cb => {
                if (cb.checked) {
                    const card = cb.closest('.item-card');
                    const qty = parseInt(card.querySelector('.qty-val').innerText);
                    const price = parseInt(cb.getAttribute('data-price'));

                    subtotal += (price * qty);
                    anyChecked = true;
                }
            });

            const currentServiceFee = anyChecked ? serviceFee : 0;
            const total = subtotal + currentServiceFee;

            subtotalEl.innerText = `Rp ${subtotal.toLocaleString('id-ID')}`;
            serviceFeeDisplay.innerText = `Rp ${currentServiceFee.toLocaleString('id-ID')}`;
            totalPriceEl.innerText = `Rp ${total.toLocaleString('id-ID')}`;
        }

        const selectAll = document.getElementById('selectAll');
        const subtotalEl = document.getElementById('subtotal');
        const totalPriceEl = document.getElementById('totalPrice');
        const serviceFeeDisplay = document.getElementById('serviceFeeDisplay');
        const serviceFee = 10000;

        // Event Listener Checkbox
        selectAll.addEventListener('change', () => {
            const currentCheckboxes = document.querySelectorAll('.item-checkbox');
            currentCheckboxes.forEach(cb => cb.checked = selectAll.checked);
            updateSummary();
        });

        // Gunakan Event Delegation untuk menangani checkbox karena item bisa dihapus
        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('item-checkbox')) {
                const currentCheckboxes = document.querySelectorAll('.item-checkbox');
                const allChecked = Array.from(currentCheckboxes).every(c => c.checked);
                selectAll.checked = allChecked;
                updateSummary();
            }
        });
    </script>
</body>

</html>