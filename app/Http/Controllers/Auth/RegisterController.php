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

class RegisterController extends Controller
{
    // -------------------------------------------------------------------------
    // Tampilkan halaman registrasi
    // -------------------------------------------------------------------------
    public function showForm()
    {
        return view('pages.login.registrasi');
    }

    // -------------------------------------------------------------------------
    // Step 2 – Kirim OTP ke email
    // -------------------------------------------------------------------------
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:pelanggan,email'],
        ], [
            'email.unique' => 'Email ini sudah terdaftar.',
        ]);

        $email = $request->email;

        // Rate limit: maks 3 kali kirim OTP per email per 5 menit
        $rateLimitKey = 'otp-send:' . $email;
        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return response()->json([
                'success' => false,
                'message' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ], 429);
        }
        RateLimiter::hit($rateLimitKey, 300); // 5 menit

        // Hapus OTP lama untuk email ini
        OtpCode::where('email', $email)->delete();

        // Generate kode 6 digit
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan ke database, expired 60 detik
        OtpCode::create([
            'email'      => $email,
            'code'       => $code,
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
    // Step 2 – Verifikasi OTP
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
        $rateLimitKey = 'otp-verify:' . $email;
        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return response()->json([
                'success' => false,
                'message' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ], 429);
        }

        $otp = OtpCode::where('email', $email)
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

        if (! $otp->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP sudah kedaluwarsa. Kirim ulang kode.',
            ], 422);
        }

        // Tandai OTP sudah diverifikasi
        $otp->update(['is_verified' => true]);
        RateLimiter::clear($rateLimitKey);

        // Simpan status verified ke session
        session(['otp_verified_email' => $email]);

        return response()->json([
            'success' => true,
            'message' => 'Email berhasil diverifikasi.',
        ]);
    }

    // -------------------------------------------------------------------------
    // Step 4 – Submit registrasi lengkap
    // -------------------------------------------------------------------------
    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s.]+$/'],
            'nama_pengguna' => ['required', 'string', 'min:3', 'max:30', 'unique:pelanggan,nama_pengguna'],
            'nik'          => ['required', 'digits:16', 'unique:pelanggan,nik'],
            'email'        => ['required', 'email', 'unique:pelanggan,email'],
            'password'     => ['required', 'confirmed', Password::min(8)
                ->letters()
                ->numbers()],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.regex'    => 'Nama hanya boleh berisi huruf, spasi, dan titik.',
            'nama_pengguna.unique'  => 'Nama pengguna ini sudah dipakai.',
            'nik.unique'            => 'NIK ini sudah terdaftar.',
            'email.unique'          => 'Email ini sudah terdaftar.',
        ]);

        // Pastikan email sudah diverifikasi OTP di sesi ini
        if (session('otp_verified_email') !== $request->email) {
            return back()->withErrors(['email' => 'Email belum diverifikasi via OTP.']);
        }

        Pelanggan::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nama_pengguna' => $request->nama_pengguna,
            'nik'          => $request->nik,
            'email'        => $request->email,
            'kata_sandi'     => Hash::make($request->password),
        ]);

        // Hapus sesi OTP
        session()->forget('otp_verified_email');

        // Bersihkan OTP lama
        OtpCode::where('email', $request->email)->delete();

        // FIX: tidak auto-login — arahkan ke halaman login agar user login manual
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}