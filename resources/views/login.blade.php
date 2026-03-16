<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAMPLORE - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --olive: #5E5523;
            --crimson: #893941;
            --olive-light: #7a6e2e;
            --olive-dark: #3d3817;
            --crimson-light: #a84850;
            --crimson-dark: #5e2329;
            --gold: #c8a84b;
            --cream: #f5f0e8;
            --dark: #1a1a12;
        }

        html, body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Raleway', sans-serif;
            background: var(--dark);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            position: relative;
        }

        /* ===== ANIMATED BACKGROUND ===== */
        .bg-canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            background: radial-gradient(ellipse at 20% 50%, #3d3817 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 20%, #5e2329 0%, transparent 50%),
                        radial-gradient(ellipse at 60% 80%, #2a2208 0%, transparent 50%),
                        #0e0d08;
        }

        .bg-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: orbFloat 8s ease-in-out infinite;
        }

        .bg-orb-1 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #5E5523, transparent);
            top: -100px; left: -100px;
            animation-delay: 0s;
        }

        .bg-orb-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, #893941, transparent);
            bottom: -100px; right: -100px;
            animation-delay: -4s;
        }

        .bg-orb-3 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, #c8a84b, transparent);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.15;
            animation-delay: -2s;
        }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }

        /* Grid lines */
        .bg-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(198,168,75,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(198,168,75,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridSlide 20s linear infinite;
        }

        @keyframes gridSlide {
            0% { transform: translate(0, 0); }
            100% { transform: translate(60px, 60px); }
        }

        /* Floating particles */
        .particle {
            position: absolute;
            width: 3px; height: 3px;
            border-radius: 50%;
            background: var(--gold);
            opacity: 0;
            animation: particleRise linear infinite;
        }

        @keyframes particleRise {
            0% { transform: translateY(100vh) translateX(0); opacity: 0; }
            10% { opacity: 0.6; }
            90% { opacity: 0.3; }
            100% { transform: translateY(-10vh) translateX(40px); opacity: 0; }
        }

        /* ===== MAIN WRAPPER ===== */
        .page-wrapper {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 20px;
            animation: pageReveal 1s ease forwards;
        }

        @keyframes pageReveal {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== CARD ===== */
        .auth-card {
            width: 100%;
            max-width: 440px;
            background: linear-gradient(135deg,
                rgba(94,85,35,0.15) 0%,
                rgba(20,18,5,0.85) 40%,
                rgba(137,57,65,0.12) 100%
            );
            border: 1px solid rgba(200,168,75,0.2);
            border-radius: 24px;
            padding: 48px 40px 44px;
            backdrop-filter: blur(20px);
            box-shadow:
                0 0 0 1px rgba(200,168,75,0.05),
                0 32px 64px rgba(0,0,0,0.6),
                inset 0 1px 0 rgba(200,168,75,0.15),
                0 0 80px rgba(94,85,35,0.15);
            position: relative;
            overflow: hidden;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), var(--crimson), var(--gold), transparent);
            animation: shimmerLine 3s ease-in-out infinite;
        }

        @keyframes shimmerLine {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        .auth-card::after {
            content: '';
            position: absolute;
            bottom: -60px; right: -60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(137,57,65,0.15), transparent);
            pointer-events: none;
        }

        /* ===== LOGO ===== */
        .logo-area {
            text-align: center;
            margin-bottom: 36px;
        }

        .logo-icon {
            width: 64px; height: 64px;
            margin: 0 auto 16px;
            position: relative;
            animation: logoPulse 3s ease-in-out infinite;
        }

        .logo-icon svg {
            width: 100%; height: 100%;
            filter: drop-shadow(0 0 12px rgba(200,168,75,0.5));
        }

        @keyframes logoPulse {
            0%, 100% { transform: scale(1); filter: drop-shadow(0 0 8px rgba(200,168,75,0.4)); }
            50% { transform: scale(1.05); filter: drop-shadow(0 0 20px rgba(200,168,75,0.7)); }
        }

        .logo-title {
            font-family: 'Cinzel', serif;
            font-size: 32px;
            font-weight: 900;
            letter-spacing: 6px;
            background: linear-gradient(135deg, var(--gold) 0%, #e8d08a 40%, var(--crimson-light) 70%, var(--gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% auto;
            animation: gradientShift 4s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% center; }
            50% { background-position: 100% center; }
            100% { background-position: 0% center; }
        }

        .logo-tagline {
            font-size: 11px;
            letter-spacing: 3px;
            color: rgba(200,168,75,0.6);
            text-transform: uppercase;
            margin-top: 6px;
            font-weight: 500;
        }

        /* ===== FORM HEADING ===== */
        .form-heading {
            margin-bottom: 28px;
        }

        .form-heading h2 {
            font-family: 'Cinzel', serif;
            font-size: 20px;
            font-weight: 600;
            color: var(--cream);
            letter-spacing: 2px;
        }

        .form-heading p {
            font-size: 13px;
            color: rgba(245,240,232,0.45);
            margin-top: 6px;
            font-weight: 300;
        }

        /* ===== INPUT GROUP ===== */
        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-label {
            display: block;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(200,168,75,0.8);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(200,168,75,0.5);
            transition: color 0.3s;
            pointer-events: none;
        }

        .input-field {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(200,168,75,0.2);
            border-radius: 12px;
            padding: 14px 16px 14px 46px;
            font-family: 'Raleway', sans-serif;
            font-size: 14px;
            color: var(--cream);
            outline: none;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        .input-field::placeholder {
            color: rgba(245,240,232,0.25);
        }

        .input-field:focus {
            border-color: rgba(200,168,75,0.6);
            background: rgba(200,168,75,0.06);
            box-shadow: 0 0 0 3px rgba(200,168,75,0.08), 0 0 20px rgba(200,168,75,0.1);
        }

        .input-field:focus + .input-glow {
            opacity: 1;
        }

        .input-field:focus ~ .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: var(--gold);
        }

        .input-glow {
            position: absolute;
            inset: -1px;
            border-radius: 12px;
            background: transparent;
            pointer-events: none;
            border: 1px solid transparent;
            opacity: 0;
            transition: opacity 0.3s;
        }

        /* Password toggle */
        .pw-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(200,168,75,0.4);
            padding: 4px;
            transition: color 0.3s;
            display: flex;
            align-items: center;
        }

        .pw-toggle:hover { color: var(--gold); }

        /* ===== OPTIONS ROW ===== */
        .options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
        }

        .custom-check {
            width: 16px; height: 16px;
            border: 1px solid rgba(200,168,75,0.4);
            border-radius: 4px;
            background: transparent;
            position: relative;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .custom-check input {
            position: absolute;
            opacity: 0;
            width: 0; height: 0;
        }

        .custom-check input:checked + .check-box {
            background: var(--olive);
            border-color: var(--gold);
        }

        .custom-check input:checked + .check-box::after {
            content: '';
            position: absolute;
            top: 2px; left: 5px;
            width: 4px; height: 7px;
            border: 2px solid var(--gold);
            border-top: none; border-left: none;
            transform: rotate(45deg);
        }

        .check-box {
            width: 16px; height: 16px;
            border: 1px solid rgba(200,168,75,0.4);
            border-radius: 4px;
            transition: all 0.2s;
            position: relative;
        }

        .remember-text {
            font-size: 12px;
            color: rgba(245,240,232,0.5);
        }

        .forgot-link {
            font-size: 12px;
            color: rgba(200,168,75,0.7);
            text-decoration: none;
            transition: color 0.2s;
            letter-spacing: 0.5px;
        }

        .forgot-link:hover { color: var(--gold); }

        /* ===== SUBMIT BUTTON ===== */
        .btn-submit {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            font-family: 'Cinzel', serif;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--olive) 0%, var(--crimson) 100%);
            color: var(--cream);
            transition: all 0.3s ease;
            box-shadow: 0 4px 24px rgba(137,57,65,0.3), 0 4px 24px rgba(94,85,35,0.2);
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--olive-light) 0%, var(--crimson-light) 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-submit:hover::before { opacity: 1; }

        .btn-submit::after {
            content: '';
            position: absolute;
            top: -50%; left: -60%;
            width: 40%; height: 200%;
            background: rgba(255,255,255,0.15);
            transform: skewX(-20deg);
            transition: left 0.6s ease;
        }

        .btn-submit:hover::after { left: 120%; }

        .btn-submit span {
            position: relative;
            z-index: 1;
        }

        .btn-submit:active { transform: scale(0.98); }

        /* ===== DIVIDER ===== */
        .divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 24px 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(200,168,75,0.2), transparent);
        }

        .divider-text {
            font-size: 11px;
            color: rgba(245,240,232,0.3);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* ===== REGISTER LINK ===== */
        .register-row {
            text-align: center;
        }

        .register-row p {
            font-size: 13px;
            color: rgba(245,240,232,0.4);
        }

        .register-link {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            position: relative;
            transition: color 0.2s;
        }

        .register-link::after {
            content: '';
            position: absolute;
            bottom: -2px; left: 0;
            width: 0; height: 1px;
            background: var(--gold);
            transition: width 0.3s;
        }

        .register-link:hover::after { width: 100%; }
        .register-link:hover { color: #e8d08a; }

        /* ===== CORNER DECORATIONS ===== */
        .corner-deco {
            position: absolute;
            width: 30px; height: 30px;
            opacity: 0.5;
        }

        .corner-deco.tl { top: 16px; left: 16px; border-top: 1px solid var(--gold); border-left: 1px solid var(--gold); border-radius: 4px 0 0 0; }
        .corner-deco.tr { top: 16px; right: 16px; border-top: 1px solid var(--gold); border-right: 1px solid var(--gold); border-radius: 0 4px 0 0; }
        .corner-deco.bl { bottom: 16px; left: 16px; border-bottom: 1px solid var(--gold); border-left: 1px solid var(--gold); border-radius: 0 0 0 4px; }
        .corner-deco.br { bottom: 16px; right: 16px; border-bottom: 1px solid var(--gold); border-right: 1px solid var(--gold); border-radius: 0 0 4px 0; }

        /* ===== STAGGER ANIMATION ===== */
        .stagger-1 { animation: slideUp 0.6s ease 0.1s both; }
        .stagger-2 { animation: slideUp 0.6s ease 0.2s both; }
        .stagger-3 { animation: slideUp 0.6s ease 0.3s both; }
        .stagger-4 { animation: slideUp 0.6s ease 0.4s both; }
        .stagger-5 { animation: slideUp 0.6s ease 0.5s both; }
        .stagger-6 { animation: slideUp 0.6s ease 0.6s both; }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- Animated Background -->
<div class="bg-canvas">
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="bg-orb bg-orb-3"></div>
    <div class="bg-grid"></div>
</div>

<!-- Particles (JS will fill these) -->
<div id="particles"></div>

<!-- Main Content -->
<div class="page-wrapper">
    <div class="auth-card">

        <!-- Corner decorations -->
        <div class="corner-deco tl"></div>
        <div class="corner-deco tr"></div>
        <div class="corner-deco bl"></div>
        <div class="corner-deco br"></div>

        <!-- Logo -->
        <div class="logo-area stagger-1">
            <div class="logo-icon">
                <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Tent / Mountain shape -->
                    <polygon points="32,6 58,52 6,52" fill="none" stroke="url(#goldGrad)" stroke-width="2.5" stroke-linejoin="round"/>
                    <polygon points="32,18 46,52 18,52" fill="rgba(94,85,35,0.4)" stroke="none"/>
                    <line x1="32" y1="6" x2="32" y2="52" stroke="url(#goldGrad)" stroke-width="1.5" stroke-dasharray="3 3" opacity="0.5"/>
                    <!-- Stars -->
                    <circle cx="16" cy="18" r="1.5" fill="url(#goldGrad)" opacity="0.8"/>
                    <circle cx="48" cy="14" r="1" fill="#c8a84b" opacity="0.6"/>
                    <circle cx="10" cy="32" r="1" fill="#c8a84b" opacity="0.5"/>
                    <!-- Base line -->
                    <line x1="4" y1="52" x2="60" y2="52" stroke="url(#goldGrad)" stroke-width="1.5" opacity="0.6"/>
                    <defs>
                        <linearGradient id="goldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#c8a84b"/>
                            <stop offset="50%" stop-color="#e8d08a"/>
                            <stop offset="100%" stop-color="#893941"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <h1 class="logo-title">CAMPLORE</h1>
            <p class="logo-tagline">CAMERA · CAMPING · EXPLORE</p>
        </div>

        <!-- Form Heading -->
        <div class="form-heading stagger-2">
            <h2>Selamat Datang</h2>
            <p>Masuk ke akun Anda untuk melanjutkan petualangan</p>
        </div>

        <!-- LOGIN FORM -->
        <form action="/login" method="POST">
            @csrf

            <!-- Username -->
            <div class="input-group stagger-3">
                <label class="input-label" for="username">Username</label>
                <div class="input-wrapper">
                    <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="input-field"
                        placeholder="Masukkan username Anda"
                        required
                        autocomplete="username"
                        value="{{ old('username') }}"
                    >
                </div>
            </div>

            <!-- Password -->
            <div class="input-group stagger-4">
                <label class="input-label" for="password">Password</label>
                <div class="input-wrapper">
                    <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="input-field"
                        placeholder="Masukkan password Anda"
                        required
                        autocomplete="current-password"
                    >
                    <button type="button" class="pw-toggle" onclick="togglePassword('password', this)" aria-label="Toggle password">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Options -->
            <div class="options-row stagger-5">
                <label class="remember-label">
                    <span class="custom-check">
                        <input type="checkbox" name="remember">
                        <span class="check-box"></span>
                    </span>
                    <span class="remember-text">Ingat saya</span>
                </label>
                <a href="#" class="forgot-link">Lupa password?</a>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-submit stagger-6">
                <span>Masuk</span>
            </button>

        </form>

        <!-- Divider -->
        <div class="divider">
            <div class="divider-line"></div>
            <span class="divider-text">atau</span>
            <div class="divider-line"></div>
        </div>

        <!-- Register link -->
        <div class="register-row">
            <p>Belum punya akun? <a href="/registrasi" class="register-link">Daftar sekarang</a></p>
        </div>

    </div>
</div>

<script>
    // Generate floating particles
    const container = document.getElementById('particles');
    const count = 25;
    for (let i = 0; i < count; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        p.style.left = Math.random() * 100 + 'vw';
        p.style.animationDuration = (6 + Math.random() * 10) + 's';
        p.style.animationDelay = (Math.random() * 10) + 's';
        p.style.width = p.style.height = (1.5 + Math.random() * 2.5) + 'px';
        p.style.opacity = Math.random() * 0.5;
        container.appendChild(p);
    }

    // Password toggle
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        btn.innerHTML = isPassword
            ? `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
            : `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
    }

    // Ripple on submit
    document.querySelector('.btn-submit').addEventListener('click', function(e) {
        const btn = this;
        const ripple = document.createElement('span');
        const rect = btn.getBoundingClientRect();
        ripple.style.cssText = `
            position:absolute;width:6px;height:6px;background:rgba(255,255,255,0.4);
            border-radius:50%;top:${e.clientY - rect.top - 3}px;left:${e.clientX - rect.left - 3}px;
            transform:scale(0);animation:ripple 0.6s ease forwards;pointer-events:none;z-index:2;
        `;
        btn.appendChild(ripple);
        setTimeout(() => ripple.remove(), 600);
    });

    const style = document.createElement('style');
    style.textContent = `@keyframes ripple { to { transform: scale(60); opacity: 0; } }`;
    document.head.appendChild(style);
</script>
</body>
</html>