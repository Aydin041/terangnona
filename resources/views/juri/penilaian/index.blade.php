<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Penilaian - Juri - TERANG NONA</title>
</head>
<body>
    <h1>Daftar Penilaian</h1>
    <p style="background: #eee; padding: 8px;">Login sebagai Juri: <strong>{{ Auth::guard('juri')->user()->nama }}</strong> ({{ Auth::guard('juri')->user()->email }})</p>

    <form method="POST" action="{{ route('juri.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    @if (session('sukses'))
        <p style="color: green;">{{ session('sukses') }}</p>
    @endif

    <hr>

    <h2>Pilih Jenis Penilaian</h2>
    <ul>
        <li><a href="{{ route('juri.penilaian.daftar.proposal') }}">Penilaian Proposal</a></li>
        <li><a href="{{ route('juri.penilaian.daftar.presentasi') }}">Penilaian Presentasi (Lolos 5 Besar)</a></li>
    </ul>
    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>
