<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Panitia - TERANG NONA 2026</title>
</head>
<body>
    <h1>Dashboard Panitia</h1>
    <p>Login berhasil. Selamat datang, {{ Auth::guard('panitia')->user()->nama }}.</p>
    <p>Fitur daftar pengajuan menyusul.</p>

    <form method="POST" action="{{ route('panitia.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>