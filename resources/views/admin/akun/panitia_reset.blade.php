<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password Panitia - Admin - TERANG NONA</title>
</head>
<body>
    <h1>Reset Password — {{ $panitia->nama }}</h1>
    <p>{{ $panitia->email }}</p>
    <p><a href="{{ route('admin.akun.panitia.index') }}">← Kembali</a></p>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.akun.panitia.reset', $panitia->id) }}">
        @csrf

        <label>Password Baru (opsional — kosongkan untuk digenerate otomatis)</label><br>
        <input type="text" name="password" minlength="6">
        <br><br>

        <button type="submit">Reset Password</button>
    </form>
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>