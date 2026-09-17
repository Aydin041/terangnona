<!DOCTYPE html>
<html>
<head>
    <title>Login Panitia - TERANG NONA 2026</title>
</head>
<body>
    <h1>Login Panitia</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('panitia.login.submit') }}" id="formLoginPanitia">
        @csrf

        <div>
            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div>
            <label for="password">Password:</label><br>
            <input type="password" name="password" id="password" required>
        </div>

        <div>
            <button type="submit" id="btnLoginPanitia">Login</button>
        </div>
    </form>

    <script>
        document.getElementById('formLoginPanitia').addEventListener('submit', function () {
            document.getElementById('btnLoginPanitia').disabled = true;
            document.getElementById('btnLoginPanitia').innerText = 'Memproses...';
        });
    </script>
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>