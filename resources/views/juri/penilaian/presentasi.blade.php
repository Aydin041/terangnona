<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nilai Presentasi - Juri - TERANG NONA</title>
</head>
<body>
    <h1>Nilai Presentasi & Wawancara — {{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</h1>
    <p><a href="{{ route('juri.penilaian.index') }}">← Kembali ke daftar</a></p>

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

    @if ($submission->status === 'submitted')
        <p><em>Penilaian sudah disubmit dan terkunci.</em></p>
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
                    {{ $submission->status === 'submitted' ? 'disabled' : '' }}>
                <br>

                <label>Catatan</label><br>
                <textarea name="catatan[{{ $kode }}]" rows="2" cols="50"
                    {{ $submission->status === 'submitted' ? 'disabled' : '' }}>{{ $nilaiRow->catatan ?? '' }}</textarea>
            </div>
        @endforeach

        @if ($submission->status !== 'submitted')
            <br>
            <button type="submit" formaction="{{ route('juri.penilaian.presentasi.draft', $pengajuan->id) }}">Simpan Draft</button>
            <button type="submit" formaction="{{ route('juri.penilaian.presentasi.submit', $pengajuan->id) }}">Submit Penilaian</button>
        @endif
    </form>
</body>
</html>