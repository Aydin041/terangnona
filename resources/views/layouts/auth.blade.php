<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - TERANG NONA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="min-h-screen flex flex-col bg-surface font-sans text-ink antialiased">

    <main class="flex-1 grid lg:grid-cols-2">
        {{-- Panel kiri (layar lebar): latar biru tua, memakai logo versi tulisan emas --}}
        <div class="hidden lg:flex items-center justify-center bg-brand-navy bg-[radial-gradient(circle_at_center,#12295a_0%,#0a1431_70%)]">
            <a href="{{ route('landing') }}">
                <img src="{{ asset('images/logo-terang-nona-emas.png') }}" alt="TERANG NONA" class="w-80 max-w-full">
            </a>
        </div>

        <div class="flex items-center justify-center px-4 py-10">
            <div class="w-full max-w-md">
                {{-- Layar HP: logo di atas kartu, latar terang, memakai logo versi tulisan gelap --}}
                <div class="lg:hidden text-center mb-6">
                    <a href="{{ route('landing') }}">
                        <img src="{{ asset('images/logo-terang-nona-transparan.png') }}" alt="TERANG NONA" class="h-20 mx-auto">
                    </a>
                </div>
                <div class="bg-white border border-line rounded-2xl p-8 shadow-sm">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    @include('layouts._footer')

    <script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</body>
</html>