<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TERANG NONA 2026</title>
</head>
<body>

    <header style="padding: 20px; border-bottom: 2px solid #333;">
        <h1>TERANG NONA 2026</h1>
        <p>
            <!-- GANTI TEKS INI: tagline/nama panjang kompetisi sesuai dokumen resmi -->
            Kompetisi Inovasi Disnakertrans Provinsi Jawa Tengah
        </p>
    </header>

    <main style="padding: 20px; max-width: 800px;">

        <section style="margin-bottom: 30px;">
            <h2>Tentang TERANG NONA</h2>
            <p>
                <!-- GANTI TEKS INI: deskripsi/latar belakang kompetisi, 2-3 paragraf,
                     ambil dari dokumen panduan resmi -->
                [Deskripsi kompetisi belum diisi. Ganti paragraf ini dengan penjelasan
                singkat tentang apa itu TERANG NONA, tujuannya, dan siapa yang boleh ikut.]
            </p>
        </section>

        <section style="margin-bottom: 30px;">
            <h2>Jadwal Penting</h2>
            <!-- GANTI ISI TABEL INI sesuai jadwal resmi dari Panitia -->
            <table border="1" cellpadding="8" style="border-collapse: collapse;">
                <tr>
                    <th>Tahap</th>
                    <th>Tanggal</th>
                </tr>
                <tr>
                    <td>Pendaftaran & Pengajuan Proposal</td>
                    <td>[isi tanggal]</td>
                </tr>
                <tr>
                    <td>Penilaian Proposal oleh Juri</td>
                    <td>[isi tanggal]</td>
                </tr>
                <tr>
                    <td>Pengumuman 5 Besar</td>
                    <td>[isi tanggal]</td>
                </tr>
                <tr>
                    <td>Presentasi & Wawancara</td>
                    <td>[isi tanggal]</td>
                </tr>
                <tr>
                    <td>Pengumuman Juara</td>
                    <td>[isi tanggal]</td>
                </tr>
            </table>
        </section>

        <section style="margin-bottom: 30px;">
            <h2>Kategori Inovasi</h2>
            <ul>
                <!-- Ini sudah sesuai bentuk_inovasi yang dipakai di sistem, tidak perlu diganti
                     kecuali istilahnya mau disesuaikan dengan dokumen resmi -->
                <li>Eksisting (Inovasi yang sudah berjalan)</li>
                <li>Pengembangan (Inovasi yang sedang dikembangkan)</li>
                <li>Rancangan Inovasi (Ide/rancangan baru)</li>
            </ul>
        </section>

        <section style="margin-bottom: 30px; padding: 20px; background: #f5f5f5;">
            <h2>Ikut Kompetisi</h2>
            <p><a href="{{ route('peserta.register') }}">Daftar sebagai Peserta</a></p>
            <p><a href="{{ route('peserta.login') }}">Login Peserta</a></p>
        </section>

        <section style="margin-bottom: 30px;">
            <h2>Login Lainnya</h2>
            <p><a href="{{ route('juri.login') }}">Login Juri</a></p>
            <p><a href="{{ route('panitia.login') }}">Login Panitia</a></p>
        </section>

        <section style="margin-bottom: 30px;">
            <h2>Kontak</h2>
            <p>
                <!-- GANTI TEKS INI: kontak resmi Panitia (email/WA/telepon) -->
                [Kontak Panitia belum diisi. Ganti dengan email/nomor WhatsApp resmi.]
            </p>
        </section>

    </main>

    <footer style="padding: 20px; border-top: 1px solid #ccc; text-align: center; color: #666;">
        &copy; {{ date('Y') }} Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah
    </footer>

</body>
</html>