<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal Siap Dinilai</title>
    <style>
        body { margin: 0; padding: 0; background: #f4f6f9; font-family: 'Segoe UI', Arial, sans-serif; }
        .wrapper { max-width: 600px; margin: 32px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #0a1431 0%, #1a2d6b 100%); padding: 36px 32px; text-align: center; }
        .header .badge { display: inline-block; background: #f5a31a; color: #0a1431; font-weight: 700; font-size: 11px; letter-spacing: 2px; padding: 4px 14px; border-radius: 20px; text-transform: uppercase; margin-bottom: 14px; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 0 4px; }
        .header p { color: #94a3c0; font-size: 13px; margin: 0; }
        .body { padding: 36px 32px; }
        .greeting { font-size: 16px; color: #1e293b; margin-bottom: 20px; }
        .status-box { background: #f8fafc; border: 2px solid #0a1431; border-radius: 10px; padding: 20px 24px; margin-bottom: 24px; }
        .status-box .status-label { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #0a1431; margin-bottom: 6px; }
        .status-box .status-text { font-size: 15px; color: #1e293b; font-weight: 600; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 28px; }
        .info-table tr td { padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #475569; }
        .info-table tr td:first-child { font-weight: 600; color: #1e293b; width: 42%; }
        .info-table tr:last-child td { border-bottom: none; }
        .notice { background: #eff6ff; border-left: 4px solid #3b82f6; border-radius: 0 8px 8px 0; padding: 14px 18px; margin-bottom: 28px; font-size: 13px; color: #1e40af; line-height: 1.6; }
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
            <div class="badge">Dewan Juri</div>
            <h1>TERANG NONA 2026</h1>
            <p>Pemberitahuan Penilaian Proposal</p>
        </div>
        <div class="body">
            <div class="greeting">
                Yth. <strong>Bapak/Ibu Dewan Juri TERANG NONA</strong>,
            </div>

            <div class="status-box">
                <div class="status-label">⚖️ Proposal Siap Dinilai</div>
                <div class="status-text">Terdapat proposal inovasi baru yang telah disetujui verifikasi administrasinya oleh Panitia dan kini siap untuk dinilai.</div>
            </div>

            <table class="info-table">
                <tr>
                    <td>Nama Inovasi</td>
                    <td><strong>{{ $pengajuan->nama_inovasi }}</strong></td>
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
                    <td>Instansi / Inovator</td>
                    <td>{{ $pengajuan->peserta->nama ?? '-' }}</td>
                </tr>
            </table>

            <div class="notice">
                📌 <strong>Informasi Penilaian:</strong> Silakan masuk ke portal Juri untuk membaca rincian uraian komponen, dokumen bukti dukung, dan tautan video inovasi, kemudian memberikan nilai sesuai rubrik penilaian yang berlaku.
            </div>

            <div class="btn-wrap">
                <a href="{{ route('juri.login') }}" class="btn">Masuk &amp; Beri Penilaian →</a>
            </div>
        </div>
        <div class="footer">
            <p class="org">Panitia TERANG NONA Disnakertrans Jateng</p>
            <p>Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah</p>
        </div>
    </div>
</body>
</html>
