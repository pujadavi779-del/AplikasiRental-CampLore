@extends('layouts.admin')

@section('title', 'Pengguna - Camplore Admin')

@php
    $NavParent = 'Manajemen Operasional';
    $section = 'Pengguna';
@endphp
@section('content')



<div class="max-w-full">
    <div class="bg-white rounded-[28px] border border-[#d7e6de] shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#eef4f0]">
            <div>
                <h2 class="text-2xl font-bold text-[#22543D] leading-tight" style="font-family:'Playfair Display',Georgia,serif;">Daftar Antrean Verifikasi</h2>
                <p class="text-[11px] text-[#7c8b84] mt-0.5">Verifikasi KTP pengguna yang telah mendaftar</p>
            </div>
            <div class="flex gap-2">
                <button class="flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export
                </button>
            </div>
        </div>

        {{-- Search --}}
        <div class="flex flex-col sm:flex-row gap-3 px-6 py-4 border-b border-[#eef4f0]">
            <div class="relative flex-1 max-w-xs">
                <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                    </svg>
                </div>
                <input type="text" id="searchInput" placeholder="Cari Pelanggan..."
                    class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#22543D]/20 focus:border-[#22543D]">
            </div>
            <span class="text-[11px] font-bold text-[#22543D] uppercase tracking-widest flex items-center">
                Total: {{ $customers->count() }}
            </span>
        </div>

        {{-- Notif --}}
        @if(session('success'))
        <div class="mx-6 mt-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-semibold">
            ✓ {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mx-6 mt-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-semibold">
            {{ session('error') }}
        </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#f1f8f4] text-[10px] font-bold uppercase tracking-widest text-[#22543D] border-b border-[#eef4f0]">
                    <tr>
                        <th class="px-6 py-3 w-16">NO</th>
                        <th class="px-6 py-3">NAMA</th>
                        <th class="px-6 py-3">NIK</th>
                        <th class="px-6 py-3 text-center">FOTO KTP</th>
                        <th class="px-6 py-3 text-center">STATUS VERIFIKASI</th>
                        <th class="px-6 py-3 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#eef4f0]" id="tableBody">
                    @forelse($customers as $customer)
                    @php $status = $customer->ktp_status ?? 'pending'; @endphp
                    <tr class="hover:bg-[#fcfdfb] transition-colors customer-row">

                        {{-- No --}}
                        <td class="px-6 py-4 text-gray-400 font-medium">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Nama --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $customer->name }}</p>
                                    <p class="text-[11px] text-gray-400">{{ $customer->email }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- NIK --}}
                        <td class="px-6 py-4 text-gray-500 font-mono text-xs">
                            {{ $customer->nik ?? '-' }}
                        </td>

                        {{-- Foto KTP --}}
                        <td class="px-6 py-4 text-center">
                            @if($customer->foto_ktp)
                            <button type="button"
                                onclick="bukaKTP('{{ addslashes($customer->name) }}', '{{ asset('storage/'.$customer->foto_ktp) }}')"
                                class="inline-block">
                                <img src="{{ asset('storage/'.$customer->foto_ktp) }}"
                                    alt="KTP {{ $customer->name }}"
                                    class="h-12 w-20 object-cover rounded-lg border border-gray-200 hover:opacity-80 transition shadow-sm">
                            </button>
                            @else
                            <span class="text-[11px] text-gray-400 italic">Belum ada</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 text-center">
                            @if($status === 'verified')
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-[#22543D] text-white text-[10px] font-bold uppercase">
                                Terverifikasi
                            </span>
                            @elseif($status === 'rejected')
                            <div class="flex flex-col items-center gap-1">
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-red-100 text-red-600 text-[10px] font-bold uppercase border border-red-200">
                                    Ditolak
                                </span>
                                @if($customer->ktp_note)
                                <span class="text-[9px] text-red-400 font-medium max-w-[150px] text-center leading-relaxed">
                                    "{{ $customer->ktp_note }}"
                                </span>
                                @endif
                            </div>
                            @else
                            <div class="flex flex-col items-center gap-1">
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-yellow-100 text-yellow-700 text-[10px] font-bold uppercase border border-yellow-200">
                                    Pending
                                </span>
                                @if($customer->ktp_updated_at)
                                <span class="text-[9px] text-blue-500 font-bold flex items-center gap-1">
                                    🔄 KTP diperbarui {{ \Carbon\Carbon::parse($customer->ktp_updated_at)->diffForHumans() }}
                                </span>
                                @endif
                            </div>
                            @endif
                        </td>

                        {{-- Aksi — selalu link ke halaman detail --}}
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.customers.show', $customer->id) }}"
                                class="inline-block px-4 py-2 rounded-xl text-xs font-bold text-white transition
                                    {{ $status === 'verified' ? 'bg-gray-400 hover:bg-gray-500' : 'bg-[#22543D] hover:bg-[#1a3d2e]' }}">
                                Detail
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400">Belum ada data pengguna</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(isset($customers) && method_exists($customers, 'hasPages') && $customers->hasPages())
        <div class="px-6 py-4 bg-[#fcfdfb] border-t border-[#eef4f0] flex items-center justify-between text-xs text-gray-500">
            <span>Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} entries</span>
            {{ $customers->links() }}
        </div>
        @endif

    </div>
</div>

{{-- ═══════════════ MODAL KTP (Preview thumbnail) ═══════════════ --}}
<div id="modalKTP" style="display:none; position:fixed; inset:0; z-index:999999; background:rgba(0,0,0,0.7); overflow-y:auto;" onclick="if(event.target===this)tutupKTP()">
    <div style="position:relative; margin:40px auto; background:white; border-radius:20px; width:90%; max-width:540px; overflow:hidden; box-shadow:0 25px 60px rgba(0,0,0,0.35); font-family:'Inter',sans-serif;">
        <div style="display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid #eef4f0;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; border-radius:10px; background:#22543D; display:flex; align-items:center; justify-content:center;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5">
                        <rect x="2" y="5" width="20" height="14" rx="3" />
                        <circle cx="8" cy="12" r="2" />
                        <path d="M14 10h4M14 14h4" />
                    </svg>
                </div>
                <div>
                    <div style="font-weight:700; font-size:14px; color:#22543D;">Foto KTP</div>
                    <div id="ktpNama" style="font-size:11px; color:#9ca3af; margin-top:1px;"></div>
                </div>
            </div>
            <button onclick="tutupKTP()" style="background:#f3f4f6; border:none; border-radius:50%; width:30px; height:30px; font-size:16px; cursor:pointer; color:#6b7280;">×</button>
        </div>
        <div style="padding:20px; background:#f9fafb;">
            <div style="border-radius:14px; overflow:hidden; border:1px solid #e5e7eb; background:white;">
                <img id="ktpImg" src="" alt="Foto KTP" style="width:100%; display:block; object-fit:contain; max-height:340px; background:#f3f4f6;">
            </div>
        </div>
        <div style="padding:12px 20px; border-top:1px solid #eef4f0; display:flex; justify-content:flex-end;">
            <button onclick="tutupKTP()" style="background:#22543D; color:white; border:none; border-radius:10px; padding:9px 22px; font-size:12px; font-weight:700; cursor:pointer;">Tutup</button>
        </div>
    </div>
</div>

<script>
    function bukaKTP(nama, urlFoto) {
        document.getElementById('ktpNama').textContent = nama;
        document.getElementById('ktpImg').src = urlFoto;
        document.getElementById('modalKTP').style.display = 'block';
    }

    function tutupKTP() {
        document.getElementById('modalKTP').style.display = 'none';
        document.getElementById('ktpImg').src = '';
    }
    document.getElementById('searchInput').addEventListener('input', function() {
        var q = this.value.toLowerCase();
        document.querySelectorAll('.customer-row').forEach(function(row) {
            row.style.display = row.textContent.toLowerCase().indexOf(q) !== -1 ? '' : 'none';
        });
    });
</script>

@endsection