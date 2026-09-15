<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Akun Panitia - Admin - TERANG NONA</title>
</head>
<body>
    <h1>Kelola Akun Panitia</h1>
    <p>
        <a href="{{ route('admin.dashboard') }}">← Dashboard</a> |
        <a href="{{ route('admin.akun.juri.index') }}">Kelola Akun Juri</a>
    </p>

    @if (session('sukses'))
        <p style="color: green; background: #e0ffe0; padding: 10px;">{{ session('sukses') }}</p>
    @endif

    <p><a href="{{ route('admin.akun.panitia.create') }}"><button type="button">+ Tambah Akun Panitia</button></a></p>

    <hr>

    @if ($daftarPanitia->isEmpty())
        <p>Belum ada akun Panitia.</p>
    @else
        <ul>
            @foreach ($daftarPanitia as $item)
                <li>
                    <strong>{{ $item->nama }}</strong> — {{ $item->email }}
                    <a href="{{ route('admin.akun.panitia.reset.form', $item->id) }}"><button type="button">Reset Password</button></a>
                </li>
                <hr>
            @endforeach
        </ul>
    @endif
</body>
</html>