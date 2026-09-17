<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Saya - TERANG NONA</title>
</head>
<body>
    <h1>Dashboard Saya</h1>

    <form method="POST" action="{{ route('peserta.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    @if (session('sukses'))
        <p style="color: green;">{{ session('sukses') }}</p>
    @endif

    <hr>

    @if ($daftarPengajuan->isEmpty())
        <p>Belum ada pengajuan. Mulai pengajuan baru untuk mengikuti TERANG NONA 2026.</p>
    @else
        <ul>
            @foreach ($daftarPengajuan as $item)
                <li>
                    <strong>{{ $item->nama_inovasi }} ({{ $item->akronim }})</strong><br>
                    Status: {{ $item->status }}

                    @if ($item->status === 'draft')
                        <div style="margin-top: 5px;">
                            <a href="{{ route('peserta.pengajuan.step1.edit', $item->id) }}">
                                <button type="button">Lanjutkan Pengajuan</button>
                            </a>
                        </div>
                    @endif

                    @if ($item->link_presentasi)
                        <div style="background: #e0f0ff; padding: 8px; margin-top: 5px;">
                            <strong>Link Zoom/Meet Presentasi:</strong>
                            <a href="{{ $item->link_presentasi }}" target="_blank">{{ $item->link_presentasi }}</a>
                        </div>
                    @endif

                    @if ($item->status === 'perlu_perbaikan')
                        <div style="background: #ffe0e0; padding: 8px; margin-top: 5px;">
                            <strong>Alasan dari Panitia:</strong><br>
                            {{ $catatanPengembalian[$item->id] ?? '(tidak ada catatan)' }}
                            <br>
                            <a href="{{ route('peserta.pengajuan.step1.edit', $item->id) }}">
                                <button type="button">Perbaiki Pengajuan Ini</button>
                            </a>
                        </div>
                    @endif
                </li>
                <hr>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('peserta.pengajuan.step1') }}">
        <button type="button">+ Buat Pengajuan Baru</button>
    </a>
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>