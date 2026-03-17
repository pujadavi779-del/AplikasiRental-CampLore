<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAMPLORE – Masuk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --olive:       #5E5523;
            --olive-mid:   #7a6f2e;
            --olive-light: #a89a4e;
            --crimson:     #893941;
            --cream:       #faf7f2;
            --text-main:   #2e2b20;
            --text-sub:    #7a7060;
            --border:      #ddd8cc;
        }

        html, body { height: 100%; font-family: 'Lato', sans-serif; background: var(--cream); }

        .page { display: flex; min-height: 100vh; }

        /* ── LEFT ── */
        .left {
            flex: 1;
            background: linear-gradient(160deg, var(--olive) 0%, #3a360e 50%, var(--crimson) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 64px;
            position: relative;
            overflow: hidden;
        }

        .left::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse at 25% 15%, rgba(255,255,255,0.07) 0%, transparent 55%),
                radial-gradient(ellipse at 75% 85%, rgba(0,0,0,0.15) 0%, transparent 55%);
            pointer-events: none;
        }

        .deco-circle {
            position: absolute; border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.06);
            pointer-events: none;
        }
        .dc1 { width: 380px; height: 380px; bottom: -100px; right: -80px; }
        .dc2 { width: 220px; height: 220px; bottom: 60px; right: 80px; }
        .dc3 { width: 120px; height: 120px; top: 60px; right: 60px; }

        .brand-badge {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 52px; position: relative; z-index: 1;
        }

        .brand-icon { width: 40px; height: 40px; }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 20px; font-weight: 700;
            color: rgba(255,255,255,0.92);
            letter-spacing: 5px; text-transform: uppercase;
        }

        .left-content { position: relative; z-index: 1; }

        .left-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(38px, 4vw, 54px);
            font-weight: 700; color: #fff;
            line-height: 1.18; margin-bottom: 22px;
        }

        .left-content h1 em {
            font-style: normal;
            color: rgba(255,255,255,0.42);
        }

        .left-content p {
            font-size: 14px; font-weight: 300;
            color: rgba(255,255,255,0.58);
            line-height: 1.75; max-width: 320px;
            letter-spacing: 0.3px;
        }

        .left-tags {
            display: flex; gap: 8px;
            margin-top: 44px; position: relative; z-index: 1;
            flex-wrap: wrap;
        }

        .tag {
            padding: 5px 15px;
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 20px;
            font-size: 10px; letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
        }

        /* ── RIGHT ── */
        .right {
            width: 500px; flex-shrink: 0;
            background: #fff;
            display: flex; flex-direction: column;
            justify-content: center;
            padding: 56px 52px;
            box-shadow: -2px 0 30px rgba(0,0,0,0.06);
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 26px; font-weight: 600;
            color: var(--text-main); margin-bottom: 6px;
        }

        .form-sub {
            font-size: 13px; color: var(--text-sub);
            margin-bottom: 36px; font-weight: 300;
        }

        /* inputs */
        .field { margin-bottom: 20px; }

        .field label {
            display: block; font-size: 11px;
            letter-spacing: 1.5px; text-transform: uppercase;
            color: var(--text-sub); font-weight: 500; margin-bottom: 8px;
        }

        .input-wrap { position: relative; }

        .input-wrap .ico {
            position: absolute; left: 13px; top: 50%;
            transform: translateY(-50%);
            color: #ccc; transition: color 0.2s; pointer-events: none;
        }

        .input-wrap:focus-within .ico { color: var(--olive-mid); }

        .field input {
            width: 100%;
            padding: 12px 14px 12px 40px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-family: 'Lato', sans-serif;
            font-size: 14px; color: var(--text-main);
            background: var(--cream); outline: none;
            transition: border-color 0.2s, background 0.2s;
        }

        .field input::placeholder { color: #ccc8be; }

        .field input:focus {
            border-color: var(--olive-light);
            background: #fff;
        }

        .pw-btn {
            position: absolute; right: 11px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #ccc; display: flex; align-items: center;
            padding: 4px; transition: color 0.2s;
        }
        .pw-btn:hover { color: var(--olive-mid); }

        /* options */
        .options {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 26px;
        }

        .check-label {
            display: flex; align-items: center;
            gap: 8px; cursor: pointer;
        }

        .check-label input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: var(--olive); cursor: pointer;
        }

        .check-label span { font-size: 13px; color: var(--text-sub); }

        .forgot {
            font-size: 13px; color: var(--olive-mid);
            text-decoration: none; transition: color 0.2s;
        }
        .forgot:hover { color: var(--crimson); }

        /* button */
        .btn-main {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, var(--olive) 0%, var(--crimson) 100%);
            color: #fff; border: none; border-radius: 8px;
            font-family: 'Lato', sans-serif;
            font-size: 13px; font-weight: 500;
            letter-spacing: 2px; text-transform: uppercase;
            cursor: pointer; transition: opacity 0.2s, transform 0.1s;
        }
        .btn-main:hover { opacity: 0.88; }
        .btn-main:active { transform: scale(0.99); }

        /* divider */
        .divider {
            display: flex; align-items: center;
            gap: 12px; margin: 24px 0;
        }
        .divider-line { flex: 1; height: 1px; background: var(--border); }
        .divider span { font-size: 12px; color: #ccc8be; letter-spacing: 1px; }

        /* link */
        .alt-link { text-align: center; font-size: 13px; color: var(--text-sub); }
        .alt-link a {
            color: var(--olive); font-weight: 500;
            text-decoration: none; transition: color 0.2s;
        }
        .alt-link a:hover { color: var(--crimson); }

        @media (max-width: 768px) {
            .left { display: none; }
            .right { width: 100%; padding: 40px 28px; box-shadow: none; }
        }
    </style>
</head>
<body>
<div class="page">

    <!-- LEFT -->
    <div class="left">
        <div class="deco-circle dc1"></div>
        <div class="deco-circle dc2"></div>
        <div class="deco-circle dc3"></div>

        <div class="brand-badge">
            <svg class="brand-icon" viewBox="0 0 40 40" fill="none">
                <polygon points="20,3 37,36 3,36" fill="none" stroke="rgba(255,255,255,0.65)" stroke-width="1.8" stroke-linejoin="round"/>
                <polygon points="20,13 30,36 10,36" fill="rgba(255,255,255,0.1)"/>
                <line x1="20" y1="3" x2="20" y2="36" stroke="rgba(255,255,255,0.2)" stroke-width="1" stroke-dasharray="2 3"/>
                <circle cx="9" cy="15" r="1.3" fill="rgba(255,255,255,0.45)"/>
                <circle cx="31" cy="10" r="0.9" fill="rgba(255,255,255,0.35)"/>
            </svg>
            <span class="brand-name">Camplore</span>
        </div>

        <div class="left-content">
            <h1>Camera.<br>Camping.<br><em>Explore.</em></h1>
            <p>Sewa Camera Dan Alat Camping. Semuanya Ada Disini.</p>
        </div>

        <div class="left-tags">
            <span class="tag">Hiking</span>
            <span class="tag">Camping</span>
            <span class="tag">Photography</span>
            <span class="tag">Adventure</span>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <h2 class="form-title">Masuk</h2>
        <p class="form-sub">Selamat datang kembali di Camplore</p>

        <form action="/login" method="POST">
            @csrf

            <div class="field">
                <label for="username">Username</label>
                <div class="input-wrap">
                    <svg class="ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                    <input type="text" id="username" name="username"
                        placeholder="Masukkan username"
                        value="{{ old('username') }}"
                        autocomplete="username">
                </div>
            </div>

            <div class="field">
                <label for="password">Kata Sandi</label>
                <div class="input-wrap">
                    <svg class="ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <input type="password" id="password" name="password"
                        placeholder="Masukkan kata sandi"
                        autocomplete="current-password">
                    <button type="button" class="pw-btn" onclick="togglePw('password',this)">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="options">
                <label class="check-label">
                    <input type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </label>
                <a href="#" class="forgot">Lupa kata sandi?</a>
            </div>

            <button type="submit" class="btn-main">Masuk</button>
        </form>

        <div class="divider">
            <div class="divider-line"></div>
            <span>atau</span>
            <div class="divider-line"></div>
        </div>

        <p class="alt-link">Belum punya akun? <a href="/registrasi">Daftar sekarang</a></p>
    </div>

</div>
<script>
function togglePw(id, btn) {
    const el = document.getElementById(id);
    const show = el.type === 'password';
    el.type = show ? 'text' : 'password';
    btn.innerHTML = show
        ? `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
        : `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
}
</script>
</body>
</html>