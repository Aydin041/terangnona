<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Akun Juri - Admin - TERANG NONA</title>
</head>
<body>
    <h1>Tambah Akun Juri</h1>
    <p><a href="{{ route('admin.akun.juri.index') }}">← Kembali</a></p>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.akun.juri.store') }}">
        @csrf

        <label>Nama Lengkap</label><br>
        <input type="text" name="nama" value="{{ old('nama') }}" required>
        <br><br>

        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required>
        <br><br>

        <label>Password (opsional — kosongkan untuk digenerate otomatis)</label><br>
        <input type="text" name="password" value="{{ old('password') }}" minlength="6">
        <br><br>

        <button type="submit">Buat Akun</button>
    </form>
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>