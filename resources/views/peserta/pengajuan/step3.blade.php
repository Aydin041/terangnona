<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengajuan Baru - Langkah 3 - TERANG NONA</title>
</head>
<body>
    <h1>Pengajuan Baru — Langkah 3/5: Data Ketua & Anggota</h1>
    <p>{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</p>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('peserta.pengajuan.step3.submit', $pengajuan->id) }}">
        @csrf

        <h3>Ketua (terisi otomatis dari akun Anda)</h3>
        <div>
            <label>Nama Ketua</label><br>
            <input type="text" value="{{ $peserta->nama }}" disabled>
        </div>
        <div>
            <label>Kontak Ketua</label><br>
            <input type="text" value="{{ $peserta->kontak }}" disabled>
        </div>

        <h3>Anggota Tambahan (opsional)</h3>
        <div id="anggota-container">
            @foreach ($anggotaLain as $anggota)
                <div class="baris-anggota">
                    <label>Nama Anggota</label><br>
                    <input type="text" name="anggota_nama[]" value="{{ $anggota->nama }}"><br>
                    <label>Kontak Anggota</label><br>
                    <input type="text" name="anggota_kontak[]" value="{{ $anggota->kontak }}">
                    <br>
                    <button type="button" onclick="hapusAnggota(this)">Hapus</button>
                    <hr>
                </div>
            @endforeach
        </div>

        <button type="button" onclick="tambahAnggota()">+ Tambah Anggota</button>
        <br><br>

        <button type="submit">Lanjut ke Langkah 4</button>
    </form>

    <script>
        function tambahAnggota() {
            const container = document.getElementById('anggota-container');
            const div = document.createElement('div');
            div.className = 'baris-anggota';
            div.innerHTML = `
                <label>Nama Anggota</label><br>
                <input type="text" name="anggota_nama[]"><br>
                <label>Kontak Anggota</label><br>
                <input type="text" name="anggota_kontak[]">
                <br>
                <button type="button" onclick="hapusAnggota(this)">Hapus</button>
                <hr>
            `;
            container.appendChild(div);
        }

        function hapusAnggota(tombol) {
            const baris = tombol.closest('.baris-anggota');
            baris.remove();
        }
    </script>
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>