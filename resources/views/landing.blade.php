<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TERANG NONA 2026</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-stone-50 text-slate-800">

    <header class="bg-slate-900">
        <div class="px-6 sm:px-10 py-4 flex items-center justify-end">
            <div class="relative">
                <button type="button" onclick="document.getElementById('menu-login').classList.toggle('hidden')"
                    class="flex items-center gap-1 text-sm text-white/90 hover:text-white border border-slate-600 hover:border-slate-400 rounded-lg px-4 py-2 transition-colors">
                    Login
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="menu-login" class="hidden absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg border border-stone-200 py-1 z-20">
                    <a href="{{ route('peserta.login') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-stone-100">Peserta</a>
                    <a href="{{ route('panitia.login') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-stone-100">Panitia</a>
                    <a href="{{ route('juri.login') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-stone-100">Juri</a>
                    <a href="{{ route('admin.login') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-stone-100">Admin</a>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('click', function (e) {
                const menu = document.getElementById('menu-login');
                const tombol = e.target.closest('button');
                if (!menu.contains(e.target) && !(tombol && tombol.getAttribute('onclick'))) {
                    menu.classList.add('hidden');
                }
            });
        </script>

        <!-- Hero: HP = satu kolom (logo di atas, teks di bawah); desktop (lg) = teks kiri, logo kanan -->
        <div class="max-w-6xl mx-auto px-6 sm:px-10 pb-16 pt-4 flex flex-col lg:flex-row items-center lg:justify-between gap-8 lg:gap-12 text-center lg:text-left">

            <div class="order-1 lg:order-2 lg:flex-none">
                <img src="{{ asset('images/logo-terang-nona-emas.png') }}" alt="TERANG NONA 2026" class="h-48 lg:h-72 w-auto mx-auto">
            </div>

            <div class="order-2 lg:order-1 lg:flex-1">
            <p class="text-slate-100 text-xl sm:text-2xl lg:text-3xl font-semibold leading-snug max-w-xl mx-auto lg:mx-0">
                <!-- GANTI TEKS INI: tagline/nama panjang kompetisi sesuai dokumen resmi -->
                Kompetisi Inovasi Disnakertrans Provinsi Jawa Tengah
            </p>
            @php
                // Periode pendaftaran (WIB). Kalau jadwal berubah, cukup ubah tiga baris ini.
                $tz = 'Asia/Jakarta';
                $buka = \Carbon\Carbon::create(2026, 8, 31, 0, 0, 0, $tz);
                $tutup = \Carbon\Carbon::create(2026, 10, 31, 23, 59, 59, $tz);
                $sekarang = \Carbon\Carbon::now($tz);

                if ($sekarang->lt($buka)) {
                    $status = 'belum';
                } elseif ($sekarang->gt($tutup)) {
                    $status = 'tutup';
                } else {
                    $status = 'buka';
                }
            @endphp

            <div class="mt-6">
                <span class="inline-block text-xs sm:text-sm leading-relaxed border rounded-2xl px-4 py-1.5
                    {{ $status === 'buka' ? 'border-amber-500 text-amber-400' : 'border-slate-500 text-slate-300' }}">
                    @if ($status === 'buka')
                        Pendaftaran dibuka &middot; 31 Agustus &ndash; 31 Oktober 2026
                    @elseif ($status === 'belum')
                        Pendaftaran dibuka mulai 31 Agustus 2026
                    @else
                        Pendaftaran ditutup &middot; 31 Oktober 2026
                    @endif
                </span>
            </div>

            <div class="mt-6 flex flex-wrap gap-3 justify-center lg:justify-start">
                @if ($status === 'buka')
                    <a href="{{ route('peserta.register') }}"
                        class="bg-amber-500 hover:bg-amber-400 text-slate-900 font-semibold rounded-lg px-5 py-2.5 transition-colors">
                        Daftar sebagai Peserta
                    </a>
                @else
                    <span aria-disabled="true"
                        class="bg-slate-700 text-slate-400 font-semibold rounded-lg px-5 py-2.5 cursor-not-allowed">
                        {{ $status === 'belum' ? 'Pendaftaran Belum Dibuka' : 'Pendaftaran Ditutup' }}
                    </span>
                @endif
                <a href="#jadwal"
                    class="border border-slate-500 hover:border-slate-300 text-slate-200 rounded-lg px-5 py-2.5 transition-colors">
                    Lihat Jadwal
                </a>
            </div>

            <p class="mt-8 text-sm italic text-slate-400 max-w-xl mx-auto lg:mx-0">
                Ngopeni lan Nglakoni Inovasi Ketenagakerjaan dan Ketransmigrasian Jawa Tengah
            </p>
            </div>
        </div>
    </header>

    <main>

        <div class="max-w-4xl mx-auto px-6">

        <section class="py-14 border-b border-stone-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-3">Tentang TERANG NONA 2026</h2>
            <!-- Sumber: Latar Belakang dan Maksud/Tujuan dari dokumen panduan resmi (diringkas) -->
            <div class="space-y-4 text-slate-600 leading-relaxed max-w-2xl">
                <p>
                    TERANG NONA (Tenaga Kerja dan Transmigrasi Innovation Awards) 2026 adalah ajang yang
                    digagas Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah sebagai sarana apresiasi
                    sekaligus wadah penjaringan karya inovatif terbaik yang lahir dari gagasan ASN, praktisi
                    industri, akademisi, hingga masyarakat luas.
                </p>
                <p>
                    Ajang ini mengusung filosofi lokal
                    <em>&ldquo;Ngopeni lan Nglakoni Inovasi Ketenagakerjaan dan Ketransmigrasian Jawa Tengah&rdquo;</em>.
                    <em>Ngopeni</em> berarti memelihara, memfasilitasi, dan mendampingi setiap bibit inovasi agar
                    berkembang optimal. <em>Nglakoni</em> berarti mewujudkan ide secara nyata dan konsisten hingga
                    berdampak di lapangan.
                </p>
                <p>
                    Melalui TERANG NONA 2026 diharapkan terwujud ekosistem inovasi ketenagakerjaan dan
                    ketransmigrasian yang inklusif, kolaboratif, dan berkelanjutan di Jawa Tengah. Inovasi
                    terbaik yang terpilih akan diintegrasikan ke dalam program prioritas daerah.
                </p>
            </div>

            <h3 class="text-lg font-semibold text-slate-900 mt-8 mb-2">Tujuan</h3>
            <ul class="list-disc pl-5 space-y-1 text-slate-600 leading-relaxed max-w-2xl">
                <li>Memberikan apresiasi dan penghargaan kepada inisiator/pengelola inovasi terbaik sektor ketenagakerjaan dan ketransmigrasian Jawa Tengah.</li>
                <li>Menjadi sarana pertukaran dan pembelajaran praktik pengembangan dan pemanfaatan inovasi di lingkungan Disnakertrans Provinsi Jawa Tengah.</li>
                <li>Menjaring, mendokumentasikan, membangun basis data, mendiseminasikan, dan mempromosikan inovasi ketenagakerjaan dan ketransmigrasian di Jawa Tengah.</li>
            </ul>
        </section>

        </div>

        <!-- SECTION FOTO: navy penuh lebar, di antara "Tentang" dan "Jadwal Penting" -->
        <section class="bg-slate-900 py-14">
            <div class="max-w-4xl mx-auto px-6">
                <h2 class="text-2xl font-bold text-amber-500 mb-2">Dokumentasi Kegiatan</h2>
                <p class="text-slate-300 mb-8 max-w-2xl">
                    Jejak keikutsertaan Disnakertrans Provinsi Jawa Tengah dalam ajang inovasi tingkat provinsi.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <figure>
                        <img src="{{ asset('images/dokumentasi-1.webp') }}"
                            alt="Gubernur Jawa Tengah menyerahkan penghargaan TOP 10 IDEA Jateng 2025 kepada Kepala Disnakertrans Jateng di Blora"
                            width="1600" height="1067" loading="lazy" decoding="async"
                            class="w-full h-auto aspect-[3/2] object-cover rounded-lg">
                        <figcaption class="mt-3">
                            <p class="text-sm font-semibold text-white">Penghargaan TOP 10 IDEA Jateng 2025 untuk inovasi SIK3</p>
                            <p class="text-sm text-slate-400">26 September 2025 &middot; Pameran Produk Inovasi Jawa Tengah, Lapangan Kridosono, Blora</p>
                        </figcaption>
                    </figure>

                    <figure>
                        <img src="{{ asset('images/dokumentasi-rapat.webp') }}"
                            alt="Peserta mengikuti presentasi dan wawancara inovasi PANDU GUNUNG melalui Zoom Meeting di ruang konferensi Disnakertrans"
                            width="1600" height="1067" loading="lazy" decoding="async"
                            class="w-full h-auto aspect-[3/2] object-cover rounded-lg">
                        <figcaption class="mt-3">
                            <p class="text-sm font-semibold text-white">Presentasi dan Wawancara Inovasi PANDU GUNUNG, Babak Final Kompetisi IDEA Jateng 2026</p>
                            <p class="text-sm text-slate-400">4 Juni 2026 &middot; Zoom Meeting</p>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <div class="max-w-4xl mx-auto px-6">

        <section id="jadwal" class="py-14 border-b border-stone-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-5">Jadwal Penting</h2>
            <!-- Sumber: Bab 4.1 dokumen panduan resmi, Tabel 1 Jadwal Pelaksanaan TERANG NONA 2026 -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-slate-900">
                            <th class="py-2 pr-4 font-semibold text-slate-900">Tahap</th>
                            <th class="py-2 font-semibold text-slate-900">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200">
                        <tr>
                            <td class="py-3 pr-4">Sosialisasi dan BIMTEK Kompetisi TERANG NONA 2026</td>
                            <td class="py-3 text-slate-500">31 Agustus 2026</td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-4">Pendaftaran dan Pelengkapan Bukti Dukung Rancangan/ Pengembangan/ Inovasi</td>
                            <td class="py-3 text-slate-500">31 Agustus 2026 s/d 31 Oktober 2026</td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-4">Pencermatan dan Revisi Proposal Rancangan/ Pengembangan/ Inovasi</td>
                            <td class="py-3 text-slate-500">1 November 2026 s/d 7 November 2026</td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-4">Penilaian Proposal Rancangan/ Pengembangan/ Inovasi</td>
                            <td class="py-3 text-slate-500">9 November 2026 s/d 13 November 2026</td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-4">Presentasi Proposal Rancangan/ Pengembangan/ Inovasi</td>
                            <td class="py-3 text-slate-500">17 November 2026</td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-4">Pengumuman Hasil Kompetisi TERANG NONA 2026</td>
                            <td class="py-3 text-slate-500">23 November 2026</td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-4">Penyerahan Penghargaan Kompetisi TERANG NONA 2026</td>
                            <td class="py-3 text-slate-500">29/30 November 2026</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="py-14 border-b border-stone-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-3">Sekretariat:</h2>
            <p class="text-slate-600">
                <!-- GANTI TEKS INI: kontak resmi Panitia (email/WA/telepon) -->
                Sub Bagian Umum dan Kepegawaian
                Sekretariat Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah
                Jalan Pahlawan No.16, Pleburan, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50241
                terangnonakertransprovjateng@gmail.com
            </p>
        </section>

        </div>

    </main>

    <footer class="bg-slate-900 text-slate-400 text-sm text-center py-6">
        &copy; {{ date('Y') }} Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah
    </footer>

</body>
</html>