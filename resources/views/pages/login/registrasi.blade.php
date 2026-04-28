<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CAMPLORE – Daftar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body class="font-['Jost',sans-serif] bg-white text-[#1a1a18]">

{{-- NAVBAR --}}
<nav class="fixed top-0 left-0 right-0 h-[58px] flex items-center justify-center border-b border-[#e2e2de] bg-white z-[100]">
    <a href="/">
        <img src="{{ asset('images/Black_Summer_Camp_Adventure_Logo-removebg-preview.png') }}" alt="Camplore Logo" class="h-[200px] w-auto block">
    </a>
</nav>

{{-- PAGE --}}
<div class="min-h-screen flex items-start justify-center px-5 pt-[90px] pb-[60px]">
    <div class="w-full max-w-[380px] pt-5">

        <h1 class="font-['Cormorant_Garamond',serif] text-[26px] font-semibold tracking-[3px] uppercase text-[#22543D] text-center mb-2">Buat Akun</h1>
        <p class="text-center text-xs font-light text-[#999990] tracking-[0.3px] mb-7">Isi data berikut untuk mendaftar</p>

        {{-- STEP BAR --}}
        <div class="flex items-center mb-7">
            <div class="w-6 h-6 rounded-full border flex items-center justify-center text-[11px] shrink-0 transition-all bg-[#22543D] border-[#22543D] text-white" id="dot1">1</div>
            <div class="flex-1 h-px bg-[#e2e2de] transition-all" id="ln1"></div>
            <div class="w-6 h-6 rounded-full border border-[#e2e2de] flex items-center justify-center text-[11px] text-[#ccc] shrink-0 transition-all" id="dot2">2</div>
            <div class="flex-1 h-px bg-[#e2e2de] transition-all" id="ln2"></div>
            <div class="w-6 h-6 rounded-full border border-[#e2e2de] flex items-center justify-center text-[11px] text-[#ccc] shrink-0 transition-all" id="dot3">3</div>
            <div class="flex-1 h-px bg-[#e2e2de] transition-all" id="ln3"></div>
            <div class="w-6 h-6 rounded-full border border-[#e2e2de] flex items-center justify-center text-[11px] text-[#ccc] shrink-0 transition-all" id="dot4">4</div>
        </div>

        {{-- Server-side error --}}
        @if ($errors->any())
            <div class="px-3.5 py-2.5 rounded text-xs bg-[#fff5f5] border border-[#fed7d7] text-[#c53030] mb-3">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST" id="regForm" onsubmit="return false;">
            @csrf

            {{-- ============ STEP 1 – Identitas ============ --}}
            <div class="block" id="step1">

                <div class="mb-3">
                    <label class="block text-[10px] font-medium tracking-[1.5px] uppercase text-[#999990] mb-1.5">Username</label>
                    <input type="text" id="reg_username" name="username"
                        placeholder="Pilih username unik"
                        value="{{ old('username') }}" autocomplete="username"
                        class="w-full px-4 py-3 border border-[#e2e2de] rounded-[3px] text-sm font-light text-[#1a1a18] bg-[#f7f7f5] outline-none transition focus:border-[#38856a] focus:bg-white placeholder-[#bebeba]">
                    <p class="hidden text-[11px] text-red-600 mt-1" id="e_username">Username minimal 3 karakter</p>
                </div>

                <div class="mb-3">
                    <label class="block text-[10px] font-medium tracking-[1.5px] uppercase text-[#999990] mb-1.5">NIK</label>
                    <input type="text" id="reg_nik" name="nik"
                        placeholder="16 digit NIK"
                        value="{{ old('nik') }}" maxlength="16" inputmode="numeric"
                        class="w-full px-4 py-3 border border-[#e2e2de] rounded-[3px] text-sm font-light text-[#1a1a18] bg-[#f7f7f5] outline-none transition focus:border-[#38856a] focus:bg-white placeholder-[#bebeba]">
                    <p class="hidden text-[11px] text-red-600 mt-1" id="e_nik">NIK harus 16 digit angka</p>
                </div>

                <div class="mb-3">
                    <label class="block text-[10px] font-medium tracking-[1.5px] uppercase text-[#999990] mb-1.5">Email</label>
                    <input type="email" id="reg_email" name="email"
                        placeholder="email@anda.com"
                        value="{{ old('email') }}" autocomplete="email"
                        class="w-full px-4 py-3 border border-[#e2e2de] rounded-[3px] text-sm font-light text-[#1a1a18] bg-[#f7f7f5] outline-none transition focus:border-[#38856a] focus:bg-white placeholder-[#bebeba]">
                    <p class="hidden text-[11px] text-red-600 mt-1" id="e_email">Masukkan email yang valid</p>
                </div>

                <div class="flex gap-2 mt-4">
                    <button type="button" id="btn_step1" onclick="goToOtp()"
                        class="flex-1 py-3 bg-[#22543D] text-white border-none rounded-[3px] text-xs font-medium tracking-[3px] uppercase cursor-pointer hover:bg-[#2d6b50] disabled:opacity-60 disabled:cursor-not-allowed transition">
                        Selanjutnya →
                    </button>
                </div>
            </div>

            {{-- ============ STEP 2 – Verifikasi OTP ============ --}}
            <div class="hidden" id="step2">

                {{-- Info OTP --}}
                <div class="bg-[#f0f7f4] border border-[#c6dfd5] rounded-[4px] px-3.5 py-3 mb-3.5 text-[13px] text-[#2d6b50] leading-relaxed">
                    Kode OTP dikirim ke email<br>
                    <strong class="text-[#22543D]" id="show_email">—</strong>
                </div>

                {{-- Alert --}}
                <div class="hidden px-3.5 py-2.5 rounded text-xs bg-[#fff5f5] border border-[#fed7d7] text-[#c53030] mb-2.5" id="otp_alert_err"></div>
                <div class="hidden px-3.5 py-2.5 rounded text-xs bg-[#f0fff4] border border-[#c6f6d5] text-[#276749] mb-2.5" id="otp_alert_ok"></div>

                <p class="text-xs text-[#999990] text-center mb-2">Masukkan 6 digit kode OTP</p>

                {{-- OTP Boxes --}}
                <div class="flex gap-2.5 justify-center my-3.5">
                    <input type="text" maxlength="1" inputmode="numeric" id="d0"
                        class="otp-digit w-[46px] h-[54px] text-center text-[22px] font-medium border-[1.5px] border-[#e2e2de] rounded-[5px] bg-[#f7f7f5] text-[#1a1a18] outline-none transition focus:border-[#38856a] focus:bg-white">
                    <input type="text" maxlength="1" inputmode="numeric" id="d1"
                        class="otp-digit w-[46px] h-[54px] text-center text-[22px] font-medium border-[1.5px] border-[#e2e2de] rounded-[5px] bg-[#f7f7f5] text-[#1a1a18] outline-none transition focus:border-[#38856a] focus:bg-white">
                    <input type="text" maxlength="1" inputmode="numeric" id="d2"
                        class="otp-digit w-[46px] h-[54px] text-center text-[22px] font-medium border-[1.5px] border-[#e2e2de] rounded-[5px] bg-[#f7f7f5] text-[#1a1a18] outline-none transition focus:border-[#38856a] focus:bg-white">
                    <input type="text" maxlength="1" inputmode="numeric" id="d3"
                        class="otp-digit w-[46px] h-[54px] text-center text-[22px] font-medium border-[1.5px] border-[#e2e2de] rounded-[5px] bg-[#f7f7f5] text-[#1a1a18] outline-none transition focus:border-[#38856a] focus:bg-white">
                    <input type="text" maxlength="1" inputmode="numeric" id="d4"
                        class="otp-digit w-[46px] h-[54px] text-center text-[22px] font-medium border-[1.5px] border-[#e2e2de] rounded-[5px] bg-[#f7f7f5] text-[#1a1a18] outline-none transition focus:border-[#38856a] focus:bg-white">
                    <input type="text" maxlength="1" inputmode="numeric" id="d5"
                        class="otp-digit w-[46px] h-[54px] text-center text-[22px] font-medium border-[1.5px] border-[#e2e2de] rounded-[5px] bg-[#f7f7f5] text-[#1a1a18] outline-none transition focus:border-[#38856a] focus:bg-white">
                </div>

                {{-- Timer --}}
                <div class="flex items-center justify-between mt-2">
                    <div class="flex items-center gap-1.5 text-xs text-[#999990]">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Berlaku &nbsp;<span id="timer_num" class="font-medium text-[#22543D]">60</span>s
                    </div>
                    <button type="button" id="resend_btn" disabled onclick="resendOtp()"
                        class="text-xs bg-none border-none cursor-default text-[#999990] font-['Jost'] disabled:cursor-default enabled:text-[#22543D] enabled:underline enabled:cursor-pointer">
                        Kirim ulang
                    </button>
                </div>

                {{-- Timer bar --}}
                <div class="h-[3px] bg-[#e2e2de] rounded-sm mt-2 overflow-hidden">
                    <div id="timer_bar" class="h-[3px] bg-[#22543D] rounded-sm w-full transition-all"></div>
                </div>

                <div class="flex gap-2 mt-4">
                    <button type="button" id="btn_verify" onclick="doVerifyOtp()"
                        class="flex-1 py-3 bg-[#22543D] text-white border-none rounded-[3px] text-xs font-medium tracking-[3px] uppercase cursor-pointer hover:bg-[#2d6b50] disabled:opacity-60 disabled:cursor-not-allowed transition">
                        Verifikasi →
                    </button>
                </div>
            </div>

            {{-- ============ STEP 3 – Password ============ --}}
            <div class="hidden" id="step3">

                <div class="mb-3">
                    <label class="block text-[10px] font-medium tracking-[1.5px] uppercase text-[#999990] mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" id="reg_pw" name="password"
                            placeholder="Buat kata sandi yang kuat"
                            oninput="checkStrength(this.value)"
                            autocomplete="new-password"
                            class="w-full px-4 py-3 pr-10 border border-[#e2e2de] rounded-[3px] text-sm font-light text-[#1a1a18] bg-[#f7f7f5] outline-none transition focus:border-[#38856a] focus:bg-white placeholder-[#bebeba]">
                        <button type="button" onclick="togglePw('reg_pw',this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-none cursor-pointer text-[#ccc] hover:text-[#2d6b50] transition p-0">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    {{-- Password strength --}}
                    <div class="hidden flex gap-1 items-center mt-1.5" id="pwBar">
                        <div class="flex-1 h-[2px] rounded-sm bg-[#e2e2de]" id="b1"></div>
                        <div class="flex-1 h-[2px] rounded-sm bg-[#e2e2de]" id="b2"></div>
                        <div class="flex-1 h-[2px] rounded-sm bg-[#e2e2de]" id="b3"></div>
                        <div class="flex-1 h-[2px] rounded-sm bg-[#e2e2de]" id="b4"></div>
                        <span class="text-[10px] text-[#999990] min-w-[55px] text-right" id="pwLbl"></span>
                    </div>
                    <p class="hidden text-[11px] text-red-600 mt-1" id="e_pw">Kata sandi minimal 8 karakter</p>
                </div>

                <div class="mb-3">
                    <label class="block text-[10px] font-medium tracking-[1.5px] uppercase text-[#999990] mb-1.5">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input type="password" id="reg_pw2" name="password_confirmation"
                            placeholder="Ulangi kata sandi"
                            autocomplete="new-password"
                            class="w-full px-4 py-3 pr-10 border border-[#e2e2de] rounded-[3px] text-sm font-light text-[#1a1a18] bg-[#f7f7f5] outline-none transition focus:border-[#38856a] focus:bg-white placeholder-[#bebeba]">
                        <button type="button" onclick="togglePw('reg_pw2',this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-none cursor-pointer text-[#ccc] hover:text-[#2d6b50] transition p-0">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <p class="hidden text-[11px] text-red-600 mt-1" id="e_pw2">Kata sandi tidak cocok</p>
                </div>

                <div class="flex gap-2 mt-4">
                    <button type="button" onclick="nextStep(3)"
                        class="flex-1 py-3 bg-[#22543D] text-white border-none rounded-[3px] text-xs font-medium tracking-[3px] uppercase cursor-pointer hover:bg-[#2d6b50] transition">
                        Selanjutnya →
                    </button>
                </div>
            </div>

            {{-- ============ STEP 4 – Konfirmasi ============ --}}
            <div class="hidden" id="step4">

                <p class="text-[13px] text-[#999990] mb-4 leading-relaxed">
                    Periksa kembali data kamu sebelum mendaftar.
                </p>

                <div class="bg-[#f7f7f5] border border-[#e2e2de] rounded-[4px] px-4 py-3.5 mb-4 text-[13px] leading-loose">
                    <div>
                        <span class="text-[#999990] inline-block min-w-[110px]">Username</span>
                        <strong id="sum_username">—</strong>
                    </div>
                    <div>
                        <span class="text-[#999990] inline-block min-w-[110px]">NIK</span>
                        <strong id="sum_nik">—</strong>
                    </div>
                    <div>
                        <span class="text-[#999990] inline-block min-w-[110px]">Email</span>
                        <strong id="sum_email">—</strong>
                    </div>
                    <div>
                        <span class="text-[#999990] inline-block min-w-[110px]">Status</span>
                        <span class="text-[11px] bg-[#e6f7ef] text-[#22543D] px-2 py-0.5 rounded-full">✓ Email Terverifikasi</span>
                    </div>
                </div>

                <div class="flex gap-2 mt-4">
                    <button type="button" onclick="prevStep(4)"
                        class="py-3 px-4 bg-transparent border border-[#e2e2de] rounded-[3px] text-[13px] text-[#999990] cursor-pointer hover:border-[#38856a] hover:text-[#22543D] transition">
                        ←
                    </button>
                    <button type="button" onclick="submitForm()"
                        class="flex-1 py-3 bg-[#ED64A6] text-white border-none rounded-[3px] text-xs font-medium tracking-[3px] uppercase cursor-pointer hover:bg-[#d4528f] transition">
                        Daftar
                    </button>
                </div>
            </div>

        </form>

        {{-- DIVIDER --}}
        <div class="flex items-center gap-3.5 my-6">
            <div class="flex-1 h-px bg-[#e2e2de]"></div>
            <span class="text-[11px] text-[#d0d0cc] tracking-[1.5px] uppercase">atau</span>
            <div class="flex-1 h-px bg-[#e2e2de]"></div>
        </div>

        <p class="text-center text-xs font-light text-[#999990] mb-2.5">Sudah punya akun?</p>
        <a href="/login"
            class="block w-full py-3 bg-transparent border-[1.5px] border-[#ED64A6] rounded-[3px] text-xs font-medium tracking-[3px] uppercase text-[#ED64A6] text-center no-underline hover:bg-[#ED64A6] hover:text-white transition">
            Masuk
        </a>

    </div>
</div>

{{-- Footer bar --}}
<div class="fixed bottom-0 left-0 right-0 h-[3px] bg-gradient-to-r from-[#22543D] from-[65%] to-[#ED64A6]"></div>

<script>
let cur = 1;
let timerInterval = null;
let timerLeft = 60;

// ── Step navigation ────────────────────────────────────────────────────────
function goStep(n) {
    document.getElementById('step' + cur).classList.add('hidden');
    cur = n;
    document.getElementById('step' + n).classList.remove('hidden');

    for (let i = 1; i <= 4; i++) {
        const d = document.getElementById('dot' + i);
        d.classList.remove('bg-[#22543D]', 'border-[#22543D]', 'text-white', 'border-[#38856a]', 'text-[#2d6b50]');
        d.classList.add('text-[#ccc]', 'border-[#e2e2de]');
        if (i < cur) {
            d.classList.remove('text-[#ccc]', 'border-[#e2e2de]');
            d.classList.add('border-[#38856a]', 'text-[#2d6b50]');
        } else if (i === cur) {
            d.classList.remove('text-[#ccc]', 'border-[#e2e2de]');
            d.classList.add('bg-[#22543D]', 'border-[#22543D]', 'text-white');
        }
    }

    for (let i = 1; i <= 3; i++) {
        const l = document.getElementById('ln' + i);
        if (l) {
            if (i < cur) {
                l.classList.remove('bg-[#e2e2de]');
                l.classList.add('bg-[#38856a]');
            } else {
                l.classList.remove('bg-[#38856a]');
                l.classList.add('bg-[#e2e2de]');
            }
        }
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

function submitForm() {
    const form = document.getElementById('regForm');
    form.onsubmit = null;
    form.submit();
}

// ── Step 1 → OTP ──────────────────────────────────────────────────────────
async function goToOtp() {
    const u   = document.getElementById('reg_username').value.trim();
    const nik = document.getElementById('reg_nik').value.trim();
    const e   = document.getElementById('reg_email').value.trim();
    let ok = true;

    if (u.length < 3)                           { showErr('e_username', 'reg_username'); ok = false; } else clrErr('e_username', 'reg_username');
    if (!/^\d{16}$/.test(nik))                  { showErr('e_nik', 'reg_nik'); ok = false; }          else clrErr('e_nik', 'reg_nik');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e)) { showErr('e_email', 'reg_email'); ok = false; }       else clrErr('e_email', 'reg_email');
    if (!ok) return;

    const btn = document.getElementById('btn_step1');
    btn.disabled = true;
    btn.textContent = 'Mengirim OTP…';

    try {
        const res  = await fetch('{{ route("otp.send") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify({ email: e }),
        });
        const data = await res.json();

        if (!res.ok || !data.success) {
            showErr('e_email', 'reg_email');
            document.getElementById('e_email').textContent = data.message || 'Gagal mengirim OTP.';
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

// ── Verifikasi OTP ────────────────────────────────────────────────────────
async function doVerifyOtp() {
    const digits = Array.from(document.querySelectorAll('.otp-digit')).map(i => i.value).join('');
    const email  = document.getElementById('reg_email').value.trim();

    hideAlert('otp_alert_err');
    hideAlert('otp_alert_ok');

    if (digits.length < 6) { showAlert('otp_alert_err', 'Masukkan semua 6 digit kode OTP.'); return; }
    if (timerLeft <= 0)    { showAlert('otp_alert_err', 'Kode OTP sudah kedaluwarsa. Klik "Kirim ulang".'); return; }

    const btn = document.getElementById('btn_verify');
    btn.disabled = true;
    btn.textContent = 'Memverifikasi…';

    try {
        const res  = await fetch('{{ route("otp.verify") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify({ email, otp: digits }),
        });
        const data = await res.json();

        if (!res.ok || !data.success) {
            showAlert('otp_alert_err', data.message || 'Kode OTP salah.');
            document.querySelectorAll('.otp-digit').forEach(i => {
                i.classList.add('!border-red-400');
                setTimeout(() => i.classList.remove('!border-red-400'), 1200);
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
        const res  = await fetch('{{ route("otp.send") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify({ email }),
        });
        const text = await res.text();
        console.log("RESPONSE:", text);
        let data;
        try { data = JSON.parse(text); } catch (e) { console.error("INI ERROR LARAVEL:", text); throw e; }

        document.querySelectorAll('.otp-digit').forEach(i => { i.value = ''; i.classList.remove('!border-[#2d6b50]'); });
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
        if (timerLeft <= 0) { clearInterval(timerInterval); document.getElementById('resend_btn').disabled = false; }
    }, 1000);
}

function updateTimerUI() {
    const el  = document.getElementById('timer_num');
    const bar = document.getElementById('timer_bar');
    el.textContent = timerLeft;
    el.style.color = timerLeft <= 10 ? '#e53e3e' : '#22543D';
    const pct = Math.round((timerLeft / 60) * 100);
    bar.style.width      = pct + '%';
    bar.style.background = timerLeft <= 10 ? '#e53e3e' : timerLeft <= 20 ? '#f6ad55' : '#22543D';
}

// ── OTP box auto-focus & Enter ─────────────────────────────────────────────
document.querySelectorAll('.otp-digit').forEach((inp, i, arr) => {
    inp.addEventListener('input', () => {
        const v = inp.value.replace(/\D/g, '');
        inp.value = v;
        inp.classList.toggle('!border-[#2d6b50]', v !== '');
        if (v && i < arr.length - 1) arr[i + 1].focus();
    });
    inp.addEventListener('keydown', e => {
        if (e.key === 'Enter') { e.preventDefault(); doVerifyOtp(); return; }
        if (e.key === 'Backspace' && !inp.value && i > 0) arr[i - 1].focus();
    });
    inp.addEventListener('paste', e => {
        e.preventDefault();
        const txt = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
        txt.split('').slice(0, 6).forEach((ch, j) => {
            if (arr[i + j]) { arr[i + j].value = ch; arr[i + j].classList.add('!border-[#2d6b50]'); }
        });
        arr[Math.min(i + txt.length, 5)].focus();
    });
});

// ── Password strength ─────────────────────────────────────────────────────
function checkStrength(v) {
    const bar = document.getElementById('pwBar');
    if (v.length) bar.classList.remove('hidden'); else { bar.classList.add('hidden'); return; }
    let s = 0;
    if (v.length >= 8)          s++;
    if (/[A-Z]/.test(v))        s++;
    if (/[0-9]/.test(v))        s++;
    if (/[^A-Za-z0-9]/.test(v)) s++;
    const colors = ['', '#fc8181', '#fc8181', '#f6ad55', '#38856a'];
    const lbl    = ['', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
    ['b1','b2','b3','b4'].forEach((id, i) => {
        const b = document.getElementById(id);
        b.style.background = i < s ? colors[s] : '#e2e2de';
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
    document.getElementById(eid).classList.remove('hidden');
    if (iid) document.getElementById(iid).classList.add('!border-red-500');
}
function clrErr(eid, iid) {
    document.getElementById(eid).classList.add('hidden');
    if (iid) document.getElementById(iid).classList.remove('!border-red-500');
}
function showAlert(id, msg) {
    const el = document.getElementById(id);
    el.textContent = msg;
    el.classList.remove('hidden');
}
function hideAlert(id) {
    document.getElementById(id).classList.add('hidden');
}
</script>

</body>
</html>