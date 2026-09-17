<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nilai Proposal - Juri - TERANG NONA</title>
</head>
<body>
    <p style="background: #eee; padding: 8px;">Login sebagai Juri: <strong>{{ $juri->nama }}</strong> ({{ $juri->email }})</p>

    <h1>Nilai Proposal — {{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</h1>
    <p><a href="{{ route('juri.penilaian.daftar.proposal') }}">← Kembali ke daftar</a></p>

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

    <h3>Dokumen Pengajuan</h3>
    @if ($dokumenPengajuan->isEmpty())
        <p style="color: red;">Belum ada dokumen yang diupload peserta.</p>
    @else
        <ul>
            @foreach ($dokumenPengajuan as $dok)
                <li>
                    <strong>{{ $dok->jenis_dokumen }}:</strong>
                    @if ($dok->jenis_dokumen === 'video_link')
                        <a href="{{ $dok->file_path }}" target="_blank">{{ $dok->file_path }}</a>
                    @else
                        {{ $dok->nama_asli }}
                        <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank">Lihat/Download</a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    <hr>

    <p><strong>Status penilaian:</strong> {{ $submission->status }}</p>

    @if ($submission->status === 'submitted' && !$adaBarisTerbuka)
        <p>
            <em>Penilaian sudah disubmit dan terkunci.</em>
            <a href="{{ route('juri.koreksi.proposal.form', $pengajuan->id) }}">Ajukan Koreksi Nilai</a>
        </p>
    @endif

    @if ($submission->status === 'submitted' && $adaBarisTerbuka)
        <div style="background: #fff3cd; padding: 10px; margin-bottom: 10px;">
            <strong>⚠ Ada komponen yang sedang dibuka untuk diperbaiki (disetujui Admin).</strong> Isi ulang komponen yang kosong di bawah, lalu klik "Konfirmasi Perbaikan".
        </div>
    @endif

    <form method="POST">
        @csrf

        @foreach ($komponenList as $komponen)
            @php $nilaiRow = $nilaiTersimpan[$komponen->id] ?? null; @endphp
            @php $isianRow = $isianList[$komponen->id] ?? null; @endphp
            <div style="border-bottom: 1px solid #ccc; padding: 10px 0;">
                <strong>{{ $komponen->nama }}</strong> — Bobot {{ $komponen->bobot }}%<br>

                @if (array_key_exists($komponen->id, \App\Http\Controllers\Peserta\PengajuanController::KOMPONEN_LAMPIRAN))
                    @php
                        $jenisDok = \App\Http\Controllers\Peserta\PengajuanController::KOMPONEN_LAMPIRAN[$komponen->id];
                        $dokLampiran = $dokumenKeyed[$jenisDok] ?? null;
                    @endphp
                    <div style="background: #f5f5f5; padding: 8px; margin: 8px 0;">
                        <strong>Lampiran dari Peserta:</strong><br>
                        @if ($dokLampiran)
                            {{ $dokLampiran->nama_asli }}
                            <a href="{{ asset('storage/' . $dokLampiran->file_path) }}" target="_blank">Lihat/Download</a>
                        @else
                            <span style="color: red;">Belum diupload peserta.</span>
                        @endif
                    </div>
                @else
                    <div style="background: #f5f5f5; padding: 8px; margin: 8px 0;">
                        <strong>Uraian dari Peserta:</strong>
                        @if ($isianRow && trim((string) $isianRow->uraian) !== '')
                            <p style="white-space: pre-wrap;">{{ $isianRow->uraian }}</p>
                        @else
                            <p style="color: red;">Belum diisi peserta.</p>
                        @endif

                        <strong>Link/Tautan Bukti Dukung:</strong><br>
                        @if ($isianRow && trim((string) $isianRow->link_bukti_dukung) !== '')
                            <a href="{{ $isianRow->link_bukti_dukung }}" target="_blank">{{ $isianRow->link_bukti_dukung }}</a>
                        @else
                            <span style="color: red;">Belum diisi peserta.</span>
                        @endif
                    </div>
                @endif

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
        @elseif ($adaBarisTerbuka)
            <br>
            <button type="submit" formaction="{{ route('juri.penilaian.proposal.perbaikan', $pengajuan->id) }}">Konfirmasi Perbaikan</button>
        @endif
    </form>
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>