<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Camplore</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background: #f7f7f5; color: #1a1a18; }
        .wrapper { max-width: 520px; margin: 40px auto; background: #ffffff; border-radius: 6px; overflow: hidden; border: 1px solid #e2e2de; }
        .header { background: #22543D; padding: 32px 40px; text-align: center; }
        .header h1 { font-size: 22px; font-weight: 700; letter-spacing: 8px; text-transform: uppercase; color: #ffffff; }
        .body { padding: 36px 40px; }
        .greeting { font-size: 15px; color: #1a1a18; margin-bottom: 16px; line-height: 1.6; }
        .otp-box { background: #f0f7f4; border: 1.5px dashed #38856a; border-radius: 6px; text-align: center; padding: 24px 20px; margin: 24px 0; }
        .otp-label { font-size: 11px; font-weight: 500; letter-spacing: 2px; text-transform: uppercase; color: #38856a; margin-bottom: 10px; }
        .otp-code { font-size: 40px; font-weight: 700; letter-spacing: 10px; color: #22543D; font-family: 'Courier New', monospace; }
        .expiry-note { font-size: 13px; color: #999990; margin-top: 10px; }
        .expiry-note strong { color: #e53e3e; }
        .info { font-size: 13px; color: #666660; line-height: 1.7; margin-bottom: 10px; }
        .warning { background: #fff8f0; border-left: 3px solid #f6ad55; padding: 12px 16px; border-radius: 0 4px 4px 0; margin: 20px 0; font-size: 13px; color: #744210; line-height: 1.6; }
        .footer { border-top: 1px solid #e2e2de; padding: 20px 40px; text-align: center; }
        .footer p { font-size: 11px; color: #aaa; line-height: 1.7; }
        .footer a { color: #22543D; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="header">
        <h1>Camplore</h1>
    </div>

    <div class="body">
        <p class="greeting">
            Halo! Terima kasih sudah mendaftar di <strong>Camplore</strong>.<br>
            Gunakan kode OTP berikut untuk memverifikasi akun kamu:
        </p>

        <div class="otp-box">
            <p class="otp-label">Kode Verifikasi OTP</p>
            <p class="otp-code">{{ $otpCode }}</p>
            <p class="expiry-note">Berlaku selama <strong>{{ $expiryMinutes }}</strong></p>
        </div>

        <p class="info">
            Masukkan kode di atas pada halaman pendaftaran Camplore untuk menyelesaikan verifikasi email kamu.
        </p>

        <div class="warning">
            ⚠️ <strong>Jangan bagikan kode ini kepada siapapun.</strong><br>
            Tim Camplore tidak pernah meminta kode OTP kamu. Jika kamu tidak merasa mendaftar, abaikan email ini.
        </div>

        <p class="info">Salam,<br><strong>Tim Camplore</strong></p>
    </div>

    <div class="footer">
        <p>
            Email ini dikirim otomatis, mohon jangan balas.<br>
            &copy; {{ date('Y') }} Camplore. All rights reserved.<br>
            <a href="#">Kebijakan Privasi</a> &middot; <a href="#">Syarat & Ketentuan</a>
        </p>
    </div>

</div>
</body>
</html>