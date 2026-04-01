<!DOCTYPE html>
<html>

<head>
    <title>List Barang Camera</title>
</head>
<!-- <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet"> -->
<!-- <style>
    :root {
        --g-dark: #080d03;
        --g-mid: #0e1a06;
        --g-light: #243810;
        --green: #6aaa2a;
        --green-text: #a8c880;
        --green-bright: #d4f0a0;
        --border-g: rgba(106, 170, 42, 0.18);
    }

    .content {
        flex: 1;
        padding: 30px;
        margin-left: 260px;
        margin-top: 70px;
    }

    table {
        border-collapse: collapse;
        margin-top: 10px;
        background: #111827;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #374151;
    }

    .title {
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    /* Card */
    .table-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(106, 170, 42, 0.15);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 0 20px rgba(106, 170, 42, 0.08);
    }

    /* Table */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .custom-table thead {
        background: rgba(106, 170, 42, 0.1);
    }

    .custom-table th {
        text-align: left;
        padding: 12px;
        color: #d4f0a0;
        font-weight: 500;
        border-bottom: 1px solid rgba(106, 170, 42, 0.2);
    }

    .custom-table td {
        padding: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* Hover effect */
    .custom-table tbody tr:hover {
        background: rgba(106, 170, 42, 0.08);
        transition: 0.2s;
    }

    /* Badge stok */
    .badge-stock {
        background: rgba(106, 170, 42, 0.2);
        color: #a8e063;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
    }

    /* Header */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .title {
        font-size: 28px;
        font-weight: 600;
    }

    /* Button tambah */
    .btn-add {
        background: linear-gradient(135deg, #6aaa2a, #4d7c1a);
        color: #fff;
        padding: 10px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        transition: 0.2s;
    }

    .btn-add:hover {
        box-shadow: 0 0 12px rgba(106, 170, 42, 0.5);
    }

    /* Card */
    .table-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(106, 170, 42, 0.15);
        border-radius: 12px;
        padding: 20px;
    }

    /* Search */
    .table-top {
        margin-bottom: 15px;
    }

    .search-box {
        width: 250px;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid rgba(106, 170, 42, 0.2);
        background: transparent;
        color: white;
    }

    /* Table */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .custom-table thead {
        background: rgba(106, 170, 42, 0.1);
    }

    .custom-table th {
        text-align: left;
        padding: 12px;
        color: #d4f0a0;
    }

    .custom-table td {
        padding: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .custom-table tbody tr:hover {
        background: rgba(106, 170, 42, 0.08);
    }

    /* Badge */
    .badge-stock {
        background: rgba(106, 170, 42, 0.2);
        padding: 4px 10px;
        border-radius: 999px;
    }

    /* Button aksi */
    .btn-edit {
        background: #3b82f6;
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 12px;
    }

    .btn-delete {
        background: #ef4444;
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 12px;
        margin-left: 5px;
    }
</style> -->

<!-- <body style="background:#0f172a; color:white; font-family:sans-serif; margin:0; display:flex;"> -->
<body>

    <!-- <aside id="top-bar-sidebar" style="width:260px; height:100vh;">
        <div class="snav">
            <a href="{{ url('/') }}" class="s-logo">
                <div class="s-logo-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2L2 7l10 5 10-5-10-5z" />
                        <path d="M2 17l10 5 10-5" />
                        <path d="M2 12l10 5 10-5" />
                    </svg></div>
                <span>CampLore</span>
            </a>

            <div class="s-hr"></div>
            <p class="s-lbl">Navigation</p>

            <a href="{{ url('/dashboard_admin') }}" class="s-a {{ request()->is('dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z" />
                    <path d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975A7.5 7.5 0 0 0 13.5 3Z" />
                </svg>
                Dashboard
            </a>
            <a href="{{ url('/kanban') }}" class="s-a {{ request()->is('kanban') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                </svg>
                <span class="flex-1">Kanban</span>
                <span class="s-badge" style="background:rgba(106,170,42,.15);color:#8acc44;border:.5px solid rgba(106,170,42,.3)">Pro</span>
            </a>
            <a href="{{ url('/inbox') }}" class="s-a {{ request()->is('inbox') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9" />
                </svg>
                <span class="flex-1">Inbox</span>
                <span class="s-badge" style="background:rgba(220,80,60,.2);color:#f08070;border:.5px solid rgba(220,80,60,.3)">2</span>
            </a>

            <div class="s-hr" style="margin-top:10px"></div>
            <p class="s-lbl">Management</p>

            <a href="{{ route('camera.index') }}"
                class="s-a {{ request()->is('camera*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 7h4l2-2h4l2 2h4v12H4z" />
                    <circle cx="12" cy="13" r="3" />
                </svg>
                List Barang Camera
            </a>

            <a href="{{ route('camping.index') }}"
                class="s-a {{ request()->is('camping') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 20l9-16 9 16H3z" />
                </svg>
                List Barang Camping
            </a>

            {{-- MENU LAMA --}}
            <a href="{{ url('/users') }}" class="s-a {{ request()->is('users') ? 'active' : '' }}">

                <a href="{{ url('/users') }}" class="s-a {{ request()->is('users') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Users
                </a>
                <a href="{{ url('/products') }}" class="s-a {{ request()->is('products') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z" />
                    </svg>
                    Products
                </a>
                <a href="{{ url('/login') }}" class="s-a {{ request()->is('login') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2" />
                    </svg>
                    <span class="flex-1">Sign In</span>
                    <span class="s-badge" style="background:rgba(60,160,220,.15);color:#70c0f0;border:.5px solid rgba(60,160,220,.25)">New</span>
                </a>

                <div class="flex-1"></div>

                <a href="{{ url('/settings') }}" class="s-a {{ request()->is('settings') ? 'active' : '' }}" style="margin-bottom:10px">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    Settings
                </a>
                <div class="s-hr"></div>

                {{-- User Card --}}
                <div class="s-user">
                    <img class="s-avatar" src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User').'&background=3d6e12&color=d4f0a0' }}" alt="Profile">
                    <div class="flex-1 min-w-0">
                        <p style="font-size:12.5px;font-weight:500;color:#c8e898;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ Auth::user()->name ?? 'Lulu Khaira Yudita' }}</p>
                        <p style="font-size:10.5px;color:#6a8a50;margin-top:1px">{{ Auth::user()->email ?? 'Administrator' }}</p>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#5a7a40" stroke-width="2">
                        <circle cx="12" cy="5" r="1" />
                        <circle cx="12" cy="12" r="1" />
                        <circle cx="12" cy="19" r="1" />
                    </svg>
                </div>
        </div>
    </aside> -->

    @include('sidebar_dashboard_admin')

    <!-- <div class="content">
        <div class="header">
            <h1 class="title">List Barang Camera</h1>
            <a href="{{ route('camera.create') }}" class="btn-add">+ Tambah Barang</a>
        </div>

        <div class="table-card">

            SEARC
            <div class="table-top">
                <input type="text" placeholder="Cari barang..." class="search-box">
            </div>

         
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td><span class="badge-stock">{{ $item->stock }}</span></td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('camera.edit', $item->id) }}" class="btn-edit">Edit</a>

                            <form action="{{ route('camera.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div> -->

</body>

</html>