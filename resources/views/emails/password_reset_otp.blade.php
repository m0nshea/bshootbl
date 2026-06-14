<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Kode OTP Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f8fb;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            padding: 24px;
            box-shadow: 0 0 12px rgba(0,0,0,0.05);
        }
        .header {
            margin-bottom: 20px;
        }
        .otp {
            display: inline-block;
            margin: 20px 0;
            padding: 16px 24px;
            font-size: 28px;
            letter-spacing: 6px;
            background: #f2f4f7;
            border-radius: 12px;
        }
        .footer {
            margin-top: 24px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Kode OTP Reset Password</h1>
            <p>Hai {{ $user->name }},</p>
        </div>

        <p>Kami menerima permintaan reset password untuk akun Anda. Gunakan kode di bawah ini untuk melanjutkan proses reset:</p>
        <div class="otp">{{ $otp }}</div>

        <p>Kode ini berlaku selama 10 menit. Jika Anda tidak meminta reset password, abaikan email ini.</p>

        <div class="footer">
            <p>Terima kasih,<br />Tim Bshoot Billiard</p>
        </div>
    </div>
</body>
</html>
