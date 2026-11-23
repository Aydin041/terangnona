<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Ditolak</title>
    <style>
        body { margin: 0; padding: 0; background: #f4f6f9; font-family: 'Segoe UI', Arial, sans-serif; }
        .wrapper { max-width: 600px; margin: 32px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #0a1431 0%, #1a2d6b 100%); padding: 36px 32px; text-align: center; }
        .header .badge { display: inline-block; background: #ef4444; color: #fff; font-weight: 700; font-size: 11px; letter-spacing: 2px; padding: 4px 14px; border-radius: 20px; text-transform: uppercase; margin-bottom: 14px; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 0 4px; }
        .header p { color: #94a3c0; font-size: 13px; margin: 0; }
        .body { padding: 36px 32px; }
        .greeting { font-size: 16px; color: #1e293b; margin-bottom: 20px; }
        .greeting strong { color: #0a1431; }
        .status-box { background: #fef2f2; border: 2px solid #ef4444; border-radius: 10px; padding: 20px 24px; margin-bottom: 24px; }
        .status-box .status-label { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #dc2626; margin-bottom: 6px; }
        .status-box .status-text { font-size: 15px; color: #991b1b; font-weight: 600; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .info-table tr td { padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #475569; }
        .info-table tr td:first-child { font-weight: 600; color: #1e293b; width: 45%; }
        .info-table tr:last-child td { border-bottom: none; }
        .catatan-box { background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: 20px 24px; margin-bottom: 28px; }
        .catatan-box .catatan-label { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #dc2626; margin-bottom: 10px; }
        .catatan-box .catatan-isi { font-size: 14px; color: #7f1d1d; line-height: 1.7; white-space: pre-line; }
        .notice { background: #f8fafc; border-left: 4px solid #94a3b8; border-radius: 0 8px 8px 0; padding: 14px 18px; margin-bottom: 28px; font-size: 13px; color: #475569; line-height: 1.6; }
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
            <div class="badge">✗ Ditolak</div>
            <h1>TERANG NONA 2026</h1>
            <p>Kompetisi Inovasi Pelayanan Publik</p>
        </div>
        <div class="body">
            <div class="greeting">
                Kepada Yth. <strong>{{ $pengajuan->peserta->nama ?? 'Peserta' }}</strong>,
            </div>

            <div class="status-box">
                <div class="status-label">✗ Pengajuan Ditolak</div>
                <div class="status-text">Mohon maaf, setelah dilakukan pemeriksaan, pengajuan Anda tidak dapat diterima pada kompetisi TERANG NONA tahun ini.</div>
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
                    <td>Status</td>
                    <td><span style="color:#dc2626; font-weight:600;">✗ Ditolak</span></td>
                </tr>
            </table>

            <div class="catatan-box">
                <div class="catatan-label">📝 Alasan dari Panitia</div>
                <div class="catatan-isi">{{ $catatan }}</div>
            </div>

            <div class="notice">
                ℹ <strong>Informasi:</strong> Jika Anda memiliki pertanyaan lebih lanjut mengenai keputusan ini, silakan hubungi Panitia TERANG NONA melalui kanal resmi Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah. Kami menghargai partisipasi Anda dalam kompetisi inovasi ini.
            </div>

            <div class="btn-wrap">
                <a href="{{ url('/peserta/login') }}" class="btn">Lihat Portal Peserta →</a>
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
