<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ajukan Koreksi Nilai Presentasi - Juri - TERANG NONA</title>
</head>
<body>
    <h1>Ajukan Koreksi Nilai Presentasi</h1>
    <p>{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</p>
    <p><a href="{{ route('juri.penilaian.presentasi', $pengajuan->id) }}">← Kembali ke penilaian</a></p>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('sukses'))
        <p style="color: green;">{{ session('sukses') }}</p>
    @endif

    <h3>Nilai Anda Saat Ini (Terkunci)</h3>
    <ul>
        @foreach ($nilaiTerkunci as $nilai)
            <li>
                {{ $aspekLabel[$nilai->aspek] }}: <strong>{{ $nilai->nilai }}</strong>
                @if (in_array($nilai->aspek, $permintaanAktif))
                    <span style="color: orange;"> — [Permintaan koreksi sedang menunggu Admin]</span>
                @endif
            </li>
        @endforeach
    </ul>

    <hr>

    <h3>Ajukan Koreksi</h3>
    <form method="POST" action="{{ route('juri.koreksi.presentasi.submit', $pengajuan->id) }}">
        @csrf

        <label>Pilih aspek yang salah</label><br>
        <select name="aspek" required>
            <option value="">-- Pilih Aspek --</option>
            @foreach ($nilaiTerkunci as $nilai)
                <option value="{{ $nilai->aspek }}">
                    {{ $aspekLabel[$nilai->aspek] }} (nilai saat ini: {{ $nilai->nilai }})
                </option>
            @endforeach
        </select>
        <br><br>

        <label>Alasan koreksi</label><br>
        <textarea name="alasan" rows="3" cols="50" required></textarea>
        <br><br>

        <button type="submit">Kirim Permintaan ke Admin</button>
    </form>
</body>
</html>