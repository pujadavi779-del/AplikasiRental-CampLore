<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAMPLORE – Daftar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --green:       #22543D;
            --green-mid:   #2d6b50;
            --green-light: #38856a;
            --pink:        #ED64A6;
            --gray-bg:     #f7f7f5;
            --border:      #e2e2de;
            --text:        #1a1a18;
            --text-sub:    #999990;
        }

        html, body {
            font-family: 'Jost', sans-serif;
            background: #fff; color: var(--text);
        }

        /* NAVBAR */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0;
            height: 58px;
            display: flex; align-items: center; justify-content: center;
            border-bottom: 1px solid var(--border);
            background: #fff; z-index: 100;
        }

        .nav-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 21px; font-weight: 700;
            letter-spacing: 6px; text-transform: uppercase;
            color: var(--green); text-decoration: none;
        }

        .nav-logo img {
            height: 200px;
            width: auto;
            display: block;
        }

        /* PAGE */
        .page {
            min-height: 100vh;
            display: flex; align-items: flex-start; justify-content: center;
            padding: 90px 20px 60px;
        }

        .card { width: 100%; max-width: 380px; padding-top: 20px; }

        .card-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 26px; font-weight: 600;
            letter-spacing: 3px; text-transform: uppercase;
            color: var(--green); text-align: center;
            margin-bottom: 8px;
        }

        .card-sub {
            text-align: center; font-size: 12px;
            font-weight: 300; color: var(--text-sub);
            letter-spacing: 0.3px; margin-bottom: 28px;
        }

        /* STEP BAR */
        .step-bar {
            display: flex; align-items: center;
            margin-bottom: 28px;
        }

        .s-dot {
            width: 24px; height: 24px; border-radius: 50%;
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 400; color: #ccc;
            font-family: 'Jost', sans-serif;
            flex-shrink: 0; transition: all 0.3s;
        }

        .s-dot.active { background: var(--green); border-color: var(--green); color: #fff; }
        .s-dot.done { border-color: var(--green-light); color: var(--green-mid); }

        .s-line { flex: 1; height: 1px; background: var(--border); transition: background 0.3s; }
        .s-line.filled { background: var(--green-light); }

        /* INPUTS */
        .field { margin-bottom: 12px; }

        .field label {
            display: block; font-size: 10px; font-weight: 500;
            letter-spacing: 1.5px; text-transform: uppercase;
            color: var(--text-sub); margin-bottom: 6px;
        }

        .field input {
            width: 100%; padding: 13px 16px;
            border: 1px solid var(--border); border-radius: 3px;
            font-family: 'Jost', sans-serif;
            font-size: 14px; font-weight: 300;
            color: var(--text); background: var(--gray-bg);
            outline: none; transition: border-color 0.2s, background 0.2s;
        }

        .field input::placeholder { color: #bebeba; }

        .field input:focus {
            border-color: var(--green-light); background: #fff;
        }

        .field input.err { border-color: #e53e3e; }

        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 42px; }

        .pw-btn {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #ccc; display: flex; padding: 0; transition: color 0.2s;
        }
        .pw-btn:hover { color: var(--green-mid); }

        /* OTP note */
        .otp-note {
            display: flex; align-items: flex-start; gap: 8px;
            background: #f0f7f4;
            border: 1px solid #c6dfd5;
            border-radius: 3px; padding: 10px 12px;
            margin-top: 6px;
        }
        .otp-note svg { flex-shrink: 0; margin-top: 1px; color: var(--green-mid); }
        .otp-note p { font-size: 12px; font-weight: 300; color: var(--green-mid); line-height: 1.5; }

        /* strength */
        .pw-strength { display: flex; gap: 3px; align-items: center; margin-top: 6px; }
        .pw-bar { flex: 1; height: 2px; border-radius: 2px; background: var(--border); transition: background 0.3s; }
        .pw-bar.weak { background: #fc8181; }
        .pw-bar.mid  { background: #f6ad55; }
        .pw-bar.strong { background: var(--green-light); }
        .pw-lbl { font-size: 10px; color: var(--text-sub); min-width: 55px; text-align: right; }

        /* field error */
        .ferr { font-size: 11px; color: #e53e3e; margin-top: 4px; display: none; }
        .ferr.show { display: block; }

        /* FORM STEPS */
        .form-step { display: none; }
        .form-step.active { display: block; }

        /* BUTTONS */
        .btn-row { display: flex; gap: 8px; margin-top: 16px; }

        .btn-next, .btn-submit {
            flex: 1; padding: 13px;
            background: var(--green); color: #fff;
            border: none; border-radius: 3px;
            font-family: 'Jost', sans-serif;
            font-size: 12px; font-weight: 500;
            letter-spacing: 3px; text-transform: uppercase;
            cursor: pointer; transition: background 0.2s;
        }
        .btn-next:hover, .btn-submit:hover { background: var(--green-mid); }

        .btn-submit {
            background: var(--pink);
        }
        .btn-submit:hover { background: #d4528f; }

        .btn-prev {
            flex: 0 0 auto; padding: 13px 16px;
            background: none;
            border: 1px solid var(--border); border-radius: 3px;
            font-family: 'Jost', sans-serif;
            font-size: 13px; color: var(--text-sub);
            cursor: pointer; transition: border-color 0.2s, color 0.2s;
        }
        .btn-prev:hover { border-color: var(--green-light); color: var(--green); }

        /* DIVIDER */
        .divider {
            display: flex; align-items: center; gap: 14px; margin: 24px 0;
        }
        .divider-line { flex: 1; height: 1px; background: var(--border); }
        .divider span { font-size: 11px; color: #d0d0cc; letter-spacing: 1.5px; text-transform: uppercase; }

        /* LOGIN LINK */
        .login-note { text-align: center; font-size: 12px; font-weight: 300; color: var(--text-sub); margin-bottom: 10px; }

        .btn-login-alt {
            display: block; width: 100%; padding: 13px;
            background: transparent; border: 1.5px solid var(--pink);
            border-radius: 3px;
            font-family: 'Jost', sans-serif;
            font-size: 12px; font-weight: 500;
            letter-spacing: 3px; text-transform: uppercase;
            color: var(--pink); text-align: center; text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }
        .btn-login-alt:hover { background: var(--pink); color: #fff; }

        /* FOOTER BAR */
        .footer-bar {
            position: fixed; bottom: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--green) 65%, var(--pink) 100%);
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="/" class="nav-logo">
        <img src="{{ asset('images/Black_Summer_Camp_Adventure_Logo-removebg-preview.png') }}" alt="Camplore Logo">
    </a>
</nav>

<div class="page">
    <div class="card">

        <h1 class="card-title">Buat Akun</h1>
        <p class="card-sub">Isi data berikut untuk mendaftar</p>

        <!-- Step bar -->
        <div class="step-bar">
            <div class="s-dot active" id="dot1">1</div>
            <div class="s-line" id="ln1"></div>
            <div class="s-dot" id="dot2">2</div>
            <div class="s-line" id="ln2"></div>
            <div class="s-dot" id="dot3">3</div>
        </div>

        <form action="/registrasi" method="POST" id="regForm">
            @csrf

            <!-- STEP 1: Username, NIK, Email -->
            <div class="form-step active" id="step1">

                <div class="field">
                    <label>Username</label>
                    <input type="text" id="reg_username" name="username"
                        placeholder="Pilih username unik"
                        value="{{ old('username') }}" autocomplete="username">
                    <p class="ferr" id="e_username">Username minimal 3 karakter</p>
                </div>

                <div class="field">
                    <label>NIK</label>
                    <input type="text" id="reg_nik" name="nik"
                        placeholder="16 digit NIK"
                        value="{{ old('nik') }}" maxlength="16" inputmode="numeric">
                    <p class="ferr" id="e_nik">NIK harus 16 digit angka</p>
                </div>

                <div class="field">
                    <label>Email</label>
                    <input type="email" id="reg_email" name="email"
                        placeholder="email@anda.com"
                        value="{{ old('email') }}" autocomplete="email">
                    <p class="ferr" id="e_email">Masukkan email yang valid</p>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn-next" onclick="next(1)">Selanjutnya →</button>
                </div>
            </div>

            <!-- STEP 2: Phone -->
            <div class="form-step" id="step2">

                <div class="field">
                    <label>Nomor Telepon</label>
                    <input type="tel" id="reg_phone" name="phone"
                        placeholder="+62 8xx xxxx xxxx"
                        value="{{ old('phone') }}" autocomplete="tel">
                    <p class="ferr" id="e_phone">Masukkan nomor telepon yang valid</p>
                </div>

                <div class="otp-note">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <p>Kode OTP akan dikirimkan ke nomor ini untuk verifikasi akun.</p>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn-prev" onclick="prev(2)">←</button>
                    <button type="button" class="btn-next" onclick="next(2)">Selanjutnya →</button>
                </div>
            </div>

            <!-- STEP 3: Password -->
            <div class="form-step" id="step3">

                <div class="field">
                    <label>Kata Sandi</label>
                    <div class="pw-wrap">
                        <input type="password" id="reg_pw" name="password"
                            placeholder="Buat kata sandi yang kuat"
                            oninput="checkStrength(this.value)"
                            autocomplete="new-password">
                        <button type="button" class="pw-btn" onclick="togglePw('reg_pw',this)">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
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
                    <label>Konfirmasi Kata Sandi</label>
                    <div class="pw-wrap">
                        <input type="password" id="reg_pw2" name="password_confirmation"
                            placeholder="Ulangi kata sandi"
                            autocomplete="new-password">
                        <button type="button" class="pw-btn" onclick="togglePw('reg_pw2',this)">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <p class="ferr" id="e_pw2">Kata sandi tidak cocok</p>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn-prev" onclick="prev(3)">←</button>
                    <button type="submit" class="btn-submit">Daftar</button>
                </div>
            </div>

        </form>

        <div class="divider">
            <div class="divider-line"></div>
            <span>atau</span>
            <div class="divider-line"></div>
        </div>

        <p class="login-note">Sudah punya akun?</p>
        <a href="/login" class="btn-login-alt">Masuk</a>

    </div>
</div>

<div class="footer-bar"></div>

<script>
let cur = 1;

function next(from) {
    if (from === 1) {
        const u = document.getElementById('reg_username').value.trim();
        const nik = document.getElementById('reg_nik').value.trim();
        const e = document.getElementById('reg_email').value.trim();
        let ok = true;
        if (u.length < 3) { err('e_username','reg_username'); ok=false; } else clr('e_username','reg_username');
        if (!/^\d{16}$/.test(nik)) { err('e_nik','reg_nik'); ok=false; } else clr('e_nik','reg_nik');
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e)) { err('e_email','reg_email'); ok=false; } else clr('e_email','reg_email');
        if (!ok) return;
    }
    if (from === 2) {
        const p = document.getElementById('reg_phone').value.trim();
        if (p.length < 9) { err('e_phone','reg_phone'); return; } else clr('e_phone','reg_phone');
    }
    go(from + 1);
}

function prev(from) { go(from - 1); }

function go(n) {
    document.getElementById('step'+cur).classList.remove('active');
    cur = n;
    document.getElementById('step'+n).classList.add('active');
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

function err(eid, iid) {
    document.getElementById(eid).classList.add('show');
    document.getElementById(iid).classList.add('err');
}
function clr(eid, iid) {
    document.getElementById(eid).classList.remove('show');
    document.getElementById(iid).classList.remove('err');
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
        ? `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
        : `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
}

document.getElementById('regForm').addEventListener('submit', function(e) {
    const pw = document.getElementById('reg_pw').value;
    const pw2 = document.getElementById('reg_pw2').value;
    let ok = true;
    if (pw.length < 8) { err('e_pw','reg_pw'); ok=false; } else clr('e_pw','reg_pw');
    if (pw !== pw2) { err('e_pw2','reg_pw2'); ok=false; } else clr('e_pw2','reg_pw2');
    if (!ok) e.preventDefault();
});
</script>


</body>
</html>