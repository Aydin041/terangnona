{{-- Rincian pengajuan (hanya-lihat). Dipakai oleh halaman Pimpinan dan Peserta.
     Butuh: $pengajuan, $dokumenPerJenis, $isianPerKomponen, $komponenList, $lampiranUtama, $lampiranTambahan --}}
@php
    $aman = fn ($url) => preg_match('#^https?://#i', (string) $url) === 1;
@endphp

    <div class="space-y-4">
        <div class="bg-white border border-line rounded-2xl p-6">
            <h2 class="font-semibold mb-4">Profil Inovasi</h2>
            <dl class="text-sm divide-y divide-line">
                <div class="flex flex-col sm:flex-row sm:gap-4 py-2"><dt class="text-slate-500 sm:w-44 shrink-0">Nama Inovasi</dt><dd>{{ $pengajuan->nama_inovasi }} ({{ $pengajuan->akronim }})</dd></div>
                <div class="flex flex-col sm:flex-row sm:gap-4 py-2"><dt class="text-slate-500 sm:w-44 shrink-0">Kategori</dt><dd>{{ $pengajuan->kategori->nama }}</dd></div>
                <div class="flex flex-col sm:flex-row sm:gap-4 py-2"><dt class="text-slate-500 sm:w-44 shrink-0">Bentuk Inovasi</dt><dd>{{ $pengajuan->bentuk_inovasi }}</dd></div>
                <div class="flex flex-col sm:flex-row sm:gap-4 py-2"><dt class="text-slate-500 sm:w-44 shrink-0">Status Saat Ini</dt><dd><x-badge-status :status="$pengajuan->status" /></dd></div>
                <div class="flex flex-col sm:flex-row sm:gap-4 py-2"><dt class="text-slate-500 sm:w-44 shrink-0">Peserta</dt><dd class="break-words">{{ $pengajuan->peserta->nama }} ({{ $pengajuan->peserta->email }})</dd></div>
            </dl>
        </div>

        <div class="bg-white border border-line rounded-2xl p-6">
            <h2 class="font-semibold mb-3">Ketua & Anggota</h2>
            <ul class="text-sm space-y-1">
                @foreach ($pengajuan->anggotaKelompok as $anggota)
                    <li>{{ $anggota->nama }} ({{ $anggota->kontak }}) @if ($anggota->adalah_ketua) <span class="text-brand-amber-dark font-semibold">— Ketua</span> @endif</li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white border border-line rounded-2xl p-6">
            <h2 class="font-semibold mb-3">Dokumen Administratif</h2>
            <ul class="text-sm space-y-1.5">
                @forelse ($pengajuan->dokumen as $dok)
                    @continue(in_array($dok->jenis_dokumen, array_merge(array_values($lampiranUtama), array_values($lampiranTambahan)), true))
                    <li>
                        <strong class="font-semibold">{{ $dok->jenis_dokumen }}:</strong>
                        <a href="{{ $dok->tautan }}" target="_blank" rel="noopener noreferrer" class="text-brand-blue underline break-all">{{ $dok->label }}</a>
                    </li>
                @empty
                    <li class="text-slate-400 italic">Belum ada dokumen.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white border border-line rounded-2xl p-6">
            <h2 class="font-semibold mb-1">Isi Proposal</h2>
            <p class="text-sm text-slate-500 mb-4">{{ $komponenList->count() }} komponen.</p>

            <div class="space-y-4">
                @foreach ($komponenList as $komponen)
                    @php
                        $isian = $isianPerKomponen[$komponen->id] ?? null;
                        $jenisUtama = $lampiranUtama[$komponen->id] ?? null;
                        $jenisTambahan = $lampiranTambahan[$komponen->id] ?? null;
                    @endphp
                    <div class="border border-line rounded-xl p-4">
                        <p class="font-semibold mb-2">{{ $komponen->nama }} <span class="text-slate-400 font-normal text-sm">(Bobot {{ $komponen->bobot }}%)</span></p>

                        @if ($jenisUtama)
                            @php $dok = $dokumenPerJenis[$jenisUtama] ?? null; @endphp
                            @if ($dok)
                                <p class="text-sm break-all">Lampiran:
                                    <a href="{{ $dok->tautan }}" target="_blank" rel="noopener noreferrer" class="text-brand-blue underline">{{ $dok->label }}</a>
                                </p>
                            @else
                                <p class="text-sm text-slate-400 italic">Lampiran belum diisi.</p>
                            @endif
                        @else
                            @if ($isian && filled($isian->uraian))
                                <p class="text-sm whitespace-pre-line break-words">{{ $isian->uraian }}</p>
                            @else
                                <p class="text-sm text-slate-400 italic">Belum diisi peserta.</p>
                            @endif

                            @if ($isian && $isian->links->isNotEmpty())
                                <p class="text-xs font-semibold text-slate-500 mt-3 mb-1">Tautan Bukti Dukung</p>
                                <ul class="text-sm space-y-1">
                                    @foreach ($isian->links as $tautan)
                                        <li class="break-all">
                                            {{ $tautan->judul }}:
                                            @if ($aman($tautan->link))
                                                <a href="{{ $tautan->link }}" target="_blank" rel="noopener noreferrer" class="text-brand-blue underline">{{ $tautan->link }}</a>
                                            @else
                                                {{ $tautan->link }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif

                        @if ($jenisTambahan)
                            @php $dokTambahan = $dokumenPerJenis[$jenisTambahan] ?? null; @endphp
                            <div class="mt-3 pt-3 border-t border-line">
                                @if ($dokTambahan)
                                    <p class="text-sm break-all">Dokumen RAB:
                                        <a href="{{ $dokTambahan->tautan }}" target="_blank" rel="noopener noreferrer" class="text-brand-blue underline">{{ $dokTambahan->label }}</a>
                                    </p>
                                @else
                                    <p class="text-sm text-slate-400 italic">Dokumen RAB belum diisi.</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>