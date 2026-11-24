<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Buka Kunci Nilai</title>
    <style>
        body { margin: 0; padding: 0; background: #f4f6f9; font-family: 'Segoe UI', Arial, sans-serif; }
        .wrapper { max-width: 600px; margin: 32px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #0a1431 0%, #1a2d6b 100%); padding: 36px 32px; text-align: center; }
        .header .badge { display: inline-block; background: #f5a31a; color: #0a1431; font-weight: 700; font-size: 11px; letter-spacing: 2px; padding: 4px 14px; border-radius: 20px; text-transform: uppercase; margin-bottom: 14px; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 0 4px; }
        .header p { color: #94a3c0; font-size: 13px; margin: 0; }
        .body { padding: 36px 32px; }
        .greeting { font-size: 16px; color: #1e293b; margin-bottom: 20px; }
        .status-box { background: #fffbeb; border: 2px solid #f5a31a; border-radius: 10px; padding: 20px 24px; margin-bottom: 24px; }
        .status-box .status-label { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #d97706; margin-bottom: 6px; }
        .status-box .status-text { font-size: 15px; color: #92400e; font-weight: 600; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .info-table tr td { padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #475569; }
        .info-table tr td:first-child { font-weight: 600; color: #1e293b; width: 42%; }
        .info-table tr:last-child td { border-bottom: none; }
        .alasan-box { background: #fff7ed; border: 1px solid #fed7aa; border-radius: 10px; padding: 18px 20px; margin-bottom: 28px; }
        .alasan-box .alasan-label { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #c2410c; margin-bottom: 8px; }
        .alasan-box .alasan-isi { font-size: 14px; color: #431407; line-height: 1.6; white-space: pre-line; }
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
            <div class="badge">Admin Panel</div>
            <h1>TERANG NONA 2026</h1>
            <p>Permohonan Koreksi Nilai Juri</p>
        </div>
        <div class="body">
            <div class="greeting">
                Halo <strong>Administrator TERANG NONA</strong>,
            </div>

            <div class="status-box">
                <div class="status-label">🔓 Permohonan Buka Kunci Nilai</div>
                <div class="status-text">Terdapat permohonan buka kunci penilaian dari Dewan Juri yang menunggu persetujuan Anda di Dashboard Admin.</div>
            </div>

            <table class="info-table">
                <tr>
                    <td>Nama Juri</td>
                    <td><strong>{{ $permintaan->juri->nama ?? '-' }}</strong> ({{ $permintaan->juri->email ?? '-' }})</td>
                </tr>
                <tr>
                    <td>Nama Inovasi</td>
                    <td>{{ $permintaan->pengajuan->nama_inovasi ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Tahap Penilaian</td>
                    <td><strong style="text-transform: capitalize;">{{ $permintaan->tahap }}</strong></td>
                </tr>
                <tr>
                    <td>Komponen / Aspek</td>
                    <td>{{ $permintaan->tahap === 'proposal' ? ($permintaan->komponen->nama ?? '-') : ucfirst(str_replace('_', ' ', $permintaan->aspek)) }}</td>
                </tr>
                <tr>
                    <td>Waktu Pengajuan</td>
                    <td>{{ now()->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }} WIB</td>
                </tr>
            </table>

            <div class="alasan-box">
                <div class="alasan-label">📝 Alasan Permohonan dari Juri:</div>
                <div class="alasan-isi">{{ $permintaan->alasan }}</div>
            </div>

            <div class="btn-wrap">
                <a href="{{ route('admin.dashboard') }}" class="btn">Buka Dashboard &amp; Proses →</a>
            </div>
        </div>
        <div class="footer">
            <p class="org">Sistem Informasi TERANG NONA</p>
            <p>Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah</p>
        </div>
    </div>
</body>
</html>
