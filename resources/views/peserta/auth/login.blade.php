<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Peserta - TERANG NONA</title>
</head>
<body>
    <h1>Login Peserta</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('peserta.login.submit') }}">
        @csrf

        <div>
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label>Password</label><br>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Masuk</button>
    </form>

    <p>Belum punya akun? <a href="{{ route('peserta.register') }}">Daftar di sini</a></p>
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>