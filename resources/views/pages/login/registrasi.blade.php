<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        html, body { font-family: 'Jost', sans-serif; background: #fff; color: var(--text); }

        /* NAVBAR */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0;
            height: 58px;
            display: flex; align-items: center; justify-content: center;
            border-bottom: 1px solid var(--border);
            background: #fff; z-index: 100;
        }
        .nav-logo img { height: 200px; width: auto; display: block; }

        /* PAGE */
        .page { min-height: 100vh; display: flex; align-items: flex-start; justify-content: center; padding: 90px 20px 60px; }
        .card { width: 100%; max-width: 380px; padding-top: 20px; }

        .card-title { font-family: 'Cormorant Garamond', serif; font-size: 26px; font-weight: 600; letter-spacing: 3px; text-transform: uppercase; color: var(--green); text-align: center; margin-bottom: 8px; }
        .card-sub { text-align: center; font-size: 12px; font-weight: 300; color: var(--text-sub); letter-spacing: 0.3px; margin-bottom: 28px; }

        /* STEP BAR */
        .step-bar { display: flex; align-items: center; margin-bottom: 28px; }
        .s-dot { width: 24px; height: 24px; border-radius: 50%; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 11px; color: #ccc; flex-shrink: 0; transition: all 0.3s; }
        .s-dot.active { background: var(--green); border-color: var(--green); color: #fff; }
        .s-dot.done { border-color: var(--green-light); color: var(--green-mid); }
        .s-line { flex: 1; height: 1px; background: var(--border); transition: background 0.3s; }
        .s-line.filled { background: var(--green-light); }

        /* FORM STEPS */
        .form-step { display: none; }
        .form-step.active { display: block; }

        /* INPUTS */
        .field { margin-bottom: 12px; }
        .field label { display: block; font-size: 10px; font-weight: 500; letter-spacing: 1.5px; text-transform: uppercase; color: var(--text-sub); margin-bottom: 6px; }
        .field input { width: 100%; padding: 13px 16px; border: 1px solid var(--border); border-radius: 3px; font-family: 'Jost', sans-serif; font-size: 14px; font-weight: 300; color: var(--text); background: var(--gray-bg); outline: none; transition: border-color 0.2s, background 0.2s; }
        .field input::placeholder { color: #bebeba; }
        .field input:focus { border-color: var(--green-light); background: #fff; }
        .field input.err { border-color: #e53e3e; }
        .ferr { font-size: 11px; color: #e53e3e; margin-top: 4px; display: none; }
        .ferr.show { display: block; }

        /* PASSWORD */
        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 42px; }
        .pw-btn { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #ccc; display: flex; padding: 0; transition: color 0.2s; }
        .pw-btn:hover { color: var(--green-mid); }
        .pw-strength { display: flex; gap: 3px; align-items: center; margin-top: 6px; }
        .pw-bar { flex: 1; height: 2px; border-radius: 2px; background: var(--border); transition: background 0.3s; }
        .pw-bar.weak { background: #fc8181; }
        .pw-bar.mid  { background: #f6ad55; }
        .pw-bar.strong { background: var(--green-light); }
        .pw-lbl { font-size: 10px; color: var(--text-sub); min-width: 55px; text-align: right; }

        /* BUTTONS */
        .btn-row { display: flex; gap: 8px; margin-top: 16px; }
        .btn-next, .btn-submit { flex: 1; padding: 13px; background: var(--green); color: #fff; border: none; border-radius: 3px; font-family: 'Jost', sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 3px; text-transform: uppercase; cursor: pointer; transition: background 0.2s, opacity .2s; }
        .btn-next:hover { background: var(--green-mid); }
        .btn-next:disabled { opacity: .6; cursor: not-allowed; }
        .btn-submit { background: var(--pink); }
        .btn-submit:hover { background: #d4528f; }
        .btn-prev { flex: 0 0 auto; padding: 13px 16px; background: none; border: 1px solid var(--border); border-radius: 3px; font-family: 'Jost', sans-serif; font-size: 13px; color: var(--text-sub); cursor: pointer; transition: border-color 0.2s; }
        .btn-prev:hover { border-color: var(--green-light); color: var(--green); }

        /* OTP SECTION */
        .otp-sent-info { background: #f0f7f4; border: 1px solid #c6dfd5; border-radius: 4px; padding: 11px 14px; margin-bottom: 14px; font-size: 13px; color: var(--green-mid); line-height: 1.6; }
        .otp-sent-info strong { color: var(--green); }

        .otp-boxes { display: flex; gap: 10px; justify-content: center; margin: 14px 0; }
        .otp-boxes input { width: 46px; height: 54px; text-align: center; font-size: 22px; font-weight: 500; border: 1.5px solid var(--border); border-radius: 5px; font-family: 'Jost', sans-serif; background: var(--gray-bg); color: var(--text); outline: none; transition: border-color .2s; }
        .otp-boxes input:focus { border-color: var(--green-light); background: #fff; }
        .otp-boxes input.filled { border-color: var(--green-mid); }
        .otp-boxes input.err { border-color: #e53e3e; }

        .timer-row { display: flex; align-items: center; justify-content: space-between; margin-top: 8px; }
        .timer-badge { display: flex; align-items: center; gap: 5px; font-size: 12px; color: var(--text-sub); }
        #timer_num { font-weight: 500; color: var(--green); transition: color .3s; }
        #timer_num.danger { color: #e53e3e; }
        .timer-bar-wrap { height: 3px; background: var(--border); border-radius: 2px; margin-top: 8px; overflow: hidden; }
        #timer_bar { height: 3px; background: var(--green); border-radius: 2px; width: 100%; transition: width 1s linear, background .3s; }

        .resend-btn { font-size: 12px; background: none; border: none; cursor: pointer; color: var(--text-sub); padding: 0; font-family: 'Jost', sans-serif; }
        .resend-btn:not(:disabled) { color: var(--green); text-decoration: underline; cursor: pointer; }
        .resend-btn:disabled { cursor: default; }

        /* ALERT */
        .alert { padding: 10px 14px; border-radius: 3px; font-size: 12px; margin-bottom: 10px; display: none; }
        .alert.show { display: block; }
        .alert-err { background: #fff5f5; border: 1px solid #fed7d7; color: #c53030; }
        .alert-ok  { background: #f0fff4; border: 1px solid #c6f6d5; color: #276749; }

        /* DIVIDER */
        .divider { display: flex; align-items: center; gap: 14px; margin: 24px 0; }
        .divider-line { flex: 1; height: 1px; background: var(--border); }
        .divider span { font-size: 11px; color: #d0d0cc; letter-spacing: 1.5px; text-transform: uppercase; }

        .login-note { text-align: center; font-size: 12px; font-weight: 300; color: var(--text-sub); margin-bottom: 10px; }
        .btn-login-alt { display: block; width: 100%; padding: 13px; background: transparent; border: 1.5px solid var(--pink); border-radius: 3px; font-family: 'Jost', sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 3px; text-transform: uppercase; color: var(--pink); text-align: center; text-decoration: none; transition: background .2s, color .2s; }
        .btn-login-alt:hover { background: var(--pink); color: #fff; }

        .footer-bar { position: fixed; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--green) 65%, var(--pink) 100%); }
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

        <!-- Step bar (4 step) -->
        <div class="step-bar">
            <div class="s-dot active" id="dot1">1</div>
            <div class="s-line" id="ln1"></div>
            <div class="s-dot" id="dot2">2</div>
            <div class="s-line" id="ln2"></div>
            <div class="s-dot" id="dot3">3</div>
            <div class="s-line" id="ln3"></div>
            <div class="s-dot" id="dot4">4</div>
        </div>

        {{-- Server-side error (step 1 / final submit) --}}
        @if ($errors->any())
            <div class="alert alert-err show">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST" id="regForm">
            @csrf

            <!-- ============================================================
                 STEP 1 – Identitas
            ============================================================ -->
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
                    <button type="button" class="btn-next" id="btn_step1" onclick="goToOtp()">Selanjutnya →</button>
                </div>
            </div>

            <!-- ============================================================
                 STEP 2 – Verifikasi OTP Email
            ============================================================ -->
            <div class="form-step" id="step2">

                <div class="otp-sent-info">
                    Kode OTP dikirim ke email<br>
                    <strong id="show_email">—</strong>
                </div>

                <div class="alert alert-err" id="otp_alert_err"></div>
                <div class="alert alert-ok"  id="otp_alert_ok"></div>

                <p style="font-size:12px;color:var(--text-sub);text-align:center;margin-bottom:8px;">
                    Masukkan 6 digit kode OTP
                </p>

                <div class="otp-boxes">
                    <input type="text" maxlength="1" inputmode="numeric" class="otp-digit" id="d0">
                    <input type="text" maxlength="1" inputmode="numeric" class="otp-digit" id="d1">
                    <input type="text" maxlength="1" inputmode="numeric" class="otp-digit" id="d2">
                    <input type="text" maxlength="1" inputmode="numeric" class="otp-digit" id="d3">
                    <input type="text" maxlength="1" inputmode="numeric" class="otp-digit" id="d4">
                    <input type="text" maxlength="1" inputmode="numeric" class="otp-digit" id="d5">
                </div>

                <div class="timer-row">
                    <div class="timer-badge">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Berlaku &nbsp;<span id="timer_num">60</span>s
                    </div>
                    <button type="button" class="resend-btn" id="resend_btn" disabled onclick="resendOtp()">
                        Kirim ulang
                    </button>
                </div>
                <div class="timer-bar-wrap"><div id="timer_bar"></div></div>

                <div class="btn-row">
                    <button type="button" class="btn-prev" onclick="prevStep(2)">←</button>
                    <button type="button" class="btn-next" id="btn_verify" onclick="doVerifyOtp()">Verifikasi →</button>
                </div>
            </div>

            <!-- ============================================================
                 STEP 3 – Password
            ============================================================ -->
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
                    <button type="button" class="btn-prev" onclick="prevStep(3)">←</button>
                    <button type="button" class="btn-next" onclick="nextStep(3)">Selanjutnya →</button>
                </div>
            </div>

            <!-- ============================================================
                 STEP 4 – Konfirmasi & Daftar
            ============================================================ -->
            <div class="form-step" id="step4">
                <p style="font-size:13px;color:var(--text-sub);margin-bottom:16px;line-height:1.7;">
                    Periksa kembali data kamu sebelum mendaftar.
                </p>

                <div style="background:var(--gray-bg);border:1px solid var(--border);border-radius:4px;padding:14px 16px;margin-bottom:16px;font-size:13px;line-height:2;">
                    <div><span style="color:var(--text-sub);min-width:110px;display:inline-block;">Username</span> <strong id="sum_username">—</strong></div>
                    <div><span style="color:var(--text-sub);min-width:110px;display:inline-block;">NIK</span> <strong id="sum_nik">—</strong></div>
                    <div><span style="color:var(--text-sub);min-width:110px;display:inline-block;">Email</span> <strong id="sum_email">—</strong></div>
                    <div>
                        <span style="color:var(--text-sub);min-width:110px;display:inline-block;">Email</span>
                        <span style="font-size:11px;background:#e6f7ef;color:var(--green);padding:2px 8px;border-radius:20px;">✓ Terverifikasi</span>
                    </div>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn-prev" onclick="prevStep(4)">←</button>
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
let timerInterval = null;
let timerLeft = 60;

// ── Step navigation ────────────────────────────────────────────────────────
function goStep(n) {
    document.getElementById('step' + cur).classList.remove('active');
    cur = n;
    document.getElementById('step' + n).classList.add('active');
    for (let i = 1; i <= 4; i++) {
        const d = document.getElementById('dot' + i);
        d.classList.remove('active', 'done');
        if (i < cur) d.classList.add('done');
        else if (i === cur) d.classList.add('active');
    }
    for (let i = 1; i <= 3; i++) {
        const l = document.getElementById('ln' + i);
        if (l) l.classList.toggle('filled', i < cur);
    }
}

function nextStep(from) {
    if (from === 3) {
        const pw  = document.getElementById('reg_pw').value;
        const pw2 = document.getElementById('reg_pw2').value;
        let ok = true;
        if (pw.length < 8) { showErr('e_pw', 'reg_pw'); ok = false; } else clrErr('e_pw', 'reg_pw');
        if (pw !== pw2)    { showErr('e_pw2', 'reg_pw2'); ok = false; } else clrErr('e_pw2', 'reg_pw2');
        if (!ok) return;

        // Isi ringkasan step 4
        document.getElementById('sum_username').textContent = document.getElementById('reg_username').value;
        document.getElementById('sum_nik').textContent      = document.getElementById('reg_nik').value;
        document.getElementById('sum_email').textContent    = document.getElementById('reg_email').value;
        goStep(4);
    }
}

function prevStep(from) {
    if (from === 2) { clearInterval(timerInterval); }
    goStep(from - 1);
}

// ── Step 1 → OTP: validasi lalu kirim OTP via AJAX ────────────────────────
async function goToOtp() {
    const u   = document.getElementById('reg_username').value.trim();
    const nik = document.getElementById('reg_nik').value.trim();
    const e   = document.getElementById('reg_email').value.trim();
    let ok = true;

    if (u.length < 3)                              { showErr('e_username', 'reg_username'); ok = false; } else clrErr('e_username', 'reg_username');
    if (!/^\d{16}$/.test(nik))                     { showErr('e_nik', 'reg_nik'); ok = false; }          else clrErr('e_nik', 'reg_nik');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e))    { showErr('e_email', 'reg_email'); ok = false; }       else clrErr('e_email', 'reg_email');
    if (!ok) return;

    const btn = document.getElementById('btn_step1');
    btn.disabled = true;
    btn.textContent = 'Mengirim OTP…';

    try {
        const res = await fetch('{{ route("otp.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ email: e }),
        });

        const data = await res.json();

        if (!res.ok || !data.success) {
            showErr('e_email', 'reg_email');
            document.getElementById('e_email').textContent = data.message || 'Gagal mengirim OTP.';
            document.getElementById('e_email').classList.add('show');
            return;
        }

        document.getElementById('show_email').textContent = e;
        clrErr('e_email', 'reg_email');
        goStep(2);
        startTimer();

    } catch (err) {
        alert('Terjadi kesalahan koneksi. Coba lagi.');
    } finally {
        btn.disabled = false;
        btn.textContent = 'Selanjutnya →';
    }
}

// ── Verifikasi OTP via AJAX ────────────────────────────────────────────────
async function doVerifyOtp() {
    const digits = Array.from(document.querySelectorAll('.otp-digit')).map(i => i.value).join('');
    const email  = document.getElementById('reg_email').value.trim();

    hideAlert('otp_alert_err');
    hideAlert('otp_alert_ok');

    if (digits.length < 6) {
        showAlert('otp_alert_err', 'Masukkan semua 6 digit kode OTP.');
        return;
    }
    if (timerLeft <= 0) {
        showAlert('otp_alert_err', 'Kode OTP sudah kedaluwarsa. Klik "Kirim ulang".');
        return;
    }

    const btn = document.getElementById('btn_verify');
    btn.disabled = true;
    btn.textContent = 'Memverifikasi…';

    try {
        const res = await fetch('{{ route("otp.verify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ email: email, otp: digits }),
        });

        const data = await res.json();

        if (!res.ok || !data.success) {
            showAlert('otp_alert_err', data.message || 'Kode OTP salah.');
            document.querySelectorAll('.otp-digit').forEach(i => {
                i.classList.add('err');
                setTimeout(() => i.classList.remove('err'), 1200);
            });
            return;
        }

        clearInterval(timerInterval);
        showAlert('otp_alert_ok', 'Email berhasil diverifikasi! ✓');
        setTimeout(() => goStep(3), 800);

    } catch (err) {
        showAlert('otp_alert_err', 'Terjadi kesalahan koneksi. Coba lagi.');
    } finally {
        btn.disabled = false;
        btn.textContent = 'Verifikasi →';
    }
}

// ── Kirim ulang OTP ───────────────────────────────────────────────────────
async function resendOtp() {
    const email = document.getElementById('reg_email').value.trim();
    hideAlert('otp_alert_err');
    hideAlert('otp_alert_ok');

    try {
        const res = await fetch('{{ route("otp.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ email: email }),
        });
        const data = await res.json();
        if (!res.ok || !data.success) {
            showAlert('otp_alert_err', data.message || 'Gagal mengirim ulang OTP.');
            return;
        }
        document.querySelectorAll('.otp-digit').forEach(i => { i.value = ''; i.classList.remove('filled'); });
        showAlert('otp_alert_ok', 'Kode OTP baru telah dikirim.');
        startTimer();
    } catch (err) {
        showAlert('otp_alert_err', 'Terjadi kesalahan koneksi.');
    }
}

// ── Timer ─────────────────────────────────────────────────────────────────
function startTimer() {
    clearInterval(timerInterval);
    timerLeft = 60;
    document.getElementById('resend_btn').disabled = true;
    updateTimerUI();
    timerInterval = setInterval(() => {
        timerLeft--;
        updateTimerUI();
        if (timerLeft <= 0) {
            clearInterval(timerInterval);
            document.getElementById('resend_btn').disabled = false;
        }
    }, 1000);
}

function updateTimerUI() {
    const el  = document.getElementById('timer_num');
    const bar = document.getElementById('timer_bar');
    el.textContent = timerLeft;
    el.className   = timerLeft <= 10 ? 'danger' : '';
    const pct = Math.round((timerLeft / 60) * 100);
    bar.style.width    = pct + '%';
    bar.style.background = timerLeft <= 10 ? '#e53e3e' : timerLeft <= 20 ? '#f6ad55' : '#22543D';
}

// ── OTP box auto-focus ─────────────────────────────────────────────────────
document.querySelectorAll('.otp-digit').forEach((inp, i, arr) => {
    inp.addEventListener('input', () => {
        const v = inp.value.replace(/\D/g, '');
        inp.value = v;
        inp.classList.toggle('filled', v !== '');
        if (v && i < arr.length - 1) arr[i + 1].focus();
    });
    inp.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !inp.value && i > 0) arr[i - 1].focus();
    });
    inp.addEventListener('paste', e => {
        e.preventDefault();
        const txt = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
        txt.split('').slice(0, 6).forEach((ch, j) => {
            if (arr[i + j]) { arr[i + j].value = ch; arr[i + j].classList.add('filled'); }
        });
        arr[Math.min(i + txt.length, 5)].focus();
    });
});

// ── Password strength ─────────────────────────────────────────────────────
function checkStrength(v) {
    const bar = document.getElementById('pwBar');
    bar.style.display = v.length ? 'flex' : 'none';
    let s = 0;
    if (v.length >= 8)          s++;
    if (/[A-Z]/.test(v))        s++;
    if (/[0-9]/.test(v))        s++;
    if (/[^A-Za-z0-9]/.test(v)) s++;
    const cls = ['', 'weak', 'weak', 'mid', 'strong'];
    const lbl = ['', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
    ['b1','b2','b3','b4'].forEach((id, i) => {
        const b = document.getElementById(id);
        b.className = 'pw-bar';
        if (i < s) b.classList.add(cls[s]);
    });
    document.getElementById('pwLbl').textContent = lbl[s] || '';
}

function togglePw(id, btn) {
    const el   = document.getElementById(id);
    const show = el.type === 'password';
    el.type    = show ? 'text' : 'password';
    btn.innerHTML = show
        ? `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
        : `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
}

// ── Helpers ───────────────────────────────────────────────────────────────
function showErr(eid, iid) {
    document.getElementById(eid).classList.add('show');
    if (iid) document.getElementById(iid).classList.add('err');
}
function clrErr(eid, iid) {
    document.getElementById(eid).classList.remove('show');
    if (iid) document.getElementById(iid).classList.remove('err');
}
function showAlert(id, msg) {
    const el = document.getElementById(id);
    el.textContent = msg;
    el.classList.add('show');
}
function hideAlert(id) {
    document.getElementById(id).classList.remove('show');
}
</script>

</body>
</html>