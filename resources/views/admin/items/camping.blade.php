<!DOCTYPE html>
<html>

<head>
    <title>List Barang Camping</title>
</head>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
<style>
    :root {
        --g-dark: #080d03;
        --g-mid: #0e1a06;
        --g-light: #243810;
        --green: #6aaa2a;
        --green-text: #a8c880;
        --green-bright: #d4f0a0;
        --border-g: rgba(106, 170, 42, 0.18);
    }

    .snav {
        position: relative;
        height: 100%;
        padding: 20px 12px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        font-family: 'DM Sans', sans-serif;
        background: radial-gradient(ellipse 160px 180px at -10px 0px, #5a8a1a 0%, transparent 65%), radial-gradient(ellipse 160px 180px at -10px 100%, #4a7a12 0%, transparent 65%), linear-gradient(170deg, var(--g-dark) 0%, var(--g-mid) 35%, #182808 65%, var(--g-light) 100%);
    }

    .snav::before {
        content: '';
        position: absolute;
        left: 0;
        top: 20%;
        bottom: 20%;
        width: 1px;
        background: linear-gradient(to bottom, transparent, #6aaa2a44, transparent);
        pointer-events: none;
    }

    .s-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 4px 8px 18px;
        text-decoration: none;
    }

    .s-logo-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: linear-gradient(135deg, #6aaa2a, #3d6e12);
        box-shadow: 0 0 12px #5a9a1a44;
    }

    .s-logo-icon svg {
        width: 16px;
        height: 16px;
        color: #d4f0a0;
    }

    .s-logo span {
        font-family: 'DM Serif Display', serif;
        font-size: 18px;
        color: #e8f5d0;
    }

    .s-hr {
        height: 1px;
        background: linear-gradient(to right, transparent, #4a7a1a44, transparent);
        margin: 4px 0 10px;
    }

    .s-lbl {
        font-size: 9.5px;
        font-weight: 500;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #6a8a50;
        padding: 0 10px;
        margin: 8px 0 4px;
    }

    .s-a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 10px;
        border-radius: 8px;
        text-decoration: none;
        color: var(--green-text);
        font-size: 13.5px;
        position: relative;
        transition: all .18s;
        margin-bottom: 1px;
    }

    .s-a svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
        opacity: .65;
        transition: opacity .18s;
    }

    .s-a:hover,
    .s-a.active {
        background: rgba(106, 170, 42, .13);
        color: var(--green-bright);
        font-weight: 500;
    }

    .s-a:hover svg,
    .s-a.active svg {
        opacity: 1;
        color: #8acc44;
    }

    .s-a.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 20%;
        bottom: 20%;
        width: 2px;
        border-radius: 99px;
        background: linear-gradient(to bottom, #8acc44, #5a9a20);
        box-shadow: 0 0 6px #7aba3088;
    }

    .s-badge {
        font-size: 10px;
        font-weight: 500;
        padding: 1px 7px;
        border-radius: 99px;
        margin-left: auto;
    }

    .s-user {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .04);
        border: .5px solid var(--border-g);
        cursor: pointer;
        margin-top: 10px;
        transition: background .2s;
    }

    .s-user:hover {
        background: rgba(106, 170, 42, .08);
    }

    .s-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 1.5px solid rgba(106, 170, 42, .3);
    }

    /* Navbar */
    #top-navbar {
        border-bottom: .5px solid var(--border-g);
        background: radial-gradient(ellipse 300px 56px at 0% 50%, #2a4a0a 0%, transparent 60%), radial-gradient(ellipse 300px 56px at 100% 50%, #2a4a0a 0%, transparent 60%), linear-gradient(90deg, var(--g-dark) 0%, var(--g-mid) 40%, var(--g-mid) 60%, var(--g-dark) 100%);
    }

    .n-icon {
        position: relative;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: .5px solid var(--border-g);
        background: rgba(255, 255, 255, .04);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--green-text);
        transition: background .18s;
    }

    .n-icon:hover {
        background: rgba(106, 170, 42, .1);
        color: var(--green-bright);
    }

    .n-dot {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--green);
        border: 1.5px solid var(--g-dark);
        box-shadow: 0 0 5px #6aaa2a88;
    }

    .n-add {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        background: var(--green-bright);
        color: #1a3a06;
        border: none;
        cursor: pointer;
        transition: all .18s;
        font-family: 'DM Sans', sans-serif;
        white-space: nowrap;
    }

    .n-add:hover {
        background: #c4e088;
        box-shadow: 0 0 14px #6aaa2a44;
    }

    .n-search {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, .04);
        border: .5px solid var(--border-g);
        border-radius: 8px;
        padding: 6px 12px;
        width: 200px;
        transition: border-color .18s;
    }

    .n-search:focus-within {
        border-color: rgba(106, 170, 42, .45);
    }

    .n-search input {
        background: transparent;
        border: none;
        outline: none;
        font-size: 13px;
        color: var(--green-text);
        font-family: 'DM Sans', sans-serif;
        width: 100%;
    }

    .n-search input::placeholder {
        color: #4a6a30;
    }

    .n-search svg,
    .n-search .kbd {
        color: #4a6a30;
        flex-shrink: 0;
    }

    .kbd {
        font-size: 10px;
        background: rgba(106, 170, 42, .1);
        border: .5px solid rgba(106, 170, 42, .2);
        border-radius: 4px;
        padding: 1px 5px;
    }

    .n-divv {
        width: 1px;
        height: 20px;
        background: var(--border-g);
    }

    .n-title {
        font-family: 'DM Serif Display', serif;
        font-size: 22px;
        color: #e8f5d0;
        line-height: 1.2;
    }

    .n-sub {
        font-size: 11.5px;
        color: #6a8a50;
        font-family: 'DM Sans', sans-serif;
    }

    .n-sub span {
        color: #8acc44;
    }
</style>

<body style="background:#0f172a; color:white; font-family:sans-serif; padding:30px;">

    <aside id="top-bar-sidebar" class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
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

            <a href="{{ url('/dashboard') }}" class="s-a {{ request()->is('dashboard') ? 'active' : '' }}">
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

            <a href="{{ url('/admin/items/camera') }}"
                class="s-a {{ request()->is('admin/items/camera') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 7h4l2-2h4l2 2h4v12H4z" />
                    <circle cx="12" cy="13" r="3" />
                </svg>
                List Barang Camera
            </a>

            <a href="{{ url('/admin/items/camping') }}"
                class="s-a {{ request()->is('admin/items/camping') ? 'active' : '' }}">
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
    </aside>

    <h1>List Barang Camping</h1>

    <table border="1" cellpadding="10">

        <tr>
            <th>Nama</th>
            <th>Stok</th>
            <th>Harga</th>
        </tr>

        @foreach($items as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->stock }}</td>
            <td>{{ $item->price }}</td>
        </tr>
        @endforeach

    </table>

</body>

</html>