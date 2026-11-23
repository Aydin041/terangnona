<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Terima Pengajuan</title>
    <style>
        body { margin: 0; padding: 0; background: #f4f6f9; font-family: 'Segoe UI', Arial, sans-serif; }
        .wrapper { max-width: 600px; margin: 32px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #0a1431 0%, #1a2d6b 100%); padding: 36px 32px; text-align: center; }
        .header .badge { display: inline-block; background: #f5a31a; color: #0a1431; font-weight: 700; font-size: 11px; letter-spacing: 2px; padding: 4px 14px; border-radius: 20px; text-transform: uppercase; margin-bottom: 14px; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 0 4px; }
        .header p { color: #94a3c0; font-size: 13px; margin: 0; }
        .body { padding: 36px 32px; }
        .greeting { font-size: 16px; color: #1e293b; margin-bottom: 20px; }
        .greeting strong { color: #0a1431; }
        .status-box { background: #f0fdf4; border: 2px solid #22c55e; border-radius: 10px; padding: 20px 24px; margin-bottom: 24px; }
        .status-box .status-label { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #16a34a; margin-bottom: 6px; }
        .status-box .status-text { font-size: 15px; color: #15803d; font-weight: 600; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 28px; }
        .info-table tr td { padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #475569; }
        .info-table tr td:first-child { font-weight: 600; color: #1e293b; width: 45%; }
        .info-table tr:last-child td { border-bottom: none; }
        .notice { background: #fffbeb; border-left: 4px solid #f5a31a; border-radius: 0 8px 8px 0; padding: 14px 18px; margin-bottom: 28px; font-size: 13px; color: #92400e; line-height: 1.6; }
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
            <div class="badge">✓ Tanda Terima</div>
            <h1>TERANG NONA 2026</h1>
            <p>Kompetisi Inovasi Pelayanan Publik</p>
        </div>
        <div class="body">
            <div class="greeting">
                Kepada Yth. <strong>{{ $pengajuan->peserta->nama ?? 'Peserta' }}</strong>,
            </div>

            <div class="status-box">
                <div class="status-label">✅ Pengajuan Diterima</div>
                <div class="status-text">Proposal Anda telah berhasil disubmit dan sedang menunggu pemeriksaan Panitia.</div>
            </div>

            <table class="info-table">
                <tr>
                    <td>Nama Inovasi</td>
                    <td>{{ $pengajuan->nama_inovasi }}</td>
                </tr>
                <tr>
                    <td>Akronim</td>
                    <td>{{ $pengajuan->akronim ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Kategori</td>
                    <td>{{ $pengajuan->kategori->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Bentuk Inovasi</td>
                    <td>{{ ucfirst($pengajuan->bentuk_inovasi ?? '-') }}</td>
                </tr>
                <tr>
                    <td>Tanggal Submit</td>
                    <td>{{ now()->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }} WIB</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><span style="color:#16a34a; font-weight:600;">Menunggu Pemeriksaan Panitia</span></td>
                </tr>
            </table>

            <div class="notice">
                📋 <strong>Catatan:</strong> Panitia akan memeriksa kelengkapan dan kesesuaian dokumen pengajuan Anda. Jika ada kekurangan atau perlu perbaikan, Anda akan mendapatkan notifikasi email dari kami. Mohon pantau email Anda secara berkala.
            </div>

            <div class="btn-wrap">
                <a href="{{ url('/peserta/login') }}" class="btn">Pantau Status Pengajuan →</a>
            </div>
        </div>
        <div class="footer">
            <p class="org">Panitia TERANG NONA Disnakertrans Jateng</p>
            <p>Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah</p>
            <p style="margin-top:8px; color:#cbd5e1;">Email ini dikirim otomatis. Jangan balas email ini.</p>
        </div>
    </div>
</body>
</html>
