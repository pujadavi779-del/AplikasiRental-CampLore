@extends('admin.admin')

@section('title', 'Data Pemesanan Rental')

@section('content')

<div class="fixed top-5 right-6 z-40 left-[calc(16rem+24px)] max-sm:left-6">
    @include('admin.navbar', [
    'NavParent' => 'Managemen Rental',
    'section' => 'Pemesanan'
    ])
</div>
<!-- 
<div class="min-h-screen bg-[#F8FAF6] p-6">
    <div class="bg-white rounded-2xl border border-[#d7e6de] shadow-sm overflow-hidden">

        {{-- ===== HEADER ===== --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-5 border-b border-[#eef4f0]">
            <div>
                <h2 class="text-2xl font-bold text-[#22543D] font-serif leading-tight">
                    Data Pemesanan Rental
                </h2>
                <p class="text-[11px] text-[#7c8b84] mt-0.5">
                    Pantau dan kelola semua transaksi rental kamera &amp; camping.
                </p>
            </div>
            <button type="button"
                class="inline-flex items-center gap-2 bg-[#22543D] hover:bg-[#1B4332] text-white text-xs font-bold px-5 py-2.5 rounded-xl transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Tambah Pesanan
            </button>
        </div>

        {{-- ===== SEARCH + FILTER ===== --}}
        <div class="flex flex-col sm:flex-row gap-3 px-6 py-4 border-b border-[#eef4f0]">
            <div class="relative flex-1">
                <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                    </svg>
                </div>
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari nama pelanggan atau produk..."
                    oninput="filterTable()"
                    class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D]">
            </div>
            <select
                id="statusFilter"
                onchange="filterTable()"
                class="text-sm border border-gray-200 rounded-xl px-3 py-2 bg-gray-50 text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D]">
                <option value="">Semua Status</option>
                <option value="Aktif">Aktif</option>
                <option value="Menunggu">Menunggu</option>
                <option value="Selesai">Selesai</option>
                <option value="Dibatalkan">Dibatalkan</option>
            </select>
        </div>

        {{-- ===== TABLE ===== --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">

                <thead class="bg-[#f1f8f4] text-[10px] font-bold uppercase tracking-widest text-[#22543D] border-b border-[#eef4f0]">
                    <tr>
                        <th class="px-6 py-3 w-10">
                            <input type="checkbox" id="checkAll" onclick="toggleAll(this)"
                                class="w-4 h-4 rounded border-gray-300 accent-[#22543D] cursor-pointer">
                        </th>
                        <th class="px-4 py-3 cursor-pointer select-none whitespace-nowrap" onclick="sortTable('id')">
                            Id <span id="sort-id" class="text-gray-400 text-[10px]">↕</span>
                        </th>
                        <th class="px-4 py-3 cursor-pointer select-none whitespace-nowrap" onclick="sortTable('name')">
                            User <span id="sort-name" class="text-gray-400 text-[10px]">↕</span>
                        </th>
                        <th class="px-4 py-3 whitespace-nowrap">Products</th>
                        <th class="px-4 py-3 cursor-pointer select-none whitespace-nowrap" onclick="sortTable('price')">
                            Total Price <span id="sort-price" class="text-gray-400 text-[10px]">↕</span>
                        </th>
                        <th class="px-4 py-3 whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 cursor-pointer select-none whitespace-nowrap" onclick="sortTable('date')">
                            Created <span id="sort-date" class="text-gray-400 text-[10px]">↕</span>
                        </th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tableBody" class="divide-y divide-[#eef4f0]">
                    {{-- Diisi oleh JavaScript --}}
                </tbody>
            </table>

            {{-- EMPTY STATE --}}
            <div id="emptyState" class="hidden flex-col items-center justify-center py-16 text-gray-400">
                <svg class="w-10 h-10 mb-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                </svg>
                <p class="text-sm font-medium">Tidak ada data ditemukan</p>
            </div>
        </div>

        {{-- ===== FOOTER / PAGINATION ===== --}}
        <div class="flex items-center justify-between px-6 py-4 bg-[#fcfdfb] border-t border-[#eef4f0]">
            <p id="pageInfo" class="text-[10px] font-bold text-[#22543D] uppercase tracking-widest"></p>
            <div id="pageBtns" class="flex gap-1.5"></div>
        </div>

    </div>
</div>

<script>
    
    const allData = [{
            id: '#ORD-001',
            name: 'Andi Pratama',
            email: 'andi@gmail.com',
            av: 'AP',
            products: [{
                name: 'Canon EOS R6',
                type: 'camera'
            }, {
                name: 'Tripod Carbon',
                type: 'camping'
            }],
            price: 450000,
            days: 3,
            status: 'Aktif',
            date: '2026-04-14'
        },
        {
            id: '#ORD-002',
            name: 'Siti Rahayu',
            email: 'siti@gmail.com',
            av: 'SR',
            products: [{
                name: 'Sony A7 III',
                type: 'camera'
            }],
            price: 350000,
            days: 2,
            status: 'Menunggu',
            date: '2026-04-14'
        },
        {
            id: '#ORD-003',
            name: 'Budi Santoso',
            email: 'budi@gmail.com',
            av: 'BS',
            products: [{
                name: 'Tenda Dome 4P',
                type: 'camping'
            }, {
                name: 'Sleeping Bag',
                type: 'camping'
            }],
            price: 280000,
            days: 4,
            status: 'Selesai',
            date: '2026-04-12'
        },
        {
            id: '#ORD-004',
            name: 'Rina Wulandari',
            email: 'rina@gmail.com',
            av: 'RW',
            products: [{
                name: 'GoPro Hero 12',
                type: 'camera'
            }, {
                name: 'Kompor Portable',
                type: 'camping'
            }],
            price: 520000,
            days: 3,
            status: 'Aktif',
            date: '2026-04-13'
        },
        {
            id: '#ORD-005',
            name: 'Fajar Nugroho',
            email: 'fajar@gmail.com',
            av: 'FN',
            products: [{
                name: 'DJI Mini 4 Pro',
                type: 'camera'
            }],
            price: 600000,
            days: 2,
            status: 'Menunggu',
            date: '2026-04-15'
        },
        {
            id: '#ORD-006',
            name: 'Dewi Lestari',
            email: 'dewi@gmail.com',
            av: 'DL',
            products: [{
                name: 'Carrier 60L',
                type: 'camping'
            }, {
                name: 'Matras Gunung',
                type: 'camping'
            }],
            price: 180000,
            days: 5,
            status: 'Dibatalkan',
            date: '2026-04-10'
        },
        {
            id: '#ORD-007',
            name: 'Hendra Kusuma',
            email: 'hendra@gmail.com',
            av: 'HK',
            products: [{
                name: 'Canon R5',
                type: 'camera'
            }, {
                name: 'Lensa 24-70mm',
                type: 'camera'
            }],
            price: 780000,
            days: 2,
            status: 'Selesai',
            date: '2026-04-11'
        },
        {
            id: '#ORD-008',
            name: 'Mega Safitri',
            email: 'mega@gmail.com',
            av: 'MS',
            products: [{
                name: 'Nikon Z6 II',
                type: 'camera'
            }, {
                name: 'Tenda Dome 2P',
                type: 'camping'
            }],
            price: 430000,
            days: 3,
            status: 'Aktif',
            date: '2026-04-15'
        },
    ];

    // Warna avatar (Tailwind inline classes)
    const avColors = [
        'bg-emerald-100 text-emerald-700',
        'bg-blue-100 text-blue-700',
        'bg-amber-100 text-amber-700',
        'bg-pink-100 text-pink-700',
        'bg-purple-100 text-purple-700',
    ];

    // Badge kelas per status
    const statusBadge = {
        'Aktif': 'bg-emerald-50 text-emerald-700 border border-emerald-200',
        'Menunggu': 'bg-amber-50 text-amber-700 border border-amber-200',
        'Selesai': 'bg-gray-100 text-gray-500 border border-gray-200',
        'Dibatalkan': 'bg-red-50 text-red-600 border border-red-200',
    };

    const perPage = 5;
    let currentPage = 1;
    let filtered = [...allData];
    let sortKey = '';
    let sortAsc = true;

    function fmt(n) {
        return 'Rp ' + n.toLocaleString('id-ID');
    }

    function fmtDate(d) {
        return new Date(d).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

    function renderRows() {
        const tbody = document.getElementById('tableBody');
        const empty = document.getElementById('emptyState');
        const start = (currentPage - 1) * perPage;
        const slice = filtered.slice(start, start + perPage);

        if (filtered.length === 0) {
            tbody.innerHTML = '';
            empty.classList.remove('hidden');
            empty.classList.add('flex');
            document.getElementById('pageInfo').textContent = '0 pesanan ditemukan';
            document.getElementById('pageBtns').innerHTML = '';
            return;
        }

        empty.classList.add('hidden');
        empty.classList.remove('flex');

        tbody.innerHTML = slice.map((r, i) => {
            const avClass = avColors[(start + i) % avColors.length];
            const badge = statusBadge[r.status] ?? 'bg-gray-100 text-gray-500 border border-gray-200';
            const products = r.products.map(p =>
                `<div class="flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 ${p.type === 'camera' ? 'bg-emerald-400' : 'bg-amber-400'}"></span>
                <span class="text-xs text-gray-500 whitespace-nowrap">${p.name}</span>
            </div>`
            ).join('');

            return `
        <tr class="hover:bg-[#fcfdfb] transition-colors">

            <td class="px-6 py-4">
                <input type="checkbox" class="row-cb w-4 h-4 rounded border-gray-300 accent-[#22543D] cursor-pointer">
            </td>

            <td class="px-4 py-4">
                <span class="font-mono text-[11px] text-gray-400 bg-gray-100 border border-gray-200 rounded px-2 py-0.5 whitespace-nowrap">
                    ${r.id}
                </span>
            </td>

            <td class="px-4 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-[11px] font-semibold flex-shrink-0 ${avClass}">
                        ${r.av}
                    </div>
                    <div>
                        <div class="font-semibold text-[#22543D] text-sm leading-tight whitespace-nowrap">${r.name}</div>
                        <div class="text-[11px] text-gray-400">${r.email}</div>
                    </div>
                </div>
            </td>

            <td class="px-4 py-4">
                <div class="flex flex-col gap-1">${products}</div>
            </td>

            <td class="px-4 py-4 whitespace-nowrap">
                <span class="font-mono font-semibold text-[#22543D] text-sm">${fmt(r.price)}</span>
                <span class="ml-1 text-[10px] text-gray-400 bg-gray-100 rounded px-1.5 py-0.5">${r.days}hr</span>
            </td>

            <td class="px-4 py-4">
                <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full whitespace-nowrap ${badge}">
                    ${r.status}
                </span>
            </td>

            <td class="px-4 py-4 text-xs text-gray-400 whitespace-nowrap">
                ${fmtDate(r.date)}
            </td>

            <td class="px-4 py-4">
                <div class="flex items-center justify-center gap-1.5">
                    <a href="/admin/orders/${r.id}/detail"
                        class="text-xs text-[#22543D] border border-[#d7e6de] rounded-lg px-3 py-1.5 hover:bg-[#f1f8f4] transition-colors font-medium whitespace-nowrap">
                        Detail
                    </a>
                    <button type="button" onclick="confirmDelete('${r.real_id}')"
                        class="text-xs text-red-400 border border-red-100 rounded-lg px-3 py-1.5 hover:bg-red-50 transition-colors font-medium whitespace-nowrap">
                        Hapus
                    </button>
                </div>
            </td>

        </tr>`;
        }).join('');

        const total = filtered.length;
        document.getElementById('pageInfo').textContent =
            `Menampilkan ${start + 1}–${Math.min(start + perPage, total)} dari ${total} pesanan`;

        renderPager();
    }

    function renderPager() {
        const total = Math.ceil(filtered.length / perPage);
        const el = document.getElementById('pageBtns');
        el.innerHTML = '';

        for (let i = 1; i <= total; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.type = 'button';
            btn.className = i === currentPage ?
                'w-8 h-8 flex items-center justify-center rounded-lg text-xs font-bold bg-[#22543D] text-white' :
                'w-8 h-8 flex items-center justify-center rounded-lg text-xs font-medium border border-[#d7e6de] text-[#22543D] hover:bg-[#f1f8f4] transition-colors';
            btn.onclick = () => {
                currentPage = i;
                renderRows();
            };
            el.appendChild(btn);
        }
    }

    function filterTable() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        const s = document.getElementById('statusFilter').value;

        filtered = allData.filter(r => {
            const haystack = (r.name + r.email + r.id + r.products.map(p => p.name).join(' ')).toLowerCase();
            return (!q || haystack.includes(q)) && (!s || r.status === s);
        });

        currentPage = 1;
        renderRows();
    }

    function sortTable(key) {
        if (sortKey === key) {
            sortAsc = !sortAsc;
        } else {
            sortKey = key;
            sortAsc = true;
        }

        ['id', 'name', 'price', 'date'].forEach(k => {
            const el = document.getElementById('sort-' + k);
            if (el) el.textContent = k === key ? (sortAsc ? '↑' : '↓') : '↕';
        });

        filtered.sort((a, b) => {
            let va, vb;
            if (key === 'price') {
                va = a.price;
                vb = b.price;
            } else if (key === 'date') {
                va = new Date(a.date);
                vb = new Date(b.date);
            } else {
                va = a[key];
                vb = b[key];
            }
            return va < vb ? (sortAsc ? -1 : 1) : va > vb ? (sortAsc ? 1 : -1) : 0;
        });

        renderRows();
    }

    function toggleAll(cb) {
        document.querySelectorAll('.row-cb').forEach(c => c.checked = cb.checked);
    }

    function confirmDelete(id) {
        if (confirm(`Yakin ingin menghapus pesanan ${id}?`)) {

            fetch(`/admin/orders/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Gagal hapus data');
                    }
                    return res.json();
                })
                .then(data => {
                    alert('Pesanan berhasil dihapus!');
                    location.reload();
                })
                .catch(err => {
                    alert(err.message);
                });

        }
    }

    // Init
    renderRows();
</script>

@endsection -->