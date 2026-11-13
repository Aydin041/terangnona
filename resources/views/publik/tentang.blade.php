@extends('layouts.publik')

@section('judul', 'Tentang - TERANG NONA ' . $tahunKompetisi)

@section('content')
    {{-- ===== TENTANG ===== --}}    <section id="tentang" class="max-w-6xl mx-auto px-4 sm:px-6 pt-16">
        <div class="grid lg:grid-cols-2 gap-10">
            <div>
                <p class="text-xs font-bold tracking-widest text-brand-amber-dark uppercase">Tentang</p>
                <h2 class="text-3xl font-bold mt-1 mb-4">Tentang TERANG NONA {{ $tahunKompetisi }}</h2>
                <div class="space-y-4 text-slate-600 leading-relaxed">
                    <p>
                        TERANG NONA (Tenaga Kerja dan Transmigrasi Innovation Awards) {{ $tahunKompetisi }} adalah ajang yang
                        digagas Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah sebagai sarana apresiasi
                        sekaligus wadah penjaringan karya inovatif terbaik yang lahir dari gagasan ASN, praktisi
                        industri, akademisi, hingga masyarakat luas.
                    </p>
                    <p>
                        Melalui TERANG NONA {{ $tahunKompetisi }} diharapkan terwujud ekosistem inovasi ketenagakerjaan dan
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

    {{-- ===== DOKUMENTASI ===== --}}    <section id="dokumentasi" class="bg-brand-navy mt-16 py-14">
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

    {{-- ===== SEKRETARIAT ===== --}}    <section id="sekretariat" class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
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
                <a href="mailto:terangnonanakertransprovjateng@gmail.com" class="text-sm font-semibold text-brand-blue hover:underline break-all">terangnonanakertransprovjateng@gmail.com</a>
            </div>
        </div>
    </section>
@endsection