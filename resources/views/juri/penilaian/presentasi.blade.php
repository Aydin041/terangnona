<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nilai Presentasi - Juri - TERANG NONA</title>
</head>
<body>
    <h1>Nilai Presentasi & Wawancara — {{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</h1>
    <p style="background: #eee; padding: 8px;">Login sebagai Juri: <strong>{{ $juri->nama }}</strong> ({{ $juri->email }})</p>
    <p><a href="{{ route('juri.penilaian.daftar.presentasi') }}">← Kembali ke daftar</a></p>

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

    <p><strong>Status penilaian:</strong> {{ $submission->status }}</p>

    <p>
        <strong>Link Zoom/Meet Presentasi:</strong>
        @if ($pengajuan->link_presentasi)
            <a href="{{ $pengajuan->link_presentasi }}" target="_blank">{{ $pengajuan->link_presentasi }}</a>
        @else
            <span style="color: red;">Belum diisi Panitia.</span>
        @endif
    </p>

    @if ($submission->status === 'submitted' && !$adaBarisTerbuka)
        <p>
            <em>Penilaian sudah disubmit dan terkunci.</em>
            <a href="{{ route('juri.koreksi.presentasi.form', $pengajuan->id) }}">Ajukan Koreksi Nilai</a>
        </p>
    @endif

    @if ($submission->status === 'submitted' && $adaBarisTerbuka)
        <div style="background: #fff3cd; padding: 10px; margin-bottom: 10px;">
            <strong>⚠ Ada aspek yang sedang dibuka untuk diperbaiki (disetujui Admin).</strong> Isi ulang aspek yang kosong di bawah, lalu klik "Konfirmasi Perbaikan".
        </div>
    @endif

    <form method="POST">
        @csrf

        @foreach ($aspekList as $kode => $label)
            @php $nilaiRow = $nilaiTersimpan[$kode] ?? null; @endphp
            <div style="border-bottom: 1px solid #ccc; padding: 10px 0;">
                <strong>{{ $label }}</strong><br>

                <label>Nilai (0-100)</label><br>
                <input type="number" name="nilai[{{ $kode }}]" min="0" max="100"
                    value="{{ $nilaiRow->nilai ?? '' }}"
                    {{ ($nilaiRow && $nilaiRow->terkunci) ? 'disabled' : '' }}>
                <br>

                <label>Catatan</label><br>
                <textarea name="catatan[{{ $kode }}]" rows="2" cols="50"
                    {{ ($nilaiRow && $nilaiRow->terkunci) ? 'disabled' : '' }}>{{ $nilaiRow->catatan ?? '' }}</textarea>
            </div>
        @endforeach

        @if ($submission->status !== 'submitted')
            <br>
            <button type="submit" formaction="{{ route('juri.penilaian.presentasi.draft', $pengajuan->id) }}">Simpan Draft</button>
            <button type="submit" formaction="{{ route('juri.penilaian.presentasi.submit', $pengajuan->id) }}">Submit Penilaian</button>
        @elseif ($adaBarisTerbuka)
            <br>
            <button type="submit" formaction="{{ route('juri.penilaian.presentasi.perbaikan', $pengajuan->id) }}">Konfirmasi Perbaikan</button>
        @endif
    </form>
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>