<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\OtpCode;

class OtpController extends Controller
{
    public function sendPhone(Request $request)
    {
        $user = Auth::user();

        // Ambil dari request, bukan dari DB
        $noTlp = $request->no_tlp ?? $user->no_tlp;

        if (!$noTlp) {
            return response()->json(['message' => 'Isi nomor telepon terlebih dahulu.'], 422);
        }

        OtpCode::where('email', $user->email)->where('type', 'phone')->delete();

        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpCode::create([
            'email'       => $user->email,
            'type'        => 'phone',
            'code'        => $code,
            'is_verified' => 0,
            'expires_at'  => now()->addMinutes(5),
        ]);

        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN'),
        ])->post('https://api.fonnte.com/send', [
            'target'      => $noTlp,
            'message'     => "Kode OTP verifikasi nomor telepon Anda: *$code*\n\nBerlaku selama 5 menit. Jangan berikan kode ini kepada siapapun.",
            'countryCode' => '62',
        ]);

        if (!$response->successful()) {
            return response()->json(['message' => 'Gagal mengirim OTP WhatsApp.'], 500);
        }

        return response()->json(['message' => 'OTP terkirim ke WhatsApp ' . $noTlp]);
    }

    public function verifyPhone(Request $request)
    {
        $user = Auth::user();

        $otp = OtpCode::where('email', $user->email)
            ->where('type', 'phone')
            ->where('code', $request->code)
            ->where('is_verified', 0)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$otp) {
            return response()->json(['message' => 'Kode OTP salah atau sudah kadaluarsa.'], 422);
        }

        $otp->update(['is_verified' => 1]);

        return response()->json(['message' => 'Nomor telepon berhasil diverifikasi!']);
    }

    // OTP Email (untuk registrasi, tetap ada)
    public function verify(Request $request)
    {
        $user = Auth::user();

        $otp = OtpCode::where('email', $user->email)
            ->where('type', 'email')
            ->where('code', $request->code)
            ->where('is_verified', 0)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$otp) {
            return response()->json(['message' => 'Kode OTP salah atau sudah kadaluarsa.'], 422);
        }

        $otp->update(['is_verified' => 1]);

        return response()->json(['message' => 'Verifikasi berhasil!']);
    }
}
