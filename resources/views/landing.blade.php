<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TERANG NONA 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 text-slate-800">

    <header class="bg-slate-900">
        <div class="max-w-4xl mx-auto px-6 py-4 flex items-center justify-between">
            <img src="{{ asset('images/logo-terang-nona-emas.png') }}" alt="TERANG NONA" class="h-10">

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

        <div class="max-w-4xl mx-auto px-6 pb-16 pt-4 text-center">
            <img src="{{ asset('images/logo-terang-nona-emas.png') }}" alt="TERANG NONA 2026" class="h-44 mx-auto mb-2">
            <p class="text-slate-300 text-lg max-w-xl mx-auto mt-4">
                <!-- GANTI TEKS INI: tagline/nama panjang kompetisi sesuai dokumen resmi -->
                Kompetisi Inovasi Disnakertrans Provinsi Jawa Tengah
            </p>
            <div class="mt-8 flex flex-wrap gap-3 justify-center">
                <a href="{{ route('peserta.register') }}"
                    class="bg-amber-500 hover:bg-amber-400 text-slate-900 font-semibold rounded-lg px-5 py-2.5 transition-colors">
                    Daftar sebagai Peserta
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6">

        <section class="py-14 border-b border-stone-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-3">Tentang TERANG NONA</h2>
            <p class="text-slate-600 leading-relaxed max-w-2xl">
                <!-- GANTI TEKS INI: deskripsi/latar belakang kompetisi, 2-3 paragraf,
                     ambil dari dokumen panduan resmi -->
                [Deskripsi kompetisi belum diisi. Ganti paragraf ini dengan penjelasan
                singkat tentang apa itu TERANG NONA, tujuannya, dan siapa yang boleh ikut.]
            </p>
        </section>

        <section class="py-14 border-b border-stone-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-5">Jadwal Penting</h2>
            <!-- GANTI ISI TABEL INI sesuai jadwal resmi dari Panitia -->
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
                            <td class="py-3 pr-4">Pendaftaran & Pengajuan Proposal</td>
                            <td class="py-3 text-slate-500">[isi tanggal]</td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-4">Penilaian Proposal oleh Juri</td>
                            <td class="py-3 text-slate-500">[isi tanggal]</td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-4">Pengumuman 5 Besar</td>
                            <td class="py-3 text-slate-500">[isi tanggal]</td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-4">Presentasi & Wawancara</td>
                            <td class="py-3 text-slate-500">[isi tanggal]</td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-4">Pengumuman Juara</td>
                            <td class="py-3 text-slate-500">[isi tanggal]</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="py-14 border-b border-stone-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-5">Kategori Inovasi</h2>
            <!-- Sudah sesuai bentuk_inovasi yang dipakai di sistem, tidak perlu diganti
                 kecuali istilahnya mau disesuaikan dengan dokumen resmi -->
            <div class="grid sm:grid-cols-3 gap-4">
                <div class="bg-white border border-stone-200 rounded-xl p-5">
                    <h3 class="font-semibold text-slate-900 mb-1">Eksisting</h3>
                    <p class="text-sm text-slate-500">Inovasi yang sudah berjalan</p>
                </div>
                <div class="bg-white border border-stone-200 rounded-xl p-5">
                    <h3 class="font-semibold text-slate-900 mb-1">Pengembangan</h3>
                    <p class="text-sm text-slate-500">Inovasi yang sedang dikembangkan</p>
                </div>
                <div class="bg-white border border-stone-200 rounded-xl p-5">
                    <h3 class="font-semibold text-slate-900 mb-1">Rancangan Inovasi</h3>
                    <p class="text-sm text-slate-500">Ide/rancangan baru</p>
                </div>
            </div>
        </section>

        <section class="py-14 border-b border-stone-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-3">Kontak</h2>
            <p class="text-slate-600">
                <!-- GANTI TEKS INI: kontak resmi Panitia (email/WA/telepon) -->
                [Kontak Panitia belum diisi. Ganti dengan email/nomor WhatsApp resmi.]
            </p>
        </section>

    </main>

    <footer class="bg-slate-900 text-slate-400 text-sm text-center py-6">
        &copy; {{ date('Y') }} Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah
    </footer>

</body>
</html>