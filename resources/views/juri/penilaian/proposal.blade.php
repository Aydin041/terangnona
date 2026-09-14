<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nilai Proposal - Juri - TERANG NONA</title>
</head>
<body>
    <h1>Nilai Proposal — {{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</h1>
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
        <p>
            <em>Penilaian sudah disubmit dan terkunci.</em>
            <a href="{{ route('juri.koreksi.proposal.form', $pengajuan->id) }}">Ajukan Koreksi Nilai</a>
        </p>
    @endif

    <form method="POST">
        @csrf

        @foreach ($komponenList as $komponen)
            @php $nilaiRow = $nilaiTersimpan[$komponen->id] ?? null; @endphp
            <div style="border-bottom: 1px solid #ccc; padding: 10px 0;">
                <strong>{{ $komponen->nama }}</strong> — Bobot {{ $komponen->bobot }}%<br>

                <label>Nilai (0-100)</label><br>
                <input type="number" name="nilai[{{ $komponen->id }}]" min="0" max="100"
                    value="{{ $nilaiRow->nilai ?? '' }}"
                    {{ ($nilaiRow && $nilaiRow->terkunci) ? 'disabled' : '' }}>
                <br>

                <label>Saran/Masukan/Catatan</label><br>
                <textarea name="komentar[{{ $komponen->id }}]" rows="2" cols="50"
                    {{ ($nilaiRow && $nilaiRow->terkunci) ? 'disabled' : '' }}>{{ $nilaiRow->komentar ?? '' }}</textarea>
            </div>
        @endforeach

        @if ($submission->status !== 'submitted')
            <br>
            <button type="submit" formaction="{{ route('juri.penilaian.proposal.draft', $pengajuan->id) }}">Simpan Draft</button>
            <button type="submit" formaction="{{ route('juri.penilaian.proposal.submit', $pengajuan->id) }}">Submit Penilaian</button>
        @endif
    </form>
</body>
</html>