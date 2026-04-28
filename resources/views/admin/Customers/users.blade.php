@extends('layouts.admin')

@section('title', 'Customer - Camplore')
@section('page-title', 'Customer')

@section('breadcrumb')
    <span class="text-gray-300">/</span>
    <span class="text-[#22543D] font-semibold">Customer</span>
@endsection

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-extrabold text-gray-800">Daftar Pelanggan</h2>
        <p class="text-gray-400 text-sm mt-0.5">Kelola semua data pelanggan yang terdaftar</p>
    </div>
    <a href="{{ route('admin.customers.create') }}"
       class="flex items-center gap-2 bg-[#22543D] text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-[#ED64A6] transition shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        + Tambah Pelanggan
    </a>
</div>

{{-- Card wrapper --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

    {{-- Search bar --}}
    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
        <div class="relative flex-1 max-w-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="searchInput" placeholder="Cari customer..."
                class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#22543D] focus:ring-1 focus:ring-[#22543D]">
        </div>
        <span class="text-xs text-gray-400 font-medium">
            Total: <span class="text-[#22543D] font-bold">{{ $customers->total() ?? count($customers) }}</span> customer
        </span>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm" id="customerTable">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider">
                    <th class="px-6 py-3 text-left w-10">No</th>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">NIK</th>
                    <th class="px-6 py-3 text-left">No HP</th>
                    <th class="px-6 py-3 text-left">Jenis Customer</th>
                    <th class="px-6 py-3 text-left">Sewa</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50" id="tableBody">
                @forelse($customers as $i => $customer)
                <tr class="hover:bg-gray-50/50 transition customer-row">
                    <td class="px-6 py-4 text-gray-400 font-medium">
                        {{ $loop->iteration + (isset($customers->currentPage) ? ($customers->currentPage() - 1) * $customers->perPage() : 0) }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full overflow-hidden bg-[#22543D]/10 flex items-center justify-center flex-shrink-0">
                                @if($customer->photo)
                                    <img src="{{ asset('storage/'.$customer->photo) }}" class="w-full h-full object-cover" alt="{{ $customer->name }}">
                                @else
                                    <span class="text-[#22543D] font-bold text-sm">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $customer->name }}</p>
                                <p class="text-xs text-gray-400">{{ $customer->address ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 font-mono text-xs">{{ $customer->nik ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $customer->phone ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold
                            {{ ($customer->customer_type ?? '') === 'Perusahaan' ? 'bg-blue-50 text-blue-700' : 'bg-emerald-50 text-emerald-700' }}">
                            {{ $customer->customer_type ?? 'Pribadi' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-700">{{ $customer->rentals_count ?? 0 }}</td>
                    <td class="px-6 py-4 text-center">
                        @if(($customer->status ?? 'aktif') === 'aktif')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> AKTIF
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> TIDAK AKTIF
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Detail --}}
                            <a href="{{ route('admin.customers.show', $customer->id) }}"
                               class="w-8 h-8 rounded-lg bg-emerald-50 hover:bg-[#22543D] text-[#22543D] hover:text-white flex items-center justify-center transition" title="Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            {{-- Edit --}}
                            <a href="{{ route('admin.customers.edit', $customer->id) }}"
                               class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-500 text-blue-500 hover:text-white flex items-center justify-center transition" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            {{-- Hapus --}}
                            <form method="POST" action="{{ route('admin.customers.destroy', $customer->id) }}"
                                  onsubmit="return confirm('Yakin hapus customer ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-500 text-red-500 hover:text-white flex items-center justify-center transition" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <p class="text-gray-400 font-semibold">Belum ada data pelanggan</p>
                            <a href="{{ route('admin.customers.create') }}" class="mt-3 text-[#22543D] text-sm font-bold hover:underline">+ Tambah sekarang</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(isset($customers) && method_exists($customers, 'hasPages') && $customers->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $customers->links() }}
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
    // Live search
    document.getElementById('searchInput').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.customer-row').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>
@endpush