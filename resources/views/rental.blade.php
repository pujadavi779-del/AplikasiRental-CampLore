<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Saya - Camplore</title>
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

        .bg-camplore-green {
            background-color: #1A392D;
        }

        .accent-camplore-pink {
            accent-color: #FF6B95;
        }
    </style>
</head>

<body class="text-gray-800 pb-32">

    @include('layouts.navbar_LP')

    <main class="max-w-6xl mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold text-[#1A392D] mb-6">Keranjang Rental</h2>

        <div class="bg-white p-4 rounded-t-xl shadow-sm flex items-center text-gray-400 text-xs font-bold uppercase tracking-wider hidden md:flex border-b border-gray-100">
            <div class="w-[5%] flex justify-center">
                <input type="checkbox" id="selectAllTop" class="w-4 h-4 accent-camplore-pink cursor-pointer">
            </div>
            <div class="w-[45%]">Item Rental</div>
            <div class="w-[15%] text-center">Harga /Hari</div>
            <div class="w-[15%] text-center">Unit</div>
            <div class="w-[15%] text-center">Subtotal</div>
            <div class="w-[5%] text-center">Aksi</div>
        </div>

        <div class="bg-white rounded-b-xl shadow-sm mb-4 overflow-hidden border border-gray-100">
            <div id="cart-items">
                <div class="p-5 flex flex-wrap md:flex-nowrap items-center border-b last:border-b-0 item-card transition hover:bg-gray-50/50" data-name="sony alpha a7 iii">
                    <div class="w-[5%] flex justify-center">
                        <input type="checkbox" checked class="item-checkbox w-4 h-4 accent-camplore-pink cursor-pointer" data-price="250000">
                    </div>
                    <div class="w-full md:w-[45%] flex gap-4 mt-2 md:mt-0">
                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=200" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col justify-center">
                            <h3 class="text-sm font-bold text-[#1A392D]">Sony Alpha A7 III</h3>
                            <p class="text-[11px] text-pink-400 font-semibold uppercase tracking-tighter mt-1">Kategori: Kamera</p>
                        </div>
                    </div>
                    <div class="w-1/3 md:w-[15%] text-center text-sm font-semibold mt-4 md:mt-0 text-gray-600">Rp250.000</div>
                    <div class="w-1/3 md:w-[15%] flex justify-center mt-4 md:mt-0">
                        <div class="flex items-center border border-gray-200 rounded-lg h-8 bg-white overflow-hidden">
                            <button onclick="changeQty(this, -1)" class="px-3 hover:bg-gray-100 text-[#1A392D] font-bold">-</button>
                            <span class="qty-val px-3 text-sm font-bold text-gray-700">1</span>
                            <button onclick="changeQty(this, 1)" class="px-3 hover:bg-gray-100 text-[#1A392D] font-bold">+</button>
                        </div>
                    </div>
                    <div class="w-1/3 md:w-[15%] text-center text-sm text-camplore-pink font-bold mt-4 md:mt-0">
                        Rp<span class="row-total">250.000</span>
                    </div>
                    <div class="w-full md:w-[5%] text-right md:text-center mt-2 md:mt-0">
                        <button onclick="removeItem(this)" class="p-2 text-gray-300 hover:text-red-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-5 flex flex-wrap md:flex-nowrap items-center border-b last:border-b-0 item-card transition hover:bg-gray-50/50" data-name="tenda arpenaz 4.1">
                    <div class="w-[5%] flex justify-center">
                        <input type="checkbox" checked class="item-checkbox w-4 h-4 accent-camplore-pink cursor-pointer" data-price="150000">
                    </div>
                    <div class="w-full md:w-[45%] flex gap-4 mt-2 md:mt-0">
                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=200" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col justify-center">
                            <h3 class="text-sm font-bold text-[#1A392D]">Tenda Arpenaz 4.1</h3>
                            <p class="text-[11px] text-pink-400 font-semibold uppercase tracking-tighter mt-1">Kategori: Camping</p>
                        </div>
                    </div>
                    <div class="w-1/3 md:w-[15%] text-center text-sm font-semibold mt-4 md:mt-0 text-gray-600">Rp150.000</div>
                    <div class="w-1/3 md:w-[15%] flex justify-center mt-4 md:mt-0">
                        <div class="flex items-center border border-gray-200 rounded-lg h-8 bg-white overflow-hidden">
                            <button onclick="changeQty(this, -1)" class="px-3 hover:bg-gray-100 text-[#1A392D] font-bold">-</button>
                            <span class="qty-val px-3 text-sm font-bold text-gray-700">1</span>
                            <button onclick="changeQty(this, 1)" class="px-3 hover:bg-gray-100 text-[#1A392D] font-bold">+</button>
                        </div>
                    </div>
                    <div class="w-1/3 md:w-[15%] text-center text-sm text-camplore-pink font-bold mt-4 md:mt-0">
                        Rp<span class="row-total">150.000</span>
                    </div>
                    <div class="w-full md:w-[5%] text-right md:text-center mt-2 md:mt-0">
                        <button onclick="removeItem(this)" class="p-2 text-gray-300 hover:text-red-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-[0_-5px_20px_rgba(0,0,0,0.05)] z-40">
            <div class="max-w-6xl mx-auto p-4 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-6 w-full md:w-auto">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" id="selectAllBottom" class="w-5 h-5 accent-camplore-pink cursor-pointer">
                        <span class="text-sm font-bold text-gray-600 group-hover:text-camplore-pink transition">
                            Pilih Semua (<span id="total-checked-count">0</span>)
                        </span>
                    </label>
                    <button onclick="removeAllChecked()" class="text-sm font-bold text-gray-400 hover:text-red-500 transition uppercase underline">Hapus</button>
                </div>

                <div class="flex items-center justify-between md:justify-end gap-8 w-full md:w-auto">
                    <div class="text-right">
                        <div class="text-sm text-gray-500 font-semibold">Total Sewa (<span id="count-items">0</span> Item)</div>
                        <div class="text-camplore-pink font-black text-2xl md:text-3xl" id="totalPrice">Rp0</div>
                    </div>
                    <button onclick="goToCheckout()" class="bg-[#FF6B95] text-white px-10 md:px-16 py-4 rounded-2xl font-bold hover:bg-[#e05a82] transition-all shadow-lg active:scale-95 uppercase tracking-widest text-xs">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        function updateSummary() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const allCards = document.querySelectorAll('.item-card');
            let totalHarga = 0;
            let checkedCount = 0;

            checkboxes.forEach(cb => {
                const card = cb.closest('.item-card');
                const qty = parseInt(card.querySelector('.qty-val').innerText);
                const price = parseInt(cb.getAttribute('data-price'));
                const rowTotalValue = qty * price;

                // Update teks subtotal per baris
                card.querySelector('.row-total').innerText = rowTotalValue.toLocaleString('id-ID');

                if (cb.checked) {
                    totalHarga += rowTotalValue;
                    checkedCount++;
                }
            });

            // Update Bottom Bar
            document.getElementById('totalPrice').innerText = `Rp${totalHarga.toLocaleString('id-ID')}`;
            document.getElementById('count-items').innerText = checkedCount;
            document.getElementById('total-checked-count').innerText = checkedCount;

            // Update Badge Navbar (Sesuai ID di navbar.blade.php kamu)
            const navBadge = document.getElementById('nav-cart-count') || document.getElementById('cart-badge');
            if (navBadge) {
                navBadge.innerText = allCards.length;
                navBadge.style.display = allCards.length > 0 ? 'block' : 'none';
            }

            // Sync Checkbox Master
            const selectAllTop = document.getElementById('selectAllTop');
            const selectAllBottom = document.getElementById('selectAllBottom');
            const allChecked = Array.from(checkboxes).every(c => c.checked) && checkboxes.length > 0;

            if (selectAllTop) selectAllTop.checked = allChecked;
            if (selectAllBottom) selectAllBottom.checked = allChecked;
        }

        function changeQty(btn, delta) {
            const span = btn.parentElement.querySelector('.qty-val');
            let val = parseInt(span.innerText) + delta;
            if (val < 1) val = 1;
            span.innerText = val;
            updateSummary();
        }

        function removeItem(btn) {
            if (confirm('Hapus item ini?')) {
                btn.closest('.item-card').remove();
                updateSummary();
                checkEmptyCart();
            }
        }

        function removeAllChecked() {
            const checked = document.querySelectorAll('.item-checkbox:checked');
            if (checked.length === 0) return;
            if (confirm(`Hapus ${checked.length} item?`)) {
                checked.forEach(cb => cb.closest('.item-card').remove());
                updateSummary();
                checkEmptyCart();
            }
        }

        function checkEmptyCart() {
            const container = document.getElementById('cart-items');
            if (container.querySelectorAll('.item-card').length === 0) {
                container.innerHTML = `<div class="p-20 text-center text-gray-400 italic">Keranjang kosong.</div>`;
            }
        }

        function goToCheckout() {
            const selectedItems = [];
            document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
                const card = cb.closest('.item-card');
                selectedItems.push({
                    name: card.getAttribute('data-name'),
                    qty: card.querySelector('.qty-val').innerText
                });
            });

            if (selectedItems.length === 0) {
                alert("Pilih barang dulu!");
                return;
            }
            const dataString = encodeURIComponent(JSON.stringify(selectedItems));
            window.location.href = `/checkout?items=${dataString}`;
        }

        // Event Listeners
        document.addEventListener('change', (e) => {
            if (e.target.id === 'selectAllTop' || e.target.id === 'selectAllBottom') {
                const state = e.target.checked;
                document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = state);
            }
            updateSummary();
        });

        // Inisialisasi saat halaman dibuka
        window.onload = updateSummary;
    </script>
</body>

</html>