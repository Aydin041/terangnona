{{-- Alasan dan riwayat pemeriksaan Panitia. Hanya-lihat.
     Butuh: $pengajuan, $riwayat (koleksi), $catatanTerakhir. Opsional: $tampilkanPetugas --}}
@php
    $riwayatList = $riwayat ?? collect();
    $tanggal = function ($waktu) {
        if (blank($waktu)) {
            return '';
        }
        return \Illuminate\Support\Carbon::parse($waktu, 'UTC')
            ->setTimezone('Asia/Jakarta')
            ->locale('id')
            ->translatedFormat('j F Y, H.i') . ' WIB';
    };
@endphp

@if (in_array($pengajuan->status, ['ditolak', 'perlu_perbaikan'], true) && filled($catatanTerakhir ?? null))
    <div class="mb-4 rounded-2xl bg-red-50 border border-red-200 p-5 text-sm">
        <strong class="font-semibold text-red-800">
            {{ $pengajuan->status === 'ditolak' ? 'Alasan ditolak:' : 'Alasan dikembalikan untuk diperbaiki:' }}
        </strong>
        <p class="text-red-700 mt-1 whitespace-pre-line break-words">{{ $catatanTerakhir }}</p>
    </div>
@endif

@if ($riwayatList->isNotEmpty())
    <div class="bg-white border border-line rounded-2xl p-6 mb-4">
        <h2 class="font-semibold mb-1">Riwayat dan Catatan Pemeriksaan</h2>
        <p class="text-sm text-slate-500 mb-4">Diurutkan dari yang paling awal.</p>

        <ol class="space-y-3">
            @foreach ($riwayatList as $r)
                <li class="border border-line rounded-xl p-4">
                    <div class="flex items-start justify-between gap-3 flex-wrap">
                        <x-badge-status :status="$r->status" />
                        <span class="text-xs text-slate-400">{{ $tanggal($r->changed_at) }}</span>
                    </div>

                    @if (($tampilkanPetugas ?? false) && $r->panitia)
                        <p class="text-xs text-slate-500 mt-2">Diperiksa oleh: {{ $r->panitia->nama }}</p>
                    @endif

                    @if (filled($r->catatan_panitia))
                        <p class="text-sm mt-2 whitespace-pre-line break-words">
                            <strong class="font-semibold">Catatan:</strong> {{ $r->catatan_panitia }}
                        </p>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
@endif