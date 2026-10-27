<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TERANG NONA 2026 - Kompetisi Inovasi Disnakertrans Provinsi Jawa Tengah</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-surface font-sans text-ink antialiased">

@php
    // ---------- Jadwal dan status otomatis ----------
    $tz = config('jadwal.zona_waktu', 'Asia/Jakarta');
    $sekarang = \Carbon\Carbon::now($tz);
    try {
        $deadline = \App\Models\Pengaturan::ambil()->deadline_pengajuan;
    } catch (\Throwable $e) {
        // Database belum siap: halaman depan tetap tampil memakai jadwal dari config/jadwal.php.
        $deadline = null;
    }

    $tahapList = collect(config('jadwal.tahap'))->map(function ($t) use ($tz, $sekarang, $deadline) {
        $mulai = \Carbon\Carbon::parse($t['mulai'], $tz)->startOfDay();
        $selesai = \Carbon\Carbon::parse($t['selesai'], $tz)->endOfDay();

        // Batas akhir pendaftaran mengikuti Deadline Pengajuan di Pengaturan Admin (kalau diisi).
        if ($t['kunci'] === 'pendaftaran' && $deadline) {
            $selesai = \Carbon\Carbon::parse($deadline)->setTimezone($tz);
        }

        $t['mulai_c'] = $mulai;
        $t['selesai_c'] = $selesai;
        $t['status'] = $sekarang->lt($mulai) ? 'belum' : ($sekarang->gt($selesai) ? 'lewat' : 'berlangsung');

        $f = fn ($c, $pola) => $c->copy()->locale('id')->translatedFormat($pola);
        $sama = $mulai->isSameDay($selesai);
        $t['teks'] = $t['label'] ?? ($sama ? $f($mulai, 'j F Y') : $f($mulai, 'j F Y') . ' s/d ' . $f($selesai, 'j F Y'));
        $t['teks_ringkas'] = $t['ringkas'] ?? ($sama ? $f($mulai, 'j M') : $f($mulai, 'j M') . ' – ' . $f($selesai, 'j M'));

        return $t;
    });

    $daftar = $tahapList->firstWhere('kunci', 'pendaftaran');
    $statusDaftar = $daftar['status'];
    $sorotan = $tahapList->filter(fn ($t) => ! empty($t['sorot']))->values();

    $labelStatus = [
        'belum' => 'Belum dimulai',
        'berlangsung' => 'Sedang berlangsung',
        'lewat' => 'Sudah lewat',
    ];
@endphp

    {{-- ===================== BILAH ATAS ===================== --}}
    <header class="bg-brand-navy sticky top-0 z-30 border-b border-white/10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-4">
            <div class="flex items-center gap-8">
                <a href="{{ route('landing') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-terang-nona-emas.png') }}" alt="TERANG NONA" class="h-9 w-auto">
                    <span class="text-white font-bold tracking-tight">TERANG NONA</span>
                </a>
                <nav class="hidden md:flex items-center gap-6 text-sm text-slate-300">
                    <a href="#tentang" class="hover:text-white">Tentang</a>
                    <a href="#dokumentasi" class="hover:text-white">Dokumentasi</a>
                    <a href="#jadwal" class="hover:text-white">Jadwal</a>
                    <a href="#sekretariat" class="hover:text-white">Sekretariat</a>
                </nav>
            </div>

            <div class="relative">
                <button type="button" id="tombol-login"
                    class="flex items-center gap-1.5 text-sm font-semibold text-white border border-slate-500 hover:border-white rounded-xl px-4 py-2 transition-colors">
                    Login
                    <span aria-hidden="true" class="text-xs">▾</span>
                </button>
                <div id="menu-login" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-line py-1 z-40">
                    <a href="{{ route('peserta.login') }}" class="block px-4 py-2.5 text-sm font-semibold text-ink hover:bg-surface">Peserta</a>
                    <div class="my-1 border-t border-line"></div>
                    <a href="{{ route('panitia.login') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-surface">Panitia</a>
                    <a href="{{ route('juri.login') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-surface">Juri</a>
                    <a href="{{ route('pimpinan.login') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-surface">Pimpinan</a>
                    <a href="{{ route('admin.login') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-surface">Admin</a>
                </div>
            </div>
        </div>
    </header>

    {{-- ===================== HERO ===================== --}}
    <section class="bg-brand-navy bg-[radial-gradient(circle_at_75%_40%,#12295a_0%,#0a1431_65%)]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 pt-12 pb-24 flex flex-col lg:flex-row items-center lg:justify-between gap-10 text-center lg:text-left">

            <div class="order-2 lg:order-1 lg:flex-1">
                <p class="text-xs tracking-widest text-slate-300 uppercase">Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah</p>
                <h1 class="mt-3 text-4xl sm:text-5xl font-extrabold text-white leading-tight">
                    Kompetisi Inovasi <span class="text-brand-amber">TERANG NONA</span> 2026
                </h1>

                <div class="mt-6">
                    <span class="inline-block text-xs sm:text-sm font-semibold rounded-full border px-4 py-1.5 {{ $statusDaftar === 'berlangsung' ? 'border-brand-amber text-brand-amber' : 'border-slate-500 text-slate-300' }}">
                        @if ($statusDaftar === 'berlangsung')
                            Pendaftaran dibuka &middot; {{ $daftar['mulai_c']->copy()->locale('id')->translatedFormat('j F') }} &ndash; {{ $daftar['selesai_c']->copy()->locale('id')->translatedFormat('j F Y') }}
                        @elseif ($statusDaftar === 'belum')
                            Pendaftaran dibuka mulai {{ $daftar['mulai_c']->copy()->locale('id')->translatedFormat('j F Y') }}
                        @else
                            Pendaftaran ditutup &middot; {{ $daftar['selesai_c']->copy()->locale('id')->translatedFormat('j F Y') }}
                        @endif
                    </span>
                </div>

                <div class="mt-6 flex flex-wrap gap-3 justify-center lg:justify-start">
                    @if ($statusDaftar === 'berlangsung')
                        <a href="{{ route('peserta.register') }}"
                            class="bg-brand-amber hover:bg-brand-amber-dark text-brand-navy font-semibold rounded-xl px-6 py-3 transition-colors">
                            Daftar sebagai Peserta
                        </a>
                    @else
                        <span aria-disabled="true" class="bg-slate-700 text-slate-400 font-semibold rounded-xl px-6 py-3 cursor-not-allowed">
                            {{ $statusDaftar === 'belum' ? 'Pendaftaran Belum Dibuka' : 'Pendaftaran Ditutup' }}
                        </span>
                    @endif
                    <a href="#jadwal" class="border border-slate-500 hover:border-white text-white font-semibold rounded-xl px-6 py-3 transition-colors">
                        Lihat Jadwal
                    </a>
                </div>

                <p class="mt-8 text-sm italic text-slate-300 border-l-4 border-brand-amber pl-4 max-w-md mx-auto lg:mx-0 text-left">
                    Ngopeni lan Nglakoni Inovasi Ketenagakerjaan dan Ketransmigrasian Jawa Tengah
                </p>
            </div>

            <div class="order-1 lg:order-2 lg:flex-none">
                <img src="{{ asset('images/logo-terang-nona-emas.png') }}" alt="TERANG NONA 2026" class="h-52 lg:h-80 w-auto mx-auto">
            </div>
        </div>
    </section>

    {{-- ===================== TANGGAL PENTING (kartu di tepi hero) ===================== --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 -mt-12 relative z-10">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            @foreach ($sorotan as $s)
                <div class="bg-white border border-line rounded-2xl p-4 sm:p-5 shadow-sm">
                    <p class="text-lg sm:text-xl font-bold text-brand-blue">{{ $s['teks_ringkas'] }}</p>
                    <p class="text-sm text-slate-500 mt-0.5">{{ $s['sorot'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ===================== TENTANG ===================== --}}
    <section id="tentang" class="max-w-6xl mx-auto px-4 sm:px-6 pt-16">
        <div class="grid lg:grid-cols-2 gap-10">
            <div>
                <p class="text-xs font-bold tracking-widest text-brand-amber-dark uppercase">Tentang</p>
                <h2 class="text-3xl font-bold mt-1 mb-4">Tentang TERANG NONA 2026</h2>
                <div class="space-y-4 text-slate-600 leading-relaxed">
                    <p>
                        TERANG NONA (Tenaga Kerja dan Transmigrasi Innovation Awards) 2026 adalah ajang yang
                        digagas Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah sebagai sarana apresiasi
                        sekaligus wadah penjaringan karya inovatif terbaik yang lahir dari gagasan ASN, praktisi
                        industri, akademisi, hingga masyarakat luas.
                    </p>
                    <p>
                        Melalui TERANG NONA 2026 diharapkan terwujud ekosistem inovasi ketenagakerjaan dan
                        ketransmigrasian yang inklusif, kolaboratif, dan berkelanjutan di Jawa Tengah. Inovasi
                        terbaik yang terpilih akan diintegrasikan ke dalam program prioritas daerah.
                    </p>
                </div>
            </div>

            <div class="space-y-4 lg:pt-8">
                <div class="bg-white border border-line border-l-4 border-l-brand-amber rounded-2xl p-5">
                    <h3 class="font-bold text-brand-blue">Ngopeni</h3>
                    <p class="text-sm text-slate-600 mt-1">Memelihara, memfasilitasi, dan mendampingi setiap bibit inovasi agar berkembang optimal.</p>
                </div>
                <div class="bg-white border border-line border-l-4 border-l-brand-amber rounded-2xl p-5">
                    <h3 class="font-bold text-brand-blue">Nglakoni</h3>
                    <p class="text-sm text-slate-600 mt-1">Mewujudkan ide secara nyata dan konsisten hingga berdampak di lapangan.</p>
                </div>
            </div>
        </div>

        <h3 class="text-xl font-bold mt-12 mb-4">Tujuan</h3>
        <div class="grid md:grid-cols-3 gap-4">
            @php
                $tujuan = [
                    'Memberikan apresiasi dan penghargaan kepada inisiator/pengelola inovasi terbaik sektor ketenagakerjaan dan ketransmigrasian Jawa Tengah.',
                    'Menjadi sarana pertukaran dan pembelajaran praktik pengembangan dan pemanfaatan inovasi di lingkungan Disnakertrans Provinsi Jawa Tengah.',
                    'Menjaring, mendokumentasikan, membangun basis data, mendiseminasikan, dan mempromosikan inovasi ketenagakerjaan dan ketransmigrasian di Jawa Tengah.',
                ];
            @endphp
            @foreach ($tujuan as $i => $teks)
                <div class="bg-white border border-line rounded-2xl p-6">
                    <span class="w-8 h-8 rounded-lg bg-brand-blue text-white text-sm font-bold flex items-center justify-center mb-4">{{ $i + 1 }}</span>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $teks }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ===================== DOKUMENTASI ===================== --}}
    <section id="dokumentasi" class="bg-brand-navy mt-16 py-14">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <p class="text-xs font-bold tracking-widest text-brand-amber uppercase">Galeri</p>
            <h2 class="text-3xl font-bold text-brand-amber mt-1 mb-2">Dokumentasi Kegiatan</h2>
            <p class="text-slate-300 mb-8 max-w-2xl">
                Jejak keikutsertaan Disnakertrans Provinsi Jawa Tengah dalam ajang inovasi tingkat provinsi.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <figure>
                    <img src="{{ asset('images/dokumentasi-1.webp') }}"
                        alt="Gubernur Jawa Tengah menyerahkan penghargaan TOP 10 IDEA Jateng 2025 kepada Kepala Disnakertrans Jateng di Blora"
                        width="1600" height="1067" loading="lazy" decoding="async"
                        class="w-full h-auto aspect-[3/2] object-cover rounded-xl">
                    <figcaption class="mt-3">
                        <p class="text-sm font-semibold text-white">Penghargaan TOP 10 IDEA Jateng 2025 untuk inovasi SIK3</p>
                        <p class="text-sm text-slate-400">26 September 2025 &middot; Pameran Produk Inovasi Jawa Tengah, Lapangan Kridosono, Blora</p>
                    </figcaption>
                </figure>

                <figure>
                    <img src="{{ asset('images/dokumentasi-rapat.webp') }}"
                        alt="Peserta mengikuti presentasi dan wawancara inovasi PANDU GUNUNG melalui Zoom Meeting di ruang konferensi Disnakertrans"
                        width="1600" height="1067" loading="lazy" decoding="async"
                        class="w-full h-auto aspect-[3/2] object-cover rounded-xl">
                    <figcaption class="mt-3">
                        <p class="text-sm font-semibold text-white">Presentasi dan Wawancara Inovasi PANDU GUNUNG, Babak Final Kompetisi IDEA Jateng 2026</p>
                        <p class="text-sm text-slate-400">4 Juni 2026 &middot; Zoom Meeting</p>
                    </figcaption>
                </figure>
            </div>
        </div>
    </section>

    {{-- ===================== JADWAL ===================== --}}
    <section id="jadwal" class="max-w-6xl mx-auto px-4 sm:px-6 pt-16">
        <p class="text-xs font-bold tracking-widest text-brand-amber-dark uppercase">Jadwal</p>
        <h2 class="text-3xl font-bold mt-1 mb-3">Jadwal Penting</h2>

        <div class="flex flex-wrap items-center gap-x-5 gap-y-1 text-sm text-slate-500 mb-5">
            <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full border-2 border-line"></span> Belum dimulai</span>
            <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full border-2 border-brand-amber"></span> Sedang berlangsung</span>
            <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-brand-amber"></span> Sudah lewat</span>
            <span class="text-xs text-slate-400">Status berubah sendiri mengikuti tanggal.</span>
        </div>

        <ol class="grid md:grid-cols-2 gap-3">
            @foreach ($tahapList as $i => $t)
                <li class="bg-white border border-line rounded-2xl p-4 flex items-start gap-4 {{ $t['status'] === 'berlangsung' ? 'border-brand-amber ring-1 ring-brand-amber' : '' }}">
                    <span class="shrink-0 w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold
                        {{ $t['status'] === 'lewat' ? 'bg-brand-amber text-brand-navy' : ($t['status'] === 'berlangsung' ? 'border-2 border-brand-amber text-brand-amber-dark' : 'border-2 border-line text-slate-400') }}">
                        @if ($t['status'] === 'lewat') ✓ @else {{ $i + 1 }} @endif
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold leading-snug">{{ $t['nama'] }}</p>
                        <div class="mt-1.5 flex flex-wrap items-center gap-x-3 gap-y-1">
                            <span class="text-sm text-slate-500">{{ $t['teks'] }}</span>
                            @if ($t['status'] === 'berlangsung')
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800">{{ $labelStatus['berlangsung'] }}</span>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- ===================== SEKRETARIAT ===================== --}}
    <section id="sekretariat" class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
        <p class="text-xs font-bold tracking-widest text-brand-amber-dark uppercase">Kontak</p>
        <h2 class="text-3xl font-bold mt-1 mb-5">Sekretariat</h2>

        <div class="bg-white border border-line rounded-2xl p-6 sm:p-8 grid md:grid-cols-2 gap-6">
            <div>
                <p class="font-semibold">Sub Bagian Umum dan Kepegawaian</p>
                <p class="text-sm text-slate-600 mt-1">Sekretariat Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah</p>
            </div>
            <div>
                <p class="font-semibold">Alamat &amp; Email</p>
                <p class="text-sm text-slate-600 mt-1">Jalan Pahlawan No.16, Pleburan, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50241</p>
                <a href="mailto:terangnonakertransprovjateng@gmail.com" class="text-sm font-semibold text-brand-blue hover:underline break-all">terangnonakertransprovjateng@gmail.com</a>
            </div>
        </div>
    </section>

    @include('layouts._footer', ['padding' => 'py-5'])

    <script>
        (function () {
            const tombol = document.getElementById('tombol-login');
            const menu = document.getElementById('menu-login');

            tombol.addEventListener('click', function (e) {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });
            document.addEventListener('click', function (e) {
                if (!menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });
        })();
    </script>
</body>
</html>