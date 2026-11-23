@extends('layouts.publik')

@section('judul', 'Tentang - TERANG NONA ' . $tahunKompetisi)

@section('content')
    {{-- ===== TENTANG ===== --}}
    <section id="tentang" class="max-w-6xl mx-auto px-4 sm:px-6 pt-12 sm:pt-16">
        <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            <div class="lg:col-span-7">
                <span class="inline-block text-xs font-bold tracking-wider text-brand-amber-dark bg-amber-50 border border-amber-200/60 rounded-full px-3 py-1 uppercase">Tentang</span>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-ink mt-3 mb-5 leading-tight">Tentang TERANG NONA {{ $tahunKompetisi }}</h1>
                <div class="space-y-4 text-slate-600 leading-relaxed text-base">
                    <p>
                        <strong class="text-ink">TERANG NONA</strong> (<em>Tenaga Kerja dan Transmigrasi Innovation Awards</em>) {{ $tahunKompetisi }} adalah ajang yang
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

            <div class="lg:col-span-5 space-y-4 lg:pt-8">
                <div class="bg-white border border-slate-200/80 border-l-4 border-l-brand-amber rounded-2xl p-6 shadow-sm hover:shadow transition-shadow">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-brand-amber"></span>
                        <h3 class="text-lg font-bold text-brand-navy">Ngopeni</h3>
                    </div>
                    <p class="text-sm text-slate-600 mt-2 leading-relaxed">Memelihara, memfasilitasi, dan mendampingi setiap bibit inovasi agar berkembang optimal.</p>
                </div>

                <div class="bg-white border border-slate-200/80 border-l-4 border-l-brand-blue rounded-2xl p-6 shadow-sm hover:shadow transition-shadow">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-brand-blue"></span>
                        <h3 class="text-lg font-bold text-brand-navy">Nglakoni</h3>
                    </div>
                    <p class="text-sm text-slate-600 mt-2 leading-relaxed">Mewujudkan ide secara nyata dan konsisten hingga berdampak langsung bagi masyarakat.</p>
                </div>
            </div>
        </div>

        {{-- Tujuan --}}
        <div class="mt-16">
            <div class="text-center sm:text-left mb-6">
                <h2 class="text-2xl font-bold text-ink">Tujuan Utama</h2>
                <p class="text-sm text-slate-500 mt-1">Fokus utama penyelenggaraan kompetisi inovasi TERANG NONA</p>
            </div>

            <div class="grid md:grid-cols-3 gap-5">
                @php
                    $tujuan = [
                        'Memberikan apresiasi dan penghargaan kepada inisiator/pengelola inovasi terbaik sektor ketenagakerjaan dan ketransmigrasian Jawa Tengah.',
                        'Menjadi sarana pertukaran dan pembelajaran praktik pengembangan dan pemanfaatan inovasi di lingkungan Disnakertrans Provinsi Jawa Tengah.',
                        'Menjaring, mendokumentasikan, membangun basis data, mendiseminasikan, dan mempromosikan inovasi ketenagakerjaan dan ketransmigrasian di Jawa Tengah.',
                    ];
                @endphp
                @foreach ($tujuan as $i => $teks)
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <span class="w-9 h-9 rounded-xl bg-brand-navy text-brand-amber text-sm font-bold flex items-center justify-center mb-4 shadow-sm">
                                0{{ $i + 1 }}
                            </span>
                            <p class="text-sm text-slate-600 leading-relaxed font-medium">{{ $teks }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== DOKUMENTASI ===== --}}
    <section id="dokumentasi" class="bg-brand-navy mt-20 py-16 border-y border-white/10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="max-w-2xl">
                <span class="inline-block text-xs font-bold tracking-wider text-brand-amber uppercase">Galeri &amp; Prestasi</span>
                <h2 class="text-3xl font-extrabold text-white mt-2 mb-2">Dokumentasi Kegiatan</h2>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-10">
                    Jejak keikutsertaan Disnakertrans Provinsi Jawa Tengah dalam ajang inovasi tingkat provinsi.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                <figure class="group">
                    <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/5">
                        <img src="{{ asset('images/dokumentasi-1.webp') }}"
                            alt="Gubernur Jawa Tengah menyerahkan penghargaan TOP 10 IDEA Jateng 2025 kepada Kepala Disnakertrans Jateng di Blora"
                            width="1600" height="1067" loading="lazy" decoding="async"
                            class="w-full h-auto aspect-[3/2] object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                    <figcaption class="mt-4">
                        <p class="text-sm font-semibold text-white group-hover:text-brand-amber transition-colors">Penghargaan TOP 10 IDEA Jateng 2025 untuk inovasi SIK3</p>
                        <p class="text-xs text-slate-400 mt-1">26 September 2025 &middot; Pameran Produk Inovasi Jawa Tengah, Lapangan Kridosono, Blora</p>
                    </figcaption>
                </figure>

                <figure class="group">
                    <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/5">
                        <img src="{{ asset('images/dokumentasi-rapat.webp') }}"
                            alt="Peserta mengikuti presentasi dan wawancara inovasi PANDU GUNUNG melalui Zoom Meeting di ruang konferensi Disnakertrans"
                            width="1600" height="1067" loading="lazy" decoding="async"
                            class="w-full h-auto aspect-[3/2] object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                    <figcaption class="mt-4">
                        <p class="text-sm font-semibold text-white group-hover:text-brand-amber transition-colors">Presentasi dan Wawancara Inovasi PANDU GUNUNG, Babak Final Kompetisi IDEA Jateng 2026</p>
                        <p class="text-xs text-slate-400 mt-1">4 Juni 2026 &middot; Zoom Meeting</p>
                    </figcaption>
                </figure>
            </div>
        </div>
    </section>

    {{-- ===== SEKRETARIAT ===== --}}
    <section id="sekretariat" class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
        <span class="inline-block text-xs font-bold tracking-wider text-brand-amber-dark uppercase">Kontak Resmi</span>
        <h2 class="text-3xl font-extrabold text-ink mt-1 mb-6">Sekretariat</h2>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 sm:p-8 shadow-sm grid md:grid-cols-2 gap-8 items-start">
            <div>
                <p class="font-bold text-ink text-base">Sub Bagian Umum dan Kepegawaian</p>
                <p class="text-sm text-slate-600 mt-1.5 leading-relaxed">Sekretariat Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Tengah</p>
            </div>
            <div>
                <p class="font-bold text-ink text-base">Alamat &amp; Email</p>
                <p class="text-sm text-slate-600 mt-1.5 leading-relaxed">Jalan Pahlawan No.16, Pleburan, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50241</p>
                <div class="mt-3">
                    <a href="mailto:terangnonanakertransprovjateng@gmail.com" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-blue hover:text-brand-blue-light transition-colors break-all">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        terangnonanakertransprovjateng@gmail.com
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
