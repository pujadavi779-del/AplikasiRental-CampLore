@extends('admin.admin')

@section('title', 'Pengguna - Camplore Admin')

@section('content')

{{-- Navbar --}}
<div class="fixed top-5 right-6 z-40 left-[calc(272px+24px)] max-sm:left-6 animate-fade-up">
    @include('admin.navbar', [
    'NavParent' => 'Manajemen Operasional',
    'section' => 'Pengguna'
    ])
</div>

<div class="max-w-full">
    <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

        {{-- HEADER --}}
        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0]">
            <div>
                <h2 class="text-2xl font-bold text-[#22543D] font-serif leading-tight">
                    Data Pengguna
                </h2>
                <p class="text-[11px] text-[#7c8b84] mt-0.5">
                    Kelola semua data customer yang terdaftar
                </p>
            </div>

            <a href="{{ route('admin.customers.create') }}"
               class="inline-flex items-center gap-2 bg-[#22543D] hover:bg-[#1B4332] text-white text-xs font-bold px-5 py-2.5 rounded-xl transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Tambah Customer
            </a>
        </div>

        {{-- SEARCH --}}
        <div class="flex flex-col sm:flex-row gap-3 px-6 py-4 border-b border-[#eef4f0]">
            <div class="relative flex-1 max-w-xs">
                <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                    </svg>
                </div>
                <input type="text" id="searchInput" placeholder="Cari customer..."
                    class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D]">
            </div>

            <span class="text-[11px] font-bold text-[#22543D] uppercase tracking-widest flex items-center">
                Total: {{ $customers->total() ?? count($customers) }}
            </span>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#f1f8f4] text-[10px] font-bold uppercase tracking-widest text-[#22543D] border-b border-[#eef4f0]">
                    <tr>
                        <th class="px-6 py-3 w-10">No</th>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">NIK</th>
                        <th class="px-6 py-3">No HP</th>
                        <th class="px-6 py-3">Jenis</th>
                        <th class="px-6 py-3">Sewa</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#eef4f0]" id="tableBody">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-[#fcfdfb] transition-colors customer-row">
                        <td class="px-6 py-4 text-gray-400 font-medium">
                            {{ $loop->iteration + (isset($customers->currentPage) ? ($customers->currentPage() - 1) * $customers->perPage() : 0) }}
                        </td>

                        {{-- ISI TETAP --}}
                        {{-- (lanjutan kamu ga usah diubah lagi, sudah benar) --}}

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center text-gray-400">
                            Belum ada data customer
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if(isset($customers) && method_exists($customers, 'hasPages') && $customers->hasPages())
        <div class="px-6 py-4 bg-[#fcfdfb] border-t border-[#eef4f0]">
            {{ $customers->links() }}
        </div>
        @endif

    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('searchInput').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.customer-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endpush
