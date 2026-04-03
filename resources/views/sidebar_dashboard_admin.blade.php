<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@400;500;600&display=swap');

    .snav {
        font-family: 'DM Sans', sans-serif;
        height: 100%;
        background: #e5e6d8;
        display: flex;
        flex-direction: column;
        padding: 20px 0 16px;
    }

    .s-logo-area {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 18px 18px;
        border-bottom: 0.5px solid #c8c9b4;
    }

    .s-logo-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: #5a7a3a;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .s-logo-icon svg {
        width: 16px;
        height: 16px;
        color: #dff0c0;
    }

    .s-logo-name {
        font-family: 'DM Serif Display', serif;
        font-size: 17px;
        color: #2a3020;
    }

    .s-nav {
        flex: 1;
        padding: 14px 10px;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .s-lbl {
        font-size: 9.5px;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #7a8060;
        padding: 10px 8px 4px;
    }

    .s-a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 10px;
        border-radius: 9px;
        text-decoration: none;
        font-size: 13px;
        color: #4a5038;
        transition: all .15s;
        position: relative;
    }

    .s-a svg {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
        opacity: .6;
        transition: opacity .15s;
    }

    .s-a:hover {
        background: #d4d6c4;
        color: #2a3020;
    }

    .s-a:hover svg {
        opacity: .9;
    }

    .s-a.active {
        background: #ffffff;
        color: #2a3020;
        font-weight: 600;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }

    .s-a.active svg {
        opacity: 1;
        color: #4a7a28;
    }

    .s-badge {
        font-size: 10px;
        font-weight: 600;
        padding: 1px 7px;
        border-radius: 99px;
        margin-left: auto;
    }

    .s-hr {
        height: 0.5px;
        background: #c8c9b4;
        margin: 8px 10px;
    }

    .s-user {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 10px;
        border-radius: 10px;
        background: #d4d6c4;
        cursor: pointer;
        border: 0.5px solid #c8c9b4;
        margin: 0 10px;
    }

    .s-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 1.5px solid #a8b890;
    }
</style>

{{-- ═══ SIDEBAR ═══ --}}
<aside id="top-bar-sidebar" class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="snav">

        {{-- Logo --}}
        <div class="s-logo-area">
            <div class="s-logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
            </div>
            <span class="s-logo-name">CampLore</span>
        </div>

        <div class="s-nav">
            <p class="s-lbl">Navigation</p>

            <a href="{{ url('/dashboard_admin') }}" class="s-a {{ request()->is('dashboard_admin') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z"/>
                    <path d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975A7.5 7.5 0 0 0 13.5 3Z"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ url('/kanban') }}" class="s-a {{ request()->is('kanban') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 5v14M9 5v14M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
                </svg>
                <span style="flex:1">Kanban</span>
                <span class="s-badge" style="background:#c8d0a8;color:#3a4820;border:0.5px solid #a8b088">Pro</span>
            </a>

            <a href="{{ url('/inbox') }}" class="s-a {{ request()->is('inbox') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 13h3.439a.991.991 0 0 1 .908.6 3.978 3.978 0 0 0 7.306 0 .99.99 0 0 1 .908-.6H20M4 13v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M4 13l2-9h12l2 9"/>
                </svg>
                <span style="flex:1">Inbox</span>
                <span class="s-badge" style="background:#f0c8c0;color:#802018;border:0.5px solid #dca898">2</span>
            </a>

            <div class="s-hr"></div>
            <p class="s-lbl">Management</p>

            <a href="{{ route('camera.index') }}" class="s-a {{ request()->is('camera*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 7h4l2-2h4l2 2h4v12H4z"/>
                    <circle cx="12" cy="13" r="3"/>
                </svg>
                List Barang Camera
            </a>

            <a href="{{ route('camping.index') }}" class="s-a {{ request()->is('camping') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 20l9-16 9 16H3z"/>
                </svg>
                List Barang Camping
            </a>

            <a href="{{ url('/users') }}" class="s-a {{ request()->is('users') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
                Users
            </a>

            <a href="{{ url('/products') }}" class="s-a {{ request()->is('products') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z"/>
                </svg>
                Products
            </a>

            <a href="{{ url('/login') }}" class="s-a {{ request()->is('login') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
                </svg>
                <span style="flex:1">Sign In</span>
                <span class="s-badge" style="background:#c8d8e8;color:#1a3a60;border:0.5px solid #a0b8d0">New</span>
            </a>

            <div style="flex:1"></div>
            <div class="s-hr"></div>

            <a href="{{ url('/settings') }}" class="s-a {{ request()->is('settings') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                Settings
            </a>
        </div>

        {{-- User Card --}}
        <div class="s-hr"></div>
        <div class="s-user">
            <img class="s-avatar"
                src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'User').'&background=5a7a3a&color=dff0c0' }}"
                alt="Profile">
            <div style="flex:1;min-width:0">
                <p style="font-size:12px;font-weight:600;color:#2a3020;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                    {{ Auth::user()->name ?? 'Lulu Khaira' }}
                </p>
                <p style="font-size:10px;color:#6a7858;margin:0">
                    {{ Auth::user()->email ?? 'Administrator' }}
                </p>
            </div>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8a9070" stroke-width="2">
                <circle cx="12" cy="5" r="1"/>
                <circle cx="12" cy="12" r="1"/>
                <circle cx="12" cy="19" r="1"/>
            </svg>
        </div>

    </div>
</aside>