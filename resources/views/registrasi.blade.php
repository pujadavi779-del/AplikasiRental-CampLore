<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAMPLORE - Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            margin: 0; padding: 0; box-sizing: border-box;
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
            overflow-x: hidden;
            padding: 20px;
        }
 
        /* ===== BACKGROUND ===== */
        .bg-canvas {
            position: fixed; inset: 0; z-index: 0;
            background: radial-gradient(ellipse at 80% 50%, #3d3817 0%, transparent 60%),
                        radial-gradient(ellipse at 20% 20%, #5e2329 0%, transparent 50%),
                        radial-gradient(ellipse at 40% 80%, #2a2208 0%, transparent 50%),
                        #0e0d08;
        }
 
        .bg-orb {
            position: absolute; border-radius: 50%;
            filter: blur(80px); opacity: 0.4;
            animation: orbFloat 8s ease-in-out infinite;
        }
 
        .bg-orb-1 { width: 450px; height: 450px; background: radial-gradient(circle, #893941, transparent); top: -80px; right: -80px; animation-delay: 0s; }
        .bg-orb-2 { width: 400px; height: 400px; background: radial-gradient(circle, #5E5523, transparent); bottom: -80px; left: -80px; animation-delay: -4s; }
        .bg-orb-3 { width: 250px; height: 250px; background: radial-gradient(circle, #c8a84b, transparent); top: 40%; left: 40%; opacity: 0.12; animation-delay: -2s; }
 
        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(-25px, 25px) scale(1.04); }
            66% { transform: translate(20px, -15px) scale(0.96); }
        }
 
        .bg-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(198,168,75,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(137,57,65,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridSlide 25s linear infinite;
        }
 
        @keyframes gridSlide {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }
 
        .particle {
            position: fixed;
            width: 3px; height: 3px; border-radius: 50%;
            background: var(--gold); opacity: 0;
            animation: particleRise linear infinite;
        }
 
        @keyframes particleRise {
            0% { transform: translateY(100vh); opacity: 0; }
            10% { opacity: 0.5; }
            90% { opacity: 0.2; }
            100% { transform: translateY(-10vh) translateX(30px); opacity: 0; }
        }
 
        /* ===== PAGE WRAPPER ===== */
        .page-wrapper {
            position: relative; z-index: 10;
            display: flex; align-items: center; justify-content: center;
            width: 100%; padding: 20px;
            animation: pageReveal 0.8s ease forwards;
        }
 
        @keyframes pageReveal {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
 
        /* ===== CARD ===== */
        .auth-card {
            width: 100%; max-width: 460px;
            background: linear-gradient(145deg,
                rgba(137,57,65,0.12) 0%,
                rgba(15,13,4,0.88) 35%,
                rgba(94,85,35,0.14) 100%
            );
            border: 1px solid rgba(200,168,75,0.18);
            border-radius: 24px;
            padding: 44px 40px 40px;
            backdrop-filter: blur(20px);
            box-shadow:
                0 0 0 1px rgba(200,168,75,0.04),
                0 32px 80px rgba(0,0,0,0.65),
                inset 0 1px 0 rgba(200,168,75,0.12),
                0 0 80px rgba(137,57,65,0.12);
            position: relative; overflow: hidden;
        }
 
        .auth-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, transparent, var(--crimson), var(--gold), var(--crimson), transparent);
            animation: shimmerLine 3s ease-in-out infinite;
        }
 
        @keyframes shimmerLine {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 1; }
        }
 
        .corner-deco {
            position: absolute; width: 28px; height: 28px; opacity: 0.45;
        }
        .corner-deco.tl { top: 14px; left: 14px; border-top: 1px solid var(--gold); border-left: 1px solid var(--gold); border-radius: 4px 0 0 0; }
        .corner-deco.tr { top: 14px; right: 14px; border-top: 1px solid var(--gold); border-right: 1px solid var(--gold); border-radius: 0 4px 0 0; }
        .corner-deco.bl { bottom: 14px; left: 14px; border-bottom: 1px solid var(--gold); border-left: 1px solid var(--gold); border-radius: 0 0 0 4px; }
        .corner-deco.br { bottom: 14px; right: 14px; border-bottom: 1px solid var(--gold); border-right: 1px solid var(--gold); border-radius: 0 0 4px 0; }
 
        /* ===== LOGO ===== */
        .logo-area {
            text-align: center; margin-bottom: 28px;
        }
 
        .logo-icon {
            width: 54px; height: 54px; margin: 0 auto 12px;
            animation: logoPulse 3s ease-in-out infinite;
        }
 
        .logo-icon svg {
            width: 100%; height: 100%;
            filter: drop-shadow(0 0 10px rgba(200,168,75,0.45));
        }
 
        @keyframes logoPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.06); }
        }
 
        .logo-title {
            font-family: 'Cinzel', serif;
            font-size: 28px; font-weight: 900; letter-spacing: 6px;
            background: linear-gradient(135deg, var(--gold) 0%, #e8d08a 40%, var(--crimson-light) 70%, var(--gold) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
            background-size: 200% auto;
            animation: gradientShift 4s ease infinite;
        }
 
        @keyframes gradientShift {
            0% { background-position: 0% center; }
            50% { background-position: 100% center; }
            100% { background-position: 0% center; }
        }
 
        .logo-tagline {
            font-size: 10px; letter-spacing: 3px;
            color: rgba(200,168,75,0.55); text-transform: uppercase;
            margin-top: 5px; font-weight: 500;
        }
 
        /* ===== HEADING ===== */
        .form-heading { margin-bottom: 24px; }
 
        .form-heading h2 {
            font-family: 'Cinzel', serif; font-size: 18px;
            font-weight: 600; color: var(--cream); letter-spacing: 2px;
        }
 
        .form-heading p {
            font-size: 12px; color: rgba(245,240,232,0.4);
            margin-top: 5px; font-weight: 300;
        }
 
        /* ===== STEPS INDICATOR ===== */
        .steps-bar {
            display: flex; align-items: center; gap: 0;
            margin-bottom: 28px;
        }
 
        .step-dot {
            width: 28px; height: 28px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 600; letter-spacing: 0;
            font-family: 'Cinzel', serif;
            border: 1px solid rgba(200,168,75,0.25);
            color: rgba(200,168,75,0.4);
            background: transparent;
            transition: all 0.4s ease;
            position: relative; z-index: 1;
        }
 
        .step-dot.active {
            border-color: var(--gold);
            color: var(--dark);
            background: var(--gold);
            box-shadow: 0 0 14px rgba(200,168,75,0.4);
        }
 
        .step-dot.done {
            border-color: var(--olive);
            color: var(--gold);
            background: rgba(94,85,35,0.3);
        }
 
        .step-line {
            flex: 1; height: 1px;
            background: rgba(200,168,75,0.15);
            transition: background 0.4s ease;
        }
 
        .step-line.filled { background: rgba(200,168,75,0.4); }
 
        /* ===== FORM STEPS ===== */
        .form-step {
            display: none;
            animation: stepIn 0.5s ease forwards;
        }
 
        .form-step.active { display: block; }
 
        @keyframes stepIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
 
        /* ===== INPUT GROUP ===== */
        .input-group { margin-bottom: 18px; position: relative; }
 
        .input-label {
            display: block; font-size: 10px; letter-spacing: 2px;
            text-transform: uppercase; color: rgba(200,168,75,0.8);
            margin-bottom: 8px; font-weight: 600;
        }
 
        .input-wrapper { position: relative; }
 
        .input-wrapper .input-icon {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%); color: rgba(200,168,75,0.45);
            transition: color 0.3s; pointer-events: none;
        }
 
        .input-field {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(200,168,75,0.18);
            border-radius: 12px;
            padding: 13px 14px 13px 44px;
            font-family: 'Raleway', sans-serif;
            font-size: 14px; color: var(--cream); outline: none;
            transition: all 0.3s ease; letter-spacing: 0.5px;
        }
 
        .input-field::placeholder { color: rgba(245,240,232,0.22); }
 
        .input-field:focus {
            border-color: rgba(200,168,75,0.55);
            background: rgba(200,168,75,0.05);
            box-shadow: 0 0 0 3px rgba(200,168,75,0.07), 0 0 18px rgba(200,168,75,0.08);
        }
 
        .input-field.error {
            border-color: rgba(137,57,65,0.7);
            background: rgba(137,57,65,0.06);
        }
 
        .input-wrapper:focus-within .input-icon { color: var(--gold); }
 
        .pw-toggle {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: rgba(200,168,75,0.4); padding: 4px;
            transition: color 0.3s; display: flex; align-items: center;
        }
        .pw-toggle:hover { color: var(--gold); }
 
        /* OTP notice */
        .otp-notice {
            display: flex; align-items: center; gap: 8px;
            background: rgba(94,85,35,0.15);
            border: 1px solid rgba(200,168,75,0.2);
            border-radius: 10px; padding: 10px 14px;
            margin-top: 8px;
        }
 
        .otp-notice svg { flex-shrink: 0; color: var(--gold); }
 
        .otp-notice p {
            font-size: 11px; color: rgba(200,168,75,0.75);
            line-height: 1.5; letter-spacing: 0.3px;
        }
 
        /* Password strength */
        .pw-strength {
            margin-top: 8px;
            display: flex; gap: 4px; align-items: center;
        }
 
        .pw-strength-bar {
            flex: 1; height: 3px; border-radius: 2px;
            background: rgba(255,255,255,0.08);
            transition: background 0.3s;
        }
 
        .pw-strength-bar.weak { background: var(--crimson); }
        .pw-strength-bar.medium { background: var(--gold); }
        .pw-strength-bar.strong { background: #4caf50; }
 
        .pw-strength-label {
            font-size: 10px; letter-spacing: 1px;
            color: rgba(245,240,232,0.4); min-width: 50px;
            text-align: right; text-transform: uppercase;
        }
 
        /* ===== NAVIGATION BUTTONS ===== */
        .btn-row {
            display: flex; gap: 12px; margin-top: 24px;
        }
 
        .btn-next, .btn-prev, .btn-submit {
            flex: 1; padding: 14px;
            border: none; border-radius: 12px;
            font-family: 'Cinzel', serif; font-size: 13px;
            font-weight: 600; letter-spacing: 2px;
            text-transform: uppercase; cursor: pointer;
            position: relative; overflow: hidden;
            transition: all 0.3s ease;
        }
 
        .btn-next, .btn-submit {
            background: linear-gradient(135deg, var(--olive) 0%, var(--crimson) 100%);
            color: var(--cream);
            box-shadow: 0 4px 20px rgba(137,57,65,0.25), 0 4px 20px rgba(94,85,35,0.15);
        }
 
        .btn-next::before, .btn-submit::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, var(--olive-light) 0%, var(--crimson-light) 100%);
            opacity: 0; transition: opacity 0.3s;
        }
 
        .btn-next:hover::before, .btn-submit:hover::before { opacity: 1; }
 
        .btn-next span, .btn-submit span { position: relative; z-index: 1; }
 
        .btn-prev {
            background: transparent;
            border: 1px solid rgba(200,168,75,0.3);
            color: rgba(200,168,75,0.7);
        }
 
        .btn-prev:hover {
            border-color: var(--gold);
            color: var(--gold);
            background: rgba(200,168,75,0.05);
        }
 
        .btn-next:active, .btn-submit:active, .btn-prev:active {
            transform: scale(0.97);
        }
 
        /* ===== SHINE EFFECT ===== */
        .btn-next::after, .btn-submit::after {
            content: ''; position: absolute;
            top: -50%; left: -60%; width: 40%; height: 200%;
            background: rgba(255,255,255,0.13); transform: skewX(-20deg);
            transition: left 0.5s ease;
        }
        .btn-next:hover::after, .btn-submit:hover::after { left: 120%; }
 
        /* ===== DIVIDER ===== */
        .divider {
            display: flex; align-items: center; gap: 14px;
            margin: 20px 0;
        }
        .divider-line { flex: 1; height: 1px; background: linear-gradient(90deg, transparent, rgba(200,168,75,0.18), transparent); }
        .divider-text { font-size: 10px; color: rgba(245,240,232,0.28); letter-spacing: 2px; text-transform: uppercase; }
 
        /* ===== LOGIN LINK ===== */
        .login-row { text-align: center; }
        .login-row p { font-size: 13px; color: rgba(245,240,232,0.38); }
        .login-link {
            color: var(--gold); text-decoration: none;
            font-weight: 600; letter-spacing: 0.5px; position: relative; transition: color 0.2s;
        }
        .login-link::after {
            content: ''; position: absolute; bottom: -2px; left: 0;
            width: 0; height: 1px; background: var(--gold); transition: width 0.3s;
        }
        .login-link:hover::after { width: 100%; }
        .login-link:hover { color: #e8d08a; }
 
        /* ===== STAGGER ===== */
        .stagger-1 { animation: slideUp 0.6s ease 0.1s both; }
        .stagger-2 { animation: slideUp 0.6s ease 0.2s both; }
        .stagger-3 { animation: slideUp 0.6s ease 0.3s both; }
        .stagger-4 { animation: slideUp 0.6s ease 0.4s both; }
 
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
 
        /* ===== VALIDATION MSG ===== */
        .field-error {
            font-size: 11px; color: rgba(168,72,80,0.9);
            margin-top: 5px; padding-left: 4px; letter-spacing: 0.3px;
            display: none;
        }
 
        .field-error.show { display: block; }
    </style>
</head>
<body>
 
<!-- Background -->
<div class="bg-canvas">
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="bg-orb bg-orb-3"></div>
    <div class="bg-grid"></div>
</div>
<div id="particles"></div>
 
<!-- Main Content -->
<div class="page-wrapper">
    <div class="auth-card">
 
        <div class="corner-deco tl"></div>
        <div class="corner-deco tr"></div>
        <div class="corner-deco bl"></div>
        <div class="corner-deco br"></div>
 
        <!-- Logo -->
        <div class="logo-area stagger-1">
            <div class="logo-icon">
                <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <polygon points="32,6 58,52 6,52" fill="none" stroke="url(#goldGrad2)" stroke-width="2.5" stroke-linejoin="round"/>
                    <polygon points="32,18 46,52 18,52" fill="rgba(137,57,65,0.35)" stroke="none"/>
                    <line x1="32" y1="6" x2="32" y2="52" stroke="url(#goldGrad2)" stroke-width="1.5" stroke-dasharray="3 3" opacity="0.5"/>
                    <circle cx="16" cy="18" r="1.5" fill="url(#goldGrad2)" opacity="0.8"/>
                    <circle cx="48" cy="14" r="1" fill="#c8a84b" opacity="0.6"/>
                    <circle cx="10" cy="32" r="1" fill="#c8a84b" opacity="0.5"/>
                    <line x1="4" y1="52" x2="60" y2="52" stroke="url(#goldGrad2)" stroke-width="1.5" opacity="0.6"/>
                    <defs>
                        <linearGradient id="goldGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#893941"/>
                            <stop offset="50%" stop-color="#e8d08a"/>
                            <stop offset="100%" stop-color="#5E5523"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <h1 class="logo-title">CAMPLORE</h1>
            <p class="logo-tagline">CAMERA · CAMPING · EXPLORE</p>
        </div>
 
        <!-- Heading -->
        <div class="form-heading stagger-2">
            <h2>Buat Akun Baru</h2>
            <p>Bergabung dan mulai petualangan bersama kami</p>
        </div>
 
        <!-- Steps Bar -->
        <div class="steps-bar stagger-3" id="stepsBar">
            <div class="step-dot active" id="dot1">1</div>
            <div class="step-line" id="line1"></div>
            <div class="step-dot" id="dot2">2</div>
            <div class="step-line" id="line2"></div>
            <div class="step-dot" id="dot3">3</div>
        </div>
 
        <!-- REGISTER FORM -->
        <form action="/registrasi" method="POST" id="registerForm">
            @csrf
 
            <!-- STEP 1: Username -->
            <div class="form-step active" id="step1">
                <div class="input-group">
                    <label class="input-label" for="reg_username">Username</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        </svg>
                        <input type="text" id="reg_username" name="username" class="input-field"
                            placeholder="Pilih username unik Anda"
                            autocomplete="username"
                            value="{{ old('username') }}">
                    </div>
                    <p class="field-error" id="err_username">Username wajib diisi (min. 3 karakter)</p>
                </div>
 
                <div class="input-group">
                    <label class="input-label" for="reg_email">Email</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <input type="email" id="reg_email" name="email" class="input-field"
                            placeholder="email@anda.com"
                            autocomplete="email"
                            value="{{ old('email') }}">
                    </div>
                    <p class="field-error" id="err_email">Masukkan email yang valid</p>
                </div>
 
                <div class="btn-row">
                    <button type="button" class="btn-next" onclick="nextStep(1)">
                        <span>Selanjutnya →</span>
                    </button>
                </div>
            </div>
 
            <!-- STEP 2: Phone + OTP notice -->
            <div class="form-step" id="step2">
                <div class="input-group">
                    <label class="input-label" for="reg_phone">Nomor Telepon</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.64 19a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <input type="tel" id="reg_phone" name="phone" class="input-field"
                            placeholder="+62 8xx xxxx xxxx"
                            autocomplete="tel"
                            value="{{ old('phone') }}">
                    </div>
                    <p class="field-error" id="err_phone">Masukkan nomor telepon yang valid</p>
                </div>
 
                <!-- OTP Notice -->
                <div class="otp-notice">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.64 19a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                    <p>Kode OTP akan dikirimkan ke nomor telepon ini untuk verifikasi akun Anda.</p>
                </div>
 
                <div class="btn-row">
                    <button type="button" class="btn-prev" onclick="prevStep(2)">← Kembali</button>
                    <button type="button" class="btn-next" onclick="nextStep(2)">
                        <span>Selanjutnya →</span>
                    </button>
                </div>
            </div>
 
            <!-- STEP 3: Password -->
            <div class="form-step" id="step3">
                <div class="input-group">
                    <label class="input-label" for="reg_password">Password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" id="reg_password" name="password" class="input-field"
                            placeholder="Buat password yang kuat"
                            autocomplete="new-password"
                            oninput="checkStrength(this.value)">
                        <button type="button" class="pw-toggle" onclick="togglePassword('reg_password', this)" aria-label="Toggle password">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <!-- Strength indicator -->
                    <div class="pw-strength" id="pwStrength" style="display:none;">
                        <div class="pw-strength-bar" id="bar1"></div>
                        <div class="pw-strength-bar" id="bar2"></div>
                        <div class="pw-strength-bar" id="bar3"></div>
                        <div class="pw-strength-bar" id="bar4"></div>
                        <span class="pw-strength-label" id="pwLabel">—</span>
                    </div>
                    <p class="field-error" id="err_password">Password minimal 8 karakter</p>
                </div>
 
                <div class="input-group">
                    <label class="input-label" for="reg_password_confirm">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4"/>
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" id="reg_password_confirm" name="password_confirmation" class="input-field"
                            placeholder="Ulangi password Anda"
                            autocomplete="new-password">
                        <button type="button" class="pw-toggle" onclick="togglePassword('reg_password_confirm', this)" aria-label="Toggle confirm password">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <p class="field-error" id="err_confirm">Password tidak cocok</p>
                </div>
 
                <div class="btn-row">
                    <button type="button" class="btn-prev" onclick="prevStep(3)">← Kembali</button>
                    <button type="submit" class="btn-submit">
                        <span>Daftar Sekarang</span>
                    </button>
                </div>
            </div>
 
        </form>
 
        <!-- Divider -->
        <div class="divider" style="margin-top:24px;">
            <div class="divider-line"></div>
            <span class="divider-text">atau</span>
            <div class="divider-line"></div>
        </div>
 
        <!-- Login link -->
        <div class="login-row">
            <p>Sudah punya akun? <a href="/login" class="login-link">Masuk di sini</a></p>
        </div>
 
    </div>
</div>
 
<script>
    // Particles
    const container = document.getElementById('particles');
    for (let i = 0; i < 20; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        p.style.left = Math.random() * 100 + 'vw';
        p.style.animationDuration = (7 + Math.random() * 9) + 's';
        p.style.animationDelay = (Math.random() * 12) + 's';
        p.style.width = p.style.height = (1.5 + Math.random() * 2) + 'px';
        container.appendChild(p);
    }
 
    // Password toggle
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        btn.innerHTML = isPassword
            ? `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
            : `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
    }
 
    // Password strength
    function checkStrength(val) {
        const strength = document.getElementById('pwStrength');
        strength.style.display = val.length ? 'flex' : 'none';
        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;
 
        const bars = ['bar1','bar2','bar3','bar4'];
        const labels = ['', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];
        const classes = ['', 'weak', 'medium', 'strong', 'strong'];
 
        bars.forEach((id, i) => {
            const bar = document.getElementById(id);
            bar.className = 'pw-strength-bar';
            if (i < score) bar.classList.add(classes[score]);
        });
 
        document.getElementById('pwLabel').textContent = labels[score] || '—';
    }
 
    // Step navigation
    let currentStep = 1;
 
    function nextStep(from) {
        if (from === 1) {
            const username = document.getElementById('reg_username').value.trim();
            const email = document.getElementById('reg_email').value.trim();
            let valid = true;
 
            if (username.length < 3) {
                showError('err_username', 'reg_username'); valid = false;
            } else { hideError('err_username', 'reg_username'); }
 
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showError('err_email', 'reg_email'); valid = false;
            } else { hideError('err_email', 'reg_email'); }
 
            if (!valid) return;
        }
 
        if (from === 2) {
            const phone = document.getElementById('reg_phone').value.trim();
            if (phone.length < 9) {
                showError('err_phone', 'reg_phone'); return;
            } else { hideError('err_phone', 'reg_phone'); }
        }
 
        goToStep(from + 1);
    }
 
    function prevStep(from) { goToStep(from - 1); }
 
    function goToStep(n) {
        document.getElementById('step' + currentStep).classList.remove('active');
        currentStep = n;
        document.getElementById('step' + n).classList.add('active');
        updateSteps();
    }
 
    function updateSteps() {
        for (let i = 1; i <= 3; i++) {
            const dot = document.getElementById('dot' + i);
            dot.classList.remove('active', 'done');
            if (i < currentStep) dot.classList.add('done');
            else if (i === currentStep) dot.classList.add('active');
        }
        for (let i = 1; i <= 2; i++) {
            const line = document.getElementById('line' + i);
            line.classList.toggle('filled', i < currentStep);
        }
    }
 
    function showError(errId, inputId) {
        document.getElementById(errId).classList.add('show');
        document.getElementById(inputId).classList.add('error');
    }
 
    function hideError(errId, inputId) {
        document.getElementById(errId).classList.remove('show');
        document.getElementById(inputId).classList.remove('error');
    }
 
    // Final submit validation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const pw = document.getElementById('reg_password').value;
        const confirm = document.getElementById('reg_password_confirm').value;
        let valid = true;
 
        if (pw.length < 8) {
            showError('err_password', 'reg_password'); valid = false;
        } else { hideError('err_password', 'reg_password'); }
 
        if (pw !== confirm) {
            showError('err_confirm', 'reg_password_confirm'); valid = false;
        } else { hideError('err_confirm', 'reg_password_confirm'); }
 
        if (!valid) e.preventDefault();
    });
 
    // Ripple on buttons
    document.querySelectorAll('.btn-next, .btn-submit').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            ripple.style.cssText = `
                position:absolute;width:5px;height:5px;background:rgba(255,255,255,0.35);
                border-radius:50%;top:${e.clientY - rect.top - 2.5}px;
                left:${e.clientX - rect.left - 2.5}px;
                transform:scale(0);animation:ripple 0.6s ease forwards;pointer-events:none;z-index:2;
            `;
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    });
 
    const style = document.createElement('style');
    style.textContent = `@keyframes ripple { to { transform: scale(60); opacity: 0; } }`;
    document.head.appendChild(style);
</script>
</body>
</html>
 
