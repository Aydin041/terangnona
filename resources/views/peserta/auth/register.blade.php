<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Peserta - TERANG NONA</title>
</head>
<body>
    <h1>Registrasi Peserta</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('peserta.register.submit') }}">
        @csrf

        <div>
            <label>Nama Lengkap</label><br>
            <input type="text" name="nama" value="{{ old('nama') }}" required>
        </div>

        <div>
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label>Nomor Kontak/WA</label><br>
            <input type="text" name="kontak" value="{{ old('kontak') }}" required>
        </div>

        <div>
            <label>Password (minimal 8 karakter)</label><br>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Konfirmasi Password</label><br>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('peserta.login') }}">Login di sini</a></p>
</body>
</html>