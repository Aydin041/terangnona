<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi</title>
    <style>
        body { margin: 0; padding: 0; background: #f4f6f9; font-family: 'Segoe UI', Arial, sans-serif; }
        .wrapper { max-width: 600px; margin: 32px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #0a1431 0%, #1a2d6b 100%); padding: 36px 32px; text-align: center; }
        .header .badge { display: inline-block; background: #f5a31a; color: #0a1431; font-weight: 700; font-size: 11px; letter-spacing: 2px; padding: 4px 14px; border-radius: 20px; text-transform: uppercase; margin-bottom: 14px; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 0 4px; }
        .header p { color: #94a3c0; font-size: 13px; margin: 0; }
        .body { padding: 36px 32px; }
        .greeting { font-size: 16px; color: #1e293b; margin-bottom: 20px; }
        .notice { background: #fffbeb; border-left: 4px solid #f5a31a; border-radius: 0 8px 8px 0; padding: 14px 18px; margin-bottom: 28px; font-size: 13px; color: #92400e; line-height: 1.6; }
        .btn-wrap { text-align: center; margin: 32px 0; }
        .btn { display: inline-block; background: #0a1431; color: #ffffff !important; text-decoration: none; padding: 13px 32px; border-radius: 8px; font-size: 14px; font-weight: 600; letter-spacing: 0.5px; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 24px 32px; text-align: center; }
        .footer p { font-size: 12px; color: #94a3b8; margin: 0 0 4px; line-height: 1.6; }
        .footer .org { font-weight: 600; color: #64748b; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="badge">Keamanan Akun</div>
            <h1>TERANG NONA 2026</h1>
            <p>Atur Ulang Kata Sandi Akun</p>
        </div>
        <div class="body">
            <div class="greeting">
                Halo <strong>{{ $peserta->nama }}</strong>,
            </div>

            <p style="color: #475569; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                Kami menerima permintaan untuk mengatur ulang kata sandi akun peserta TERANG NONA Anda. Klik tombol di bawah ini untuk membuat kata sandi baru:
            </p>

            <div class="btn-wrap">
                <a href="{{ $resetUrl }}" class="btn">Atur Ulang Kata Sandi →</a>
            </div>

            <div class="notice">
                ⏱️ <strong>Perhatian:</strong> Tautan pengaturan ulang kata sandi ini berlaku selama 60 menit. Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini dan akun Anda tetap aman.
            </div>

            <p style="font-size: 12px; color: #94a3b8; word-break: break-all;">
                Jika tombol di atas tidak dapat diklik, salin dan buka tautan berikut di browser Anda:<br>
                <a href="{{ $resetUrl }}" style="color: #0284c7;">{{ $resetUrl }}</a>
            </p>
        </div>
        <div class="footer">
            <p class="org">Panitia TERANG NONA Disnakertrans Jateng</p>
            <p>Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah</p>
        </div>
    </div>
</body>
</html>
