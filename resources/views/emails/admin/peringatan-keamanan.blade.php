<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peringatan Keamanan Login</title>
    <style>
        body { margin: 0; padding: 0; background: #f4f6f9; font-family: 'Segoe UI', Arial, sans-serif; }
        .wrapper { max-width: 600px; margin: 32px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%); padding: 36px 32px; text-align: center; }
        .header .badge { display: inline-block; background: #fee2e2; color: #991b1b; font-weight: 700; font-size: 11px; letter-spacing: 2px; padding: 4px 14px; border-radius: 20px; text-transform: uppercase; margin-bottom: 14px; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 0 4px; }
        .header p { color: #fca5a5; font-size: 13px; margin: 0; }
        .body { padding: 36px 32px; }
        .greeting { font-size: 16px; color: #1e293b; margin-bottom: 20px; }
        .status-box { background: #fef2f2; border: 2px solid #ef4444; border-radius: 10px; padding: 20px 24px; margin-bottom: 24px; }
        .status-box .status-label { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #dc2626; margin-bottom: 6px; }
        .status-box .status-text { font-size: 15px; color: #991b1b; font-weight: 600; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .info-table tr td { padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #475569; }
        .info-table tr td:first-child { font-weight: 600; color: #1e293b; width: 42%; }
        .info-table tr:last-child td { border-bottom: none; }
        .notice { background: #fff1f2; border-left: 4px solid #f43f5e; border-radius: 0 8px 8px 0; padding: 14px 18px; margin-bottom: 28px; font-size: 13px; color: #9f1239; line-height: 1.6; }
        .btn-wrap { text-align: center; margin-bottom: 32px; }
        .btn { display: inline-block; background: #0a1431; color: #ffffff !important; text-decoration: none; padding: 13px 32px; border-radius: 8px; font-size: 14px; font-weight: 600; letter-spacing: 0.5px; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 24px 32px; text-align: center; }
        .footer p { font-size: 12px; color: #94a3b8; margin: 0 0 4px; line-height: 1.6; }
        .footer .org { font-weight: 600; color: #64748b; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="badge">Keamanan Sistem</div>
            <h1>TERANG NONA 2026</h1>
            <p>Peringatan Pembatasan Percobaan Login</p>
        </div>
        <div class="body">
            <div class="greeting">
                Halo <strong>Administrator TERANG NONA</strong>,
            </div>

            <div class="status-box">
                <div class="status-label">🚨 Percobaan Login Berulang Terdeteksi</div>
                <div class="status-text">Sistem telah memblokir sementara percobaan masuk karena melebihi batas toleransi kesalahan password (Rate Limiting).</div>
            </div>

            <table class="info-table">
                <tr>
                    <td>Peran / Portal</td>
                    <td><strong style="text-transform: uppercase;">{{ $guard }}</strong></td>
                </tr>
                <tr>
                    <td>Alamat Email Target</td>
                    <td><strong>{{ $emailTarget ?: '(Tidak dicantumkan)' }}</strong></td>
                </tr>
                <tr>
                    <td>Alamat IP Asal</td>
                    <td><code>{{ $ipAddress }}</code></td>
                </tr>
                <tr>
                    <td>Waktu Pemblokiran</td>
                    <td>{{ $waktu }}</td>
                </tr>
            </table>

            <div class="notice">
                🛡️ <strong>Tindakan Sistem:</strong> Akses login dari IP atau target akun tersebut telah dikunci otomatis selama 5 menit. Jika aktivitas ini bukan dari pemilik akun sah, Anda dapat memantau atau mengamankan akun terkait melalui portal manajemen admin.
            </div>

            <div class="btn-wrap">
                <a href="{{ route('admin.dashboard') }}" class="btn">Buka Panel Admin →</a>
            </div>
        </div>
        <div class="footer">
            <p class="org">Sistem Keamanan Otomatis TERANG NONA</p>
            <p>Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah</p>
        </div>
    </div>
</body>
</html>
