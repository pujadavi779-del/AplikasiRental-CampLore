<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\OtpCode;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;

class ForgotPasswordController extends Controller
{
    // -------------------------------------------------------------------------
    // Step 1 – Tampilkan halaman input email
    // -------------------------------------------------------------------------
    public function showForm()
    {
        return view('pages.login.forgot-password');
    }

    // -------------------------------------------------------------------------
    // Step 2 – Kirim OTP ke email
    // -------------------------------------------------------------------------
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'Email ini tidak terdaftar.',
        ]);

        $email = $request->email;

        // Rate limit: maks 3 kali kirim OTP per email per 5 menit
        $rateLimitKey = 'forgot-otp-send:' . $email;
        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return response()->json([
                'success' => false,
                'message' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ], 429);
        }
        RateLimiter::hit($rateLimitKey, 300); // 5 menit

        // Hapus OTP lama untuk email ini
        OtpCode::where('email', $email)->where('type', 'forgot_password')->delete();

        // Generate kode 6 digit
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan ke database, expired 60 detik
        OtpCode::create([
            'email'      => $email,
            'type'       => 'forgot_password',
            'code'       => $code,
            'is_verified' => false,
            'expires_at' => now()->addSeconds(60),
        ]);

        // Kirim email
        try {
            Mail::to($email)->send(new OtpMail($code, 60));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email. Periksa konfigurasi SMTP.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP telah dikirim ke email Anda.',
        ]);
    }

    // -------------------------------------------------------------------------
    // Step 3 – Verifikasi OTP
    // -------------------------------------------------------------------------
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp'   => ['required', 'string', 'size:6'],
        ]);

        $email = $request->email;
        $code  = $request->otp;

        // Rate limit: maks 5 percobaan verifikasi per email per 10 menit
        $rateLimitKey = 'forgot-otp-verify:' . $email;
        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return response()->json([
                'success' => false,
                'message' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ], 429);
        }

        $otp = OtpCode::where('email', $email)
            ->where('type', 'forgot_password')
            ->where('code', $code)
            ->where('is_verified', false)
            ->first();

        if (! $otp) {
            RateLimiter::hit($rateLimitKey, 600);
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP salah.',
            ], 422);
        }

        if ($otp->expires_at < now()) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP sudah kedaluwarsa. Kirim ulang kode.',
            ], 422);
        }

        // Tandai OTP sudah diverifikasi
        $otp->update(['is_verified' => true]);
        RateLimiter::clear($rateLimitKey);

        // Simpan status verified ke session
        session(['forgot_otp_verified_email' => $email]);

        return response()->json([
            'success' => true,
            'message' => 'Email berhasil diverifikasi.',
        ]);
    }

    // -------------------------------------------------------------------------
    // Step 4 – Tampilkan halaman reset password baru
    // -------------------------------------------------------------------------
    public function showResetForm()
    {
        // Pastikan pelanggan sudah verifikasi OTP
        if (! session('forgot_otp_verified_email')) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Silakan verifikasi OTP terlebih dahulu.']);
        }

        return view('pages.login.reset-password');
    }

    // -------------------------------------------------------------------------
    // Step 5 – Simpan password baru
    // -------------------------------------------------------------------------
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)
                ->letters()
                ->numbers()],
        ], [
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $email = session('forgot_otp_verified_email');

        if (! $email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Sesi telah berakhir. Silakan ulangi proses.']);
        }

        $pelanggan = Pelanggan::where('email', $email)->first();

        if (! $pelanggan) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Akun tidak ditemukan.']);
        }

        // Update password
        $pelanggan->update([
            'password' => Hash::make($request->password),
        ]);

        // Hapus OTP & session
        OtpCode::where('email', $email)->where('type', 'forgot_password')->delete();
        session()->forget('forgot_otp_verified_email');

        return redirect()->route('login')
            ->with('success', 'Kata sandi berhasil diubah! Silakan login.');
    }
}