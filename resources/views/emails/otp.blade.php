<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi OTP</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h2>Halo!</h2>
    <p>Terima kasih telah mendaftar di MindWell. Berikut adalah kode verifikasi (OTP) Anda:</p>

    <div style="background: #f4f4f4; padding: 15px; text-align: center; font-size: 24px; letter-spacing: 5px; font-weight: bold; margin: 20px 0;">
        {{ $otp }}
    </div>

    <p>Kode ini akan kadaluarsa dalam 10 menit.</p>
    <p>Jika Anda tidak merasa mendaftar, abaikan email ini.</p>
</body>
</html>