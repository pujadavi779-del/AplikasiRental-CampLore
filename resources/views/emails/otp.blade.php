<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding: 30px;">
    <div style="max-width:480px; margin:auto; background:#fff; border-radius:8px; padding:30px;">
        
        <h2 style="color:#2d6a4f; text-align:center;">CAMPLORE</h2>
        <p>Halo,</p>
        <p>Berikut adalah kode OTP untuk verifikasi email kamu:</p>

        <div style="text-align:center; margin: 24px 0;">
            <span style="font-size:36px; font-weight:bold; letter-spacing:8px; color:#2d6a4f;">
                {{ $otpCode }}
            </span>
        </div>

        <p>Kode ini berlaku selama <strong>{{ $expiryMinutes }}</strong>.</p>
        <p>Jangan bagikan kode ini ke siapapun.</p>

        <hr style="margin-top:30px;">
        <p style="font-size:12px; color:#999; text-align:center;">
            Jika kamu tidak merasa mendaftar, abaikan email ini.
        </p>
    </div>
</body>
</html>