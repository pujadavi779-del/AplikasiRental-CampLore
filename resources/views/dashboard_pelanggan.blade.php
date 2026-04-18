@extends('layouts.app')

@section('title', 'Dashboard - Camplore')

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    * { box-sizing: border-box; }
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #EEF3F0;
        margin: 0;
    }

    /* ---- SIDEBAR ---- */
    .sidebar {
        width: 260px;
        min-height: 100vh;
        background: linear-gradient(170deg, #22543D 0%, #1B4332 60%, #163527 100%);
        position: fixed;
        top: 0; left: 0; bottom: 0;
        display: flex;
        flex-direction: column;
        padding: 28px 20px;
        overflow-y: auto;
        z-index: 40;
    }
    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 32px;
        text-decoration: none;
    }
    .sidebar-logo img {
        width: 36px; height: 36px;
        border-radius: 10px;
        object-fit: cover;
    }
    .sidebar-logo span {
        font-size: 1.3rem;
        font-weight: 800;
        color: white;
        letter-spacing: -0.5px;
    }
    .sidebar-logo span em {
        font-style: normal;
        color: #ED64A6;
    }

    /* Avatar */
    .avatar-ring {
        width: 76px; height: 76px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ED64A6, #22543D);
        padding: 3px;
        margin: 0 auto 12px;
    }
    .avatar-inner {
        width: 100%; height: 100%;
        border-radius: 50%;
        background: #163527;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem; font-weight: 800; color: white;
        overflow: hidden;
    }
    .avatar-inner img { width: 100%; height: 100%; object-fit: cover; }

    .user-name  { color: #fff; font-weight: 700; font-size: 0.95rem; text-align: center; }
    .user-email { color: #86EFAC; font-size: 0.72rem; text-align: center; margin-top: 2px; word-break: break-all; }
    .user-badge {
        margin: 10px auto 0;
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(237,100,166,0.18);
        border: 1px solid rgba(237,100,166,0.35);
        color: #F9A8D4;
        font-size: 0.7rem; font-weight: 700;
        padding: 4px 12px; border-radius: 99px;
    }

    /* Nav */
    .nav-section { margin: 28px 0 8px; color: #86EFAC; font-size: 0.65rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; padding-left: 4px; }
    .nav-item {
        display: flex; align-items: center; gap: 11px;
        padding: 10px 14px;
        border-radius: 12px;
        color: #BBF7D0;
        font-size: 0.875rem; font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        border-left: 3px solid transparent;
        margin-bottom: 2px;
    }
    .nav-item:hover { background: rgba(255,255,255,0.07); color: white; border-left-color: #ED64A6; }
    .nav-item.active { background: rgba(237,100,166,0.15); color: white; border-left-color: #ED64A6; }
    .nav-item svg { flex-shrink: 0; opacity: 0.8; }
    .nav-item.active svg { opacity: 1; }

    /* Logout */
    .logout-btn {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 14px;
        border-radius: 12px;
        color: #86EFAC;
        font-size: 0.875rem; font-weight: 600;
        background: none; border: none; cursor: pointer; width: 100%;
        transition: all 0.2s;
    }
    .logout-btn:hover { background: rgba(255,255,255,0.07); color: #FCA5A5; }

    /* ---- MAIN ---- */
    .main-content {
        margin-left: 260px;
        min-height: 100vh;
        padding: 36px 36px 60px;
    }

    /* Page title */
    .page-title { font-size: 1.75rem; font-weight: 800; color: #22543D; letter-spacing: -0.5px; }
    .page-sub   { color: #6B7280; font-size: 0.85rem; margin-top: 4px; }

    /* Flash */
    .flash-bar {
        display: flex; align-items: center; gap: 12px;
        background: #F0FDF4; border: 1.5px solid #86EFAC;
        color: #166534;
        padding: 12px 18px; border-radius: 14px;
        font-size: 0.875rem; font-weight: 600;
        margin-bottom: 24px;
    }

    /* Filter pills */
    .filters { display: flex; flex-wrap: wrap; gap: 8px; margin: 20px 0 28px; }
    .f-pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 18px;
        border-radius: 99px;
        border: 1.5px solid #D1D5DB;
        background: white;
        color: #6B7280;
        font-size: 0.8rem; font-weight: 600;
        text-decoration: none;
        transition: all 0.18s;
    }
    .f-pill:hover { border-color: #22543D; color: #22543D; }
    .f-pill.active { background: #22543D; border-color: #22543D; color: white; }
    .f-dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; opacity: 0.65; }

    /* Rental card */
    .rental-card {
        background: white;
        border-radius: 18px;
        border: 1.5px solid #E5E7EB;
        border-left: 30px solid #22543D;
        padding: 20px 22px;
        display: flex; align-items: center; gap: 18px;
        margin-bottom: 14px;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .rental-card:hover { box-shadow: 0 8px 28px rgba(34,84,61,0.10); transform: translateY(-2px); }
    .rental-thumb {
        width: 82px; height: 82px;
        border-radius: 12px;
        border: 1.5px solid #E5E7EB;
        overflow: hidden; flex-shrink: 0;
        background: #F3F4F6;
    }
    .rental-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .rental-info { flex: 1; min-width: 0; }
    .rental-name { font-size: 1rem; font-weight: 700; color: #111827; }
    .rental-product { font-size: 0.82rem; color: #6B7280; margin-top: 2px; }
    .rental-date { font-size: 0.75rem; color: #9CA3AF; margin-top: 4px; font-style: italic; }
    .rental-right { display: flex; flex-direction: column; align-items: flex-end; gap: 8px; flex-shrink: 0; }
    .rental-price { font-size: 1.05rem; font-weight: 800; color: #22543D; }

    /* Status badges */
    .badge { display: inline-flex; align-items: center; padding: 3px 12px; border-radius: 99px; font-size: 0.72rem; font-weight: 700; }
    .badge-pending    { background: #FEF9C3; color: #854D0E; }
    .badge-processing { background: #DCFCE7; color: #166534; }
    .badge-shipped    { background: #DBEAFE; color: #1E40AF; }
    .badge-arrive     { background: #D1FAE5; color: #065F46; }
    .badge-cancelled  { background: #FEE2E2; color: #991B1B; }
    .badge-returned   { background: #F3E8FF; color: #6B21A8; }

    /* Action buttons */
    .btn-detail {
        border: 1.5px solid #22543D; color: #22543D;
        padding: 7px 16px; border-radius: 9px;
        font-size: 0.78rem; font-weight: 700;
        text-decoration: none; display: inline-block;
        transition: all 0.18s;
    }
    .btn-detail:hover { background: #22543D; color: white; }
    .btn-review {
        background: #ED64A6; color: white;
        padding: 7px 16px; border-radius: 9px;
        font-size: 0.78rem; font-weight: 700;
        text-decoration: none; display: inline-block;
        transition: all 0.18s;
    }
    .btn-review:hover { background: #DB2777; }

    /* Empty state */
    .empty-state {
        background: white;
        border-radius: 20px;
        border: 1.5px solid #E5E7EB;
        padding: 64px 32px;
        text-align: center;
    }
    .empty-icon {
        width: 88px; height: 88px;
        background: #EEF3F0;
        border-radius: 22px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
    }
    .empty-title { font-size: 1.2rem; font-weight: 800; color: #22543D; margin-bottom: 8px; }
    .empty-sub { color: #9CA3AF; font-size: 0.85rem; max-width: 280px; margin: 0 auto 24px; line-height: 1.6; }
    .btn-browse {
        display: inline-flex; align-items: center; gap: 8px;
        background: #22543D; color: white;
        padding: 12px 28px; border-radius: 99px;
        font-weight: 700; font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 4px 14px rgba(34,84,61,0.25);
    }
    .btn-browse:hover { background: #ED64A6; box-shadow: 0 4px 14px rgba(237,100,166,0.3); }

    @keyframes fadeSlide {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .anim { animation: fadeSlide 0.4s ease forwards; }
    .anim-d1 { animation-delay: 0.05s; opacity: 0; }
    .anim-d2 { animation-delay: 0.12s; opacity: 0; }
    .anim-d3 { animation-delay: 0.18s; opacity: 0; }
</style>
@endpush

@section('content')

{{-- ====== SIDEBAR ====== --}}
<aside class="sidebar">

    {{-- Logo --}}
    <a href="{{ url('/') }}" class="sidebar-logo">
        <img src="{{ asset('images/Black_Summer_Camp_Adventure_Logo-removebg-preview.png') }}" alt="Camplore Logo"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
        <div style="display:none; width:36px; height:36px; background:white; border-radius:10px; align-items:center; justify-content:center;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:20px;height:20px;color:#22543D" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
            </svg>
        </div>
        
    </a>

    {{-- User info --}}
    <div style="text-align:center;">
        <div class="avatar-ring">
            <div class="avatar-inner">
                @if(auth()->user()->photo ?? false)
                    <img src="{{ asset('storage/'.auth()->user()->photo) }}" alt="foto">
                @else
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                @endif
            </div>
        </div>
        <div class="user-name">{{ auth()->user()->name ?? 'Pelanggan' }}</div>
        <div class="user-email">{{ auth()->user()->email ?? '' }}</div>
        <div style="text-align:center;">
            <span class="user-badge">⛺ Explorer Member</span>
        </div>
    </div>

    {{-- Nav --}}
    <div class="nav-section">Menu</div>
    <nav>
        <a href="{{ route('dashboard') }}"
           class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Rent History
        </a>
        <a href="{{ route('change-password') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            Change Password
        </a>
        <a href="#" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Settings
        </a>
        <a href="{{ route('shipping-address') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Shipping Address
        </a>
    </nav>

    {{-- Spacer --}}
    <div style="flex:1;"></div>

    {{-- Logout --}}
    <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 16px; margin-top: 16px;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>

{{-- ====== MAIN CONTENT ====== --}}
<main class="main-content">

    {{-- Flash --}}
    @if(session('success'))
    <div class="flash-bar anim" id="flash-msg">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="flex-shrink:0">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
        <button onclick="document.getElementById('flash-msg').remove()"
            style="margin-left:auto; background:none; border:none; cursor:pointer; color:#166534; font-size:1rem; line-height:1;">✕</button>
    </div>
    @endif

    {{-- Header --}}
    <div class="anim anim-d1">
        <h1 class="page-title">Rent History</h1>
        <p class="page-sub">Review all your rental transactions based on their status.</p>
    </div>

    {{-- Filters --}}
    @php
        $activeStatus = request('status', 'all');
        $filters = [
            ['label' => 'All',        'value' => 'all'],
            ['label' => 'Pending',    'value' => 'pending'],
            ['label' => 'Processing', 'value' => 'processing'],
            ['label' => 'Shipped',    'value' => 'shipped'],
            ['label' => 'Arrive',     'value' => 'arrive'],
            ['label' => 'Cancelled',  'value' => 'cancelled'],
            ['label' => 'Returned',   'value' => 'returned'],
        ];
    @endphp
    <div class="filters anim anim-d2">
        @foreach($filters as $f)
        <a href="?status={{ $f['value'] }}"
           class="f-pill {{ $activeStatus === $f['value'] ? 'active' : '' }}">
            <span class="f-dot"></span>
            {{ $f['label'] }}
        </a>
        @endforeach
    </div>

    {{-- Rental List --}}
    <div class="anim anim-d3">
        @forelse($rentals ?? [] as $rental)

        @php
            $status = strtolower($rental->status ?? 'pending');
            $badgeClass = match($status) {
                'pending'    => 'badge-pending',
                'processing' => 'badge-processing',
                'shipped'    => 'badge-shipped',
                'arrive'     => 'badge-arrive',
                'cancelled'  => 'badge-cancelled',
                'returned'   => 'badge-returned',
                default      => 'badge-pending',
            };
        @endphp

        <div class="rental-card">
            {{-- Thumbnail --}}
            <div class="rental-thumb">
                <img src="{{ $rental->product->image ?? 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&q=80&w=200' }}"
                     alt="{{ $rental->product->name ?? 'Gear' }}">
            </div>

            {{-- Info --}}
            <div class="rental-info">
                <div class="rental-name">Rent {{ $rental->product->name ?? 'Produk' }}</div>
                <div class="rental-product">Produk: {{ $rental->product->name ?? '-' }}</div>
                <div class="rental-date">
                    Dipesan: {{ \Carbon\Carbon::parse($rental->created_at)->format('d M Y, H:i') }}
                </div>
                <span class="badge {{ $badgeClass }}" style="margin-top:8px;">
                    {{ ucfirst($status) }}
                </span>
            </div>

            {{-- Right: price + actions --}}
            <div class="rental-right">
                <div class="rental-price">
                    IDR {{ number_format($rental->total_price ?? 0, 0, ',', '.') }}
                </div>
                <div style="display:flex; gap:8px; flex-wrap:wrap; justify-content:flex-end;">
                    <a href="{{ route('rentals.show', $rental->id) }}" class="btn-detail">
                        → View Details
                    </a>
                    @if($status === 'arrive' && !($rental->review ?? false))
                    <a href="{{ route('reviews.create', $rental->id) }}" class="btn-review">
                        ✍️ Beri Ulasan
                    </a>
                    @endif
                </div>
            </div>
        </div>

        @empty
        {{-- Empty state --}}
        <div class="empty-state">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="#22543D" style="opacity:0.3">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="empty-title">Belum Ada Riwayat Sewa</div>
            <div class="empty-sub">Kamu belum pernah menyewa gear apapun. Yuk mulai petualanganmu sekarang!</div>
            <a href="{{ url('/catalog') }}" class="btn-browse">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                </svg>
                Browse Gear Sekarang
            </a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if(isset($rentals) && method_exists($rentals, 'hasPages') && $rentals->hasPages())
    <div style="margin-top: 28px;">
        {{ $rentals->withQueryString()->links() }}
    </div>
    @endif

</main>

@endsection

@push('scripts')
<script>
    // Auto-dismiss flash setelah 4 detik
    setTimeout(() => {
        const el = document.getElementById('flash-msg');
        if (el) {
            el.style.transition = 'opacity 0.4s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 400);
        }
    }, 4000);
</script>
@endpush