<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi – Camplore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-['Inter',sans-serif] bg-white text-[#1a1a18] h-full">

{{-- NAVBAR --}}
<nav class="fixed top-0 left-0 right-0 h-[58px] flex items-center justify-center border-b border-[#e2e2de] bg-white z-[100]">
    <a href="/">
        <img src="{{ asset('images/Black_Summer_Camp_Adventure_Logo-removebg-preview.png') }}" alt="Camplore Logo" class="h-[200px] w-auto block">
    </a>
</nav>

<div class="min-h-screen flex items-center justify-center px-5 pt-[90px] pb-[60px]">
    <div class="w-full max-w-[380px]">

        {{-- ===================== STEP 1: INPUT EMAIL ===================== --}}
        <div id="step-email">
            <h1 class="font-['Playfair_Display',serif] text-[26px] font-semibold tracking-[3px] uppercase text-[#22543D] text-center mb-2">
                Lupa Kata Sandi
            </h1>
            <p class="text-center text-[#999990] text-xs font-light tracking-[0.3px] mb-8">
                Masukkan email akunmu, kami akan kirimkan kode OTP.
            </p>

            <div id="alert-email" class="hidden mb-4 px-3.5 py-2.5 rounded text-xs"></div>

            <div class="mb-3">
                <input type="email" id="input-email" placeholder="email@anda.com" autocomplete="email"
                    class="w-full px-4 py-3 border border-[#e2e2de] rounded-[3px] text-sm font-light text-[#1a1a18] bg-[#f7f7f5] outline-none transition focus:border-[#38856a] focus:bg-white placeholder-[#bebeba] tracking-[0.3px]">
            </div>

            <button onclick="kirimOtp()"
                id="btn-kirim"
                class="w-full py-3.5 mt-1.5 bg-[#22543D] text-white border-none rounded-[3px] text-xs font-medium tracking-[3px] uppercase cursor-pointer hover:bg-[#2d6b50] transition">
                Kirim Kode OTP
            </button>

            <div class="flex items-center gap-3.5 my-6">
                <div class="flex-1 h-px bg-[#e2e2de]"></div>
                <span class="text-[11px] text-[#d0d0cc] tracking-[1.5px] uppercase">atau</span>
                <div class="flex-1 h-px bg-[#e2e2de]"></div>
            </div>
            <p class="text-center text-xs font-light text-[#999990] mb-2.5">Ingat kata sandimu?</p>
            <a href="{{ route('login') }}"
                class="block w-full py-3 bg-transparent border-[1.5px] border-[#ED64A6] rounded-[3px] text-xs font-medium tracking-[3px] uppercase text-[#ED64A6] text-center no-underline hover:bg-[#ED64A6] hover:text-white transition">
                Masuk
            </a>
        </div>

        {{-- ===================== STEP 2: INPUT OTP ===================== --}}
        <div id="step-otp" class="hidden">
            <h1 class="font-['Playfair_Display',serif] text-[26px] font-semibold tracking-[3px] uppercase text-[#22543D] text-center mb-2">
                Verifikasi OTP
            </h1>
            <p class="text-center text-[#999990] text-xs font-light tracking-[0.3px] mb-1">
                Kode OTP telah dikirim ke
            </p>
            <p id="label-email-otp" class="text-center text-[#22543D] text-xs font-medium mb-8"></p>

            <div id="alert-otp" class="hidden mb-4 px-3.5 py-2.5 rounded text-xs"></div>

            {{-- Input 6 kotak OTP --}}
            <div class="flex gap-2 justify-center mb-4" id="otp-boxes">
                <input type="text" maxlength="1" inputmode="numeric"
                    class="otp-box w-11 h-12 text-center text-lg font-medium border border-[#e2e2de] rounded-[3px] bg-[#f7f7f5] outline-none focus:border-[#38856a] focus:bg-white transition">
                <input type="text" maxlength="1" inputmode="numeric"
                    class="otp-box w-11 h-12 text-center text-lg font-medium border border-[#e2e2de] rounded-[3px] bg-[#f7f7f5] outline-none focus:border-[#38856a] focus:bg-white transition">
                <input type="text" maxlength="1" inputmode="numeric"
                    class="otp-box w-11 h-12 text-center text-lg font-medium border border-[#e2e2de] rounded-[3px] bg-[#f7f7f5] outline-none focus:border-[#38856a] focus:bg-white transition">
                <input type="text" maxlength="1" inputmode="numeric"
                    class="otp-box w-11 h-12 text-center text-lg font-medium border border-[#e2e2de] rounded-[3px] bg-[#f7f7f5] outline-none focus:border-[#38856a] focus:bg-white transition">
                <input type="text" maxlength="1" inputmode="numeric"
                    class="otp-box w-11 h-12 text-center text-lg font-medium border border-[#e2e2de] rounded-[3px] bg-[#f7f7f5] outline-none focus:border-[#38856a] focus:bg-white transition">
                <input type="text" maxlength="1" inputmode="numeric"
                    class="otp-box w-11 h-12 text-center text-lg font-medium border border-[#e2e2de] rounded-[3px] bg-[#f7f7f5] outline-none focus:border-[#38856a] focus:bg-white transition">
            </div>

            {{-- Timer --}}
            <p class="text-center text-xs text-[#999990] mb-4">
                Kode berlaku selama <span id="timer-otp" class="font-medium text-[#22543D]">60</span> detik
            </p>

            <button onclick="verifikasiOtp()" id="btn-verifikasi"
                class="w-full py-3.5 bg-[#22543D] text-white border-none rounded-[3px] text-xs font-medium tracking-[3px] uppercase cursor-pointer hover:bg-[#2d6b50] transition">
                Verifikasi
            </button>

            <div class="text-center mt-4">
                <button onclick="kirimUlang()" id="btn-kirim-ulang"
                    class="text-xs font-light text-[#999990] underline underline-offset-[3px] hover:text-[#22543D] transition disabled:opacity-40 disabled:cursor-not-allowed"
                    disabled>
                    Kirim ulang kode
                </button>
            </div>

            <div class="text-center mt-3">
                <button onclick="kembaliKeEmail()" class="text-xs font-light text-[#bebeba] hover:text-[#22543D] transition">
                    ← Ganti email
                </button>
            </div>
        </div>

        {{-- ===================== STEP 3: RESET PASSWORD ===================== --}}
        <div id="step-reset" class="hidden">
            <h1 class="font-['Playfair_Display',serif] text-[26px] font-semibold tracking-[3px] uppercase text-[#22543D] text-center mb-2">
                Kata Sandi Baru
            </h1>
            <p class="text-center text-[#999990] text-xs font-light tracking-[0.3px] mb-8">
                Buat kata sandi baru untuk akunmu.
            </p>

            <div id="alert-reset" class="hidden mb-4 px-3.5 py-2.5 rounded text-xs"></div>

            {{-- Password baru --}}
            <div class="mb-3">
                <div class="relative">
                    <input type="password" id="input-password" placeholder="Kata sandi baru" autocomplete="new-password"
                        class="w-full px-4 py-3 pr-10 border border-[#e2e2de] rounded-[3px] text-sm font-light text-[#1a1a18] bg-[#f7f7f5] outline-none transition focus:border-[#38856a] focus:bg-white placeholder-[#bebeba]">
                    <button type="button" onclick="togglePw('input-password', this)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-none cursor-pointer text-[#ccc] hover:text-[#2d6b50] transition p-0">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Konfirmasi password --}}
            <div class="mb-3">
                <div class="relative">
                    <input type="password" id="input-password-confirm" placeholder="Konfirmasi kata sandi" autocomplete="new-password"
                        class="w-full px-4 py-3 pr-10 border border-[#e2e2de] rounded-[3px] text-sm font-light text-[#1a1a18] bg-[#f7f7f5] outline-none transition focus:border-[#38856a] focus:bg-white placeholder-[#bebeba]">
                    <button type="button" onclick="togglePw('input-password-confirm', this)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-none cursor-pointer text-[#ccc] hover:text-[#2d6b50] transition p-0">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button onclick="resetPassword()" id="btn-reset"
                class="w-full py-3.5 mt-1.5 bg-[#22543D] text-white border-none rounded-[3px] text-xs font-medium tracking-[3px] uppercase cursor-pointer hover:bg-[#2d6b50] transition">
                Simpan Kata Sandi
            </button>
        </div>

    </div>
</div>

{{-- Footer bar --}}
<div class="fixed bottom-0 left-0 right-0 h-[3px] bg-gradient-to-r from-[#22543D] from-[65%] to-[#ED64A6]"></div>

<script>
    const CSRF = '{{ csrf_token() }}';
    let emailTerverifikasi = '';
    let timerInterval = null;

    // ─── Helpers ────────────────────────────────────────────────────────────────
    function showAlert(id, msg, type = 'error') {
        const el = document.getElementById(id);
        el.className = `mb-4 px-3.5 py-2.5 rounded text-xs ${
            type === 'success'
                ? 'bg-[#f0fff4] border border-[#c6f6d5] text-[#276749]'
                : 'bg-[#fff5f5] border border-[#fed7d7] text-[#c53030]'
        }`;
        el.textContent = msg;
        el.classList.remove('hidden');
    }

    function setLoading(btnId, loading, label) {
        const btn = document.getElementById(btnId);
        btn.disabled = loading;
        btn.textContent = loading ? 'Memproses...' : label;
        btn.classList.toggle('opacity-60', loading);
    }

    function showStep(step) {
        ['step-email', 'step-otp', 'step-reset'].forEach(s => {
            document.getElementById(s).classList.add('hidden');
        });
        document.getElementById('step-' + step).classList.remove('hidden');
    }

    // ─── OTP Timer ──────────────────────────────────────────────────────────────
    function mulaiTimer(detik = 60) {
        clearInterval(timerInterval);
        const timerEl = document.getElementById('timer-otp');
        const btnUlang = document.getElementById('btn-kirim-ulang');
        btnUlang.disabled = true;
        let sisa = detik;
        timerEl.textContent = sisa;
        timerInterval = setInterval(() => {
            sisa--;
            timerEl.textContent = sisa;
            if (sisa <= 0) {
                clearInterval(timerInterval);
                timerEl.textContent = '0';
                btnUlang.disabled = false;
            }
        }, 1000);
    }

    // ─── OTP Boxes ──────────────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        const boxes = document.querySelectorAll('.otp-box');
        boxes.forEach((box, i) => {
            box.addEventListener('input', () => {
                box.value = box.value.replace(/\D/g, '');
                if (box.value && i < boxes.length - 1) boxes[i + 1].focus();
            });
            box.addEventListener('keydown', e => {
                if (e.key === 'Backspace' && !box.value && i > 0) boxes[i - 1].focus();
            });
        });
    });

    function getOtpValue() {
        return [...document.querySelectorAll('.otp-box')].map(b => b.value).join('');
    }

    function clearOtpBoxes() {
        document.querySelectorAll('.otp-box').forEach(b => b.value = '');
        document.querySelectorAll('.otp-box')[0].focus();
    }

    // ─── Step 1: Kirim OTP ──────────────────────────────────────────────────────
    async function kirimOtp() {
        const email = document.getElementById('input-email').value.trim();
        if (!email) { showAlert('alert-email', 'Masukkan alamat email kamu.'); return; }

        setLoading('btn-kirim', true, 'Kirim Kode OTP');
        try {
            const res = await fetch('{{ route("password.send-otp") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ email })
            });
            const data = await res.json();
            if (data.success) {
                emailTerverifikasi = email;
                document.getElementById('label-email-otp').textContent = email;
                document.getElementById('alert-otp').classList.add('hidden');
                clearOtpBoxes();
                showStep('otp');
                mulaiTimer(60);
            } else {
                showAlert('alert-email', data.message || 'Gagal mengirim OTP.');
            }
        } catch {
            showAlert('alert-email', 'Terjadi kesalahan. Coba lagi.');
        }
        setLoading('btn-kirim', false, 'Kirim Kode OTP');
    }

    // ─── Step 2: Verifikasi OTP ─────────────────────────────────────────────────
    async function verifikasiOtp() {
        const otp = getOtpValue();
        if (otp.length < 6) { showAlert('alert-otp', 'Masukkan 6 digit kode OTP.'); return; }

        setLoading('btn-verifikasi', true, 'Verifikasi');
        try {
            const res = await fetch('{{ route("password.verify-otp") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ email: emailTerverifikasi, otp })
            });
            const data = await res.json();
            if (data.success) {
                clearInterval(timerInterval);
                showStep('reset');
                document.getElementById('alert-reset').classList.add('hidden');
            } else {
                showAlert('alert-otp', data.message || 'Kode OTP salah.');
            }
        } catch {
            showAlert('alert-otp', 'Terjadi kesalahan. Coba lagi.');
        }
        setLoading('btn-verifikasi', false, 'Verifikasi');
    }

    // ─── Kirim Ulang OTP ────────────────────────────────────────────────────────
    async function kirimUlang() {
        setLoading('btn-kirim-ulang', true, 'Kirim ulang kode');
        try {
            const res = await fetch('{{ route("password.send-otp") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ email: emailTerverifikasi })
            });
            const data = await res.json();
            if (data.success) {
                clearOtpBoxes();
                showAlert('alert-otp', 'Kode OTP baru telah dikirim.', 'success');
                mulaiTimer(60);
            } else {
                showAlert('alert-otp', data.message || 'Gagal mengirim ulang OTP.');
            }
        } catch {
            showAlert('alert-otp', 'Terjadi kesalahan. Coba lagi.');
        }
        setLoading('btn-kirim-ulang', false, 'Kirim ulang kode');
    }

    // ─── Step 3: Reset Password ─────────────────────────────────────────────────
    async function resetPassword() {
        const password = document.getElementById('input-password').value;
        const confirm  = document.getElementById('input-password-confirm').value;

        if (!password || password.length < 8) {
            showAlert('alert-reset', 'Kata sandi minimal 8 karakter.'); return;
        }
        if (!/[a-zA-Z]/.test(password) || !/[0-9]/.test(password)) {
            showAlert('alert-reset', 'Kata sandi harus mengandung huruf dan angka.'); return;
        }
        if (password !== confirm) {
            showAlert('alert-reset', 'Konfirmasi kata sandi tidak cocok.'); return;
        }

        setLoading('btn-reset', true, 'Simpan Kata Sandi');
        try {
            const res = await fetch('{{ route("password.reset") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({
                    password,
                    password_confirmation: confirm
                })
            });

            // Controller redirect, tangkap response URL
            if (res.redirected) {
                window.location.href = res.url;
                return;
            }

            const data = await res.json().catch(() => null);
            if (data && data.message) {
                showAlert('alert-reset', data.message);
            }
        } catch {
            showAlert('alert-reset', 'Terjadi kesalahan. Coba lagi.');
        }
        setLoading('btn-reset', false, 'Simpan Kata Sandi');
    }

    // ─── Kembali ke email ────────────────────────────────────────────────────────
    function kembaliKeEmail() {
        clearInterval(timerInterval);
        showStep('email');
        document.getElementById('alert-email').classList.add('hidden');
    }

    // ─── Toggle password visibility ──────────────────────────────────────────────
    function togglePw(id, btn) {
        const el = document.getElementById(id);
        const show = el.type === 'password';
        el.type = show ? 'text' : 'password';
        btn.innerHTML = show
            ? `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
            : `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
    }
</script>

</body>
</html>
BLADE
echo "Done"
Keluaran

Done
Selesai

Anda kehabisan pesan gratis sampai 01.00
Tingkatkan
