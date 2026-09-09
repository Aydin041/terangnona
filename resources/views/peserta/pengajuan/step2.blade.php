<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengajuan Baru - Langkah 2 - TERANG NONA</title>
</head>
<body>
    <h1>Pengajuan Baru — Langkah 2/5: Bentuk Inovasi</h1>
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

    <form method="POST" action="{{ route('peserta.pengajuan.step2.submit', $pengajuan->id) }}">
        @csrf

        <div>
            <label>
                <input type="radio" name="bentuk_inovasi" value="eksisting" required>
                Inovasi Eksisting (sudah berjalan minimal 1 tahun)
            </label>
        </div>
        <div>
            <label>
                <input type="radio" name="bentuk_inovasi" value="pengembangan" required>
                Pengembangan Inovasi
            </label>
        </div>
        <div>
            <label>
                <input type="radio" name="bentuk_inovasi" value="rancangan" required>
                Rancangan Inovasi (baru)
            </label>
        </div>

        <button type="submit">Lanjut ke Langkah 3</button>
    </form>
</body>
</html>