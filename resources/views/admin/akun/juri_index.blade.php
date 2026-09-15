<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Akun Juri - Admin - TERANG NONA</title>
</head>
<body>
    <h1>Kelola Akun Juri</h1>
    <p>
        <a href="{{ route('admin.dashboard') }}">← Dashboard</a> |
        <a href="{{ route('admin.akun.panitia.index') }}">Kelola Akun Panitia</a>
    </p>

    @if (session('sukses'))
        <p style="color: green; background: #e0ffe0; padding: 10px;">{{ session('sukses') }}</p>
    @endif

    <p><a href="{{ route('admin.akun.juri.create') }}"><button type="button">+ Tambah Akun Juri</button></a></p>

    <hr>

    @if ($daftarJuri->isEmpty())
        <p>Belum ada akun Juri.</p>
    @else
        <ul>
            @foreach ($daftarJuri as $item)
                <li>
                    <strong>{{ $item->nama }}</strong> — {{ $item->email }}
                    <form method="POST" action="{{ route('admin.akun.juri.reset', $item->id) }}" style="display: inline;"
                        onsubmit="return confirm('Reset password untuk {{ $item->nama }}?');">
                        @csrf
                        <button type="submit">Reset Password</button>
                    </form>
                </li>
                <hr>
            @endforeach
        </ul>
    @endif
</body>
</html>