<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAMPLORE – Daftar</title>
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
            background: linear-gradient(150deg, var(--crimson) 0%, #3a1c1f 45%, var(--olive) 100%);
            display: flex; flex-direction: column;
            justify-content: center; align-items: flex-start;
            padding: 60px 64px; position: relative; overflow: hidden;
        }

        .left::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse at 20% 20%, rgba(255,255,255,0.07) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 80%, rgba(0,0,0,0.18) 0%, transparent 55%);
            pointer-events: none;
        }

        .deco-circle {
            position: absolute; border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.06); pointer-events: none;
        }
        .dc1 { width: 360px; height: 360px; top: -90px; left: -60px; }
        .dc2 { width: 200px; height: 200px; top: 40px; left: 80px; }
        .dc3 { width: 300px; height: 300px; bottom: -80px; right: -60px; }

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
            font-size: clamp(36px, 4vw, 50px);
            font-weight: 700; color: #fff;
            line-height: 1.2; margin-bottom: 22px;
        }

        .left-content h1 em {
            font-style: normal; color: rgba(255,255,255,0.4);
        }

        .left-content p {
            font-size: 14px; font-weight: 300;
            color: rgba(255,255,255,0.56);
            line-height: 1.75; max-width: 320px; letter-spacing: 0.3px;
        }

        .left-steps {
            margin-top: 44px; position: relative; z-index: 1;
        }

        .left-steps p {
            font-size: 10px; letter-spacing: 2px; text-transform: uppercase;
            color: rgba(255,255,255,0.35); margin-bottom: 16px; font-weight: 400;
        }

        .step-list { display: flex; flex-direction: column; gap: 10px; }

        .step-item {
            display: flex; align-items: center; gap: 12px;
        }

        .step-num {
            width: 22px; height: 22px; border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 500;
            color: rgba(255,255,255,0.55); flex-shrink: 0;
        }

        .step-num.active {
            background: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.5);
            color: #fff;
        }

        .step-label {
            font-size: 13px; color: rgba(255,255,255,0.5); font-weight: 300;
        }

        .step-label.active { color: rgba(255,255,255,0.85); }

        /* ── RIGHT ── */
        .right {
            width: 500px; flex-shrink: 0;
            background: #fff;
            display: flex; flex-direction: column;
            justify-content: center;
            padding: 52px 48px;
            box-shadow: -2px 0 30px rgba(0,0,0,0.06);
            overflow-y: auto;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 26px; font-weight: 600;
            color: var(--text-main); margin-bottom: 6px;
        }

        .form-sub {
            font-size: 13px; color: var(--text-sub);
            margin-bottom: 32px; font-weight: 300;
        }

        /* step dots */
        .step-bar {
            display: flex; align-items: center; gap: 0;
            margin-bottom: 30px;
        }

        .s-dot {
            width: 26px; height: 26px; border-radius: 50%;
            border: 1.5px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 500;
            color: #ccc; transition: all 0.3s;
            font-family: 'Playfair Display', serif;
        }

        .s-dot.active { background: var(--olive); border-color: var(--olive); color: #fff; }
        .s-dot.done { background: var(--cream); border-color: var(--olive-light); color: var(--olive-mid); }

        .s-line { flex: 1; height: 1.5px; background: var(--border); transition: background 0.3s; }
        .s-line.filled { background: var(--olive-light); }

        /* step labels */
        .step-labels {
            display: flex; justify-content: space-between;
            margin-top: -4px; margin-bottom: 26px;
        }
        .step-labels span {
            font-size: 10px; color: #ccc; letter-spacing: 0.5px;
            text-align: center; width: 26px;
        }
        .step-labels span.active { color: var(--olive-mid); }

        /* inputs */
        .field { margin-bottom: 18px; }

        .field label {
            display: block; font-size: 11px;
            letter-spacing: 1.5px; text-transform: uppercase;
            color: var(--text-sub); font-weight: 500; margin-bottom: 7px;
        }

        .input-wrap { position: relative; }

        .input-wrap .ico {
            position: absolute; left: 13px; top: 50%;
            transform: translateY(-50%); color: #ccc;
            transition: color 0.2s; pointer-events: none;
        }

        .input-wrap:focus-within .ico { color: var(--olive-mid); }

        .field input {
            width: 100%;
            padding: 12px 14px 12px 40px;
            border: 1.5px solid var(--border); border-radius: 8px;
            font-family: 'Lato', sans-serif;
            font-size: 14px; color: var(--text-main);
            background: var(--cream); outline: none;
            transition: border-color 0.2s, background 0.2s;
        }

        .field input::placeholder { color: #ccc8be; }

        .field input:focus {
            border-color: var(--olive-light); background: #fff;
        }

        .field input.error { border-color: var(--crimson); }

        .pw-btn {
            position: absolute; right: 11px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #ccc; display: flex; align-items: center;
            padding: 4px; transition: color 0.2s;
        }
        .pw-btn:hover { color: var(--olive-mid); }

        /* OTP notice */
        .otp-note {
            display: flex; align-items: flex-start; gap: 8px;
            background: #fdf8ee;
            border: 1px solid #e8dfc0;
            border-radius: 8px; padding: 10px 14px;
            margin-top: 6px;
        }
        .otp-note svg { flex-shrink: 0; margin-top: 1px; color: var(--olive-mid); }
        .otp-note p { font-size: 12px; color: var(--text-sub); line-height: 1.5; }

        /* strength */
        .pw-strength { display: flex; gap: 4px; align-items: center; margin-top: 7px; }
        .pw-bar { flex: 1; height: 3px; border-radius: 2px; background: var(--border); transition: background 0.3s; }
        .pw-bar.weak { background: var(--crimson); }
        .pw-bar.mid { background: #c8a84b; }
        .pw-bar.strong { background: #5a8a5a; }
        .pw-lbl { font-size: 10px; color: var(--text-sub); min-width: 52px; text-align: right; letter-spacing: 0.5px; }

        /* form steps */
        .form-step { display: none; }
        .form-step.active { display: block; }

        /* field error */
        .ferr {
            font-size: 11px; color: var(--crimson);
            margin-top: 4px; display: none; padding-left: 2px;
        }
        .ferr.show { display: block; }

        /* nav buttons */
        .btn-row { display: flex; gap: 10px; margin-top: 24px; }

        .btn-next, .btn-submit {
            flex: 1; padding: 13px;
            background: linear-gradient(135deg, var(--olive) 0%, var(--crimson) 100%);
            color: #fff; border: none; border-radius: 8px;
            font-family: 'Lato', sans-serif;
            font-size: 13px; font-weight: 500;
            letter-spacing: 2px; text-transform: uppercase;
            cursor: pointer; transition: opacity 0.2s, transform 0.1s;
        }
        .btn-next:hover, .btn-submit:hover { opacity: 0.88; }
        .btn-next:active, .btn-submit:active { transform: scale(0.99); }

        .btn-prev {
            flex: 0 0 auto; padding: 13px 18px;
            background: none;
            border: 1.5px solid var(--border); border-radius: 8px;
            font-family: 'Lato', sans-serif;
            font-size: 13px; color: var(--text-sub);
            cursor: pointer; transition: border-color 0.2s, color 0.2s;
        }
        .btn-prev:hover { border-color: var(--olive-light); color: var(--olive-mid); }

        /* divider */
        .divider { display: flex; align-items: center; gap: 12px; margin: 22px 0; }
        .divider-line { flex: 1; height: 1px; background: var(--border); }
        .divider span { font-size: 12px; color: #ccc8be; letter-spacing: 1px; }

        /* link */
        .alt-link { text-align: center; font-size: 13px; color: var(--text-sub); }
        .alt-link a { color: var(--olive); font-weight: 500; text-decoration: none; transition: color 0.2s; }
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
            <h1>Bergabung<br>bersama<br><em>kami.</em></h1>
            <p>Daftar dan mulai menyewa alat camping dan kamera yang anda butuhkan.</p>
        </div>

        <div class="left-steps">
            <p>Langkah pendaftaran</p>
            <div class="step-list">
                <div class="step-item">
                    <div class="step-num active">1</div>
                    <span class="step-label active">Informasi akun</span>
                </div>
                <div class="step-item">
                    <div class="step-num">2</div>
                    <span class="step-label">Nomor telepon</span>
                </div>
                <div class="step-item">
                    <div class="step-num">3</div>
                    <span class="step-label">Buat kata sandi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <h2 class="form-title">Daftar Sekarang</h2>
        <p class="form-sub">Isi data berikut untuk mendaftar</p>

        <!-- Step dots -->
        <div class="step-bar">
            <div class="s-dot active" id="dot1">1</div>
            <div class="s-line" id="ln1"></div>
            <div class="s-dot" id="dot2">2</div>
            <div class="s-line" id="ln2"></div>
            <div class="s-dot" id="dot3">3</div>
        </div>

        <form action="/registrasi" method="POST" id="regForm">
            @csrf

            <!-- STEP 1 -->
            <div class="form-step active" id="step1">
                <div class="field">
                    <label for="reg_username">Username</label>
                    <div class="input-wrap">
                        <svg class="ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        </svg>
                        <input type="text" id="reg_username" name="username"
                            placeholder="Pilih username unik Anda"
                            value="{{ old('username') }}" autocomplete="username">
                    </div>
                    <p class="ferr" id="e_username">Username minimal 3 karakter</p>
                </div>

                <div class="field">
                    <label for="reg_email">Email</label>
                    <div class="input-wrap">
                        <svg class="ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <input type="email" id="reg_email" name="email"
                            placeholder="email@anda.com"
                            value="{{ old('email') }}" autocomplete="email">
                    </div>
                    <p class="ferr" id="e_email">Masukkan email yang valid</p>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn-next" onclick="next(1)">Selanjutnya →</button>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="form-step" id="step2">
                <div class="field">
                    <label for="reg_phone">Nomor Telepon</label>
                    <div class="input-wrap">
                        <svg class="ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.64 19a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <input type="tel" id="reg_phone" name="phone"
                            placeholder="+62 8xx xxxx xxxx"
                            value="{{ old('phone') }}" autocomplete="tel">
                    </div>
                    <p class="ferr" id="e_phone">Masukkan nomor telepon yang valid</p>
                </div>

                <div class="otp-note">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <p>Kode OTP akan dikirimkan ke nomor ini untuk verifikasi akun Anda.</p>
                </div>

               
            <div class="field">
                <label for="reg_nik">NIK</label>
                <div class="input-wrap">
                    <svg class="ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="5" width="20" height="14" rx="2"/>
                        <line x1="2" y1="10" x2="22" y2="10"/>
                    </svg>
                    <input type="text" id="reg_nik" name="nik"
                        placeholder="Masukkan 16 digit NIK Anda"
                        value="{{ old('nik') }}"
                        maxlength="16"
                        inputmode="numeric">
                </div>
                <p class="ferr" id="e_nik">NIK harus 16 digit angka</p>
            </div>

                <div class="btn-row">
                    <button type="button" class="btn-prev" onclick="prev(2)">←</button>
                    <button type="button" class="btn-next" onclick="next(2)">Selanjutnya →</button>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="form-step" id="step3">
                <div class="field">
                    <label for="reg_pw">Kata Sandi</label>
                    <div class="input-wrap">
                        <svg class="ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" id="reg_pw" name="password"
                            placeholder="Buat kata sandi yang kuat"
                            oninput="checkStrength(this.value)" autocomplete="new-password">
                        <button type="button" class="pw-btn" onclick="togglePw('reg_pw',this)">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <div class="pw-strength" id="pwBar" style="display:none">
                        <div class="pw-bar" id="b1"></div>
                        <div class="pw-bar" id="b2"></div>
                        <div class="pw-bar" id="b3"></div>
                        <div class="pw-bar" id="b4"></div>
                        <span class="pw-lbl" id="pwLbl"></span>
                    </div>
                    <p class="ferr" id="e_pw">Kata sandi minimal 8 karakter</p>
                </div>

                <div class="field">
                    <label for="reg_pw2">Konfirmasi Kata Sandi</label>
                    <div class="input-wrap">
                        <svg class="ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" id="reg_pw2" name="password_confirmation"
                            placeholder="Ulangi kata sandi" autocomplete="new-password">
                        <button type="button" class="pw-btn" onclick="togglePw('reg_pw2',this)">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <p class="ferr" id="e_pw2">Kata sandi tidak cocok</p>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn-prev" onclick="prev(3)">←</button>
                    <button type="submit" class="btn-submit">Daftar Sekarang</button>
                </div>
            </div>

        </form>

        <div class="divider">
            <div class="divider-line"></div>
            <span>atau</span>
            <div class="divider-line"></div>
        </div>

        <p class="alt-link">Sudah punya akun? <a href="/login">Masuk di sini</a></p>
    </div>

</div>

<script>
let cur = 1;

function next(from) {
    if (from === 1) {
        const u = document.getElementById('reg_username').value.trim();
        const e = document.getElementById('reg_email').value.trim();
        let ok = true;
        if (u.length < 3) { show('e_username','reg_username'); ok=false; } else hide('e_username','reg_username');
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e)) { show('e_email','reg_email'); ok=false; } else hide('e_email','reg_email');
        if (!ok) return;
    }
    if (from === 2) {
        const p = document.getElementById('reg_phone').value.trim();
        if (p.length < 9) { show('e_phone','reg_phone'); return; } else hide('e_phone','reg_phone');
    }
    go(from + 1);
}

function prev(from) { go(from - 1); }

function go(n) {
    document.getElementById('step'+cur).classList.remove('active');
    cur = n;
    document.getElementById('step'+n).classList.add('active');
    updateDots();
    updateLeftSteps();
}

function updateDots() {
    for (let i=1; i<=3; i++) {
        const d = document.getElementById('dot'+i);
        d.classList.remove('active','done');
        if (i < cur) d.classList.add('done');
        else if (i === cur) d.classList.add('active');
    }
    for (let i=1; i<=2; i++) {
        document.getElementById('ln'+i).classList.toggle('filled', i < cur);
    }
}

function updateLeftSteps() {
    const nums = document.querySelectorAll('.step-num');
    const lbls = document.querySelectorAll('.step-label');
    nums.forEach((n,i) => { n.classList.toggle('active', i+1===cur); });
    lbls.forEach((l,i) => { l.classList.toggle('active', i+1===cur); });
}

function show(eid, iid) {
    document.getElementById(eid).classList.add('show');
    document.getElementById(iid).classList.add('error');
}
function hide(eid, iid) {
    document.getElementById(eid).classList.remove('show');
    document.getElementById(iid).classList.remove('error');
}

function checkStrength(v) {
    const bar = document.getElementById('pwBar');
    bar.style.display = v.length ? 'flex' : 'none';
    let s = 0;
    if (v.length >= 8) s++;
    if (/[A-Z]/.test(v)) s++;
    if (/[0-9]/.test(v)) s++;
    if (/[^A-Za-z0-9]/.test(v)) s++;
    const cls = ['','weak','weak','mid','strong'];
    const lbl = ['','Lemah','Cukup','Kuat','Sangat Kuat'];
    ['b1','b2','b3','b4'].forEach((id,i) => {
        const b = document.getElementById(id);
        b.className = 'pw-bar';
        if (i < s) b.classList.add(cls[s]);
    });
    document.getElementById('pwLbl').textContent = lbl[s] || '';
}

function togglePw(id, btn) {
    const el = document.getElementById(id);
    const show = el.type === 'password';
    el.type = show ? 'text' : 'password';
    btn.innerHTML = show
        ? `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
        : `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
}

document.getElementById('regForm').addEventListener('submit', function(e) {
    const pw = document.getElementById('reg_pw').value;
    const pw2 = document.getElementById('reg_pw2').value;
    let ok = true;
    if (pw.length < 8) { show('e_pw','reg_pw'); ok=false; } else hide('e_pw','reg_pw');
    if (pw !== pw2) { show('e_pw2','reg_pw2'); ok=false; } else hide('e_pw2','reg_pw2');
    if (!ok) e.preventDefault();
});
</script>
</body>
</html>