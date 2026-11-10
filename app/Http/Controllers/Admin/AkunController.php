<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Juri;
use App\Models\Panitia;
use App\Models\Peserta;
use App\Models\Pimpinan;
use App\Services\PenghapusanData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AkunController extends Controller
{
    public function panitiaIndex()
    {
        $daftarPanitia = Panitia::orderBy('nama')->get();
        return view('admin.akun.panitia_index', compact('daftarPanitia'));
    }

    public function panitiaCreateForm()
    {
        return view('admin.akun.panitia_create');
    }

    public function panitiaStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:panitia,email',
            'password' => 'nullable|string|min:6',
        ]);

        $passwordAsli = !empty($validated['password']) ? $validated['password'] : Str::random(10);

        Panitia::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($passwordAsli),
        ]);

        return redirect()
            ->route('admin.akun.panitia.index')
            ->with('sukses', "Akun Panitia berhasil dibuat. Email: {$validated['email']} | Password: {$passwordAsli} (catat sekarang, tidak akan ditampilkan lagi)");
    }

    public function panitiaResetForm($id)
    {
        $panitia = Panitia::findOrFail($id);
        return view('admin.akun.panitia_reset', compact('panitia'));
    }

    public function panitiaReset(Request $request, $id)
    {
        $validated = $request->validate([
            'password' => 'nullable|string|min:6',
        ]);

        $panitia = Panitia::findOrFail($id);
        $passwordBaru = !empty($validated['password']) ? $validated['password'] : Str::random(10);

        $panitia->update([
            'password_hash' => Hash::make($passwordBaru),
        ]);

        return redirect()
            ->route('admin.akun.panitia.index')
            ->with('sukses', "Password untuk {$panitia->nama} ({$panitia->email}) berhasil direset. Password baru: {$passwordBaru} (catat sekarang, tidak akan ditampilkan lagi)");
    }

    public function panitiaHapusForm($id, PenghapusanData $penghapusan)
    {
        $panitia = Panitia::findOrFail($id);

        return $this->tampilKonfirmasi('panitia', 'Panitia', $panitia, $penghapusan->ringkasanPanitia($panitia->id));
    }

    public function panitiaHapus(Request $request, $id, PenghapusanData $penghapusan)
    {
        $panitia = Panitia::findOrFail($id);

        return $this->prosesHapus($request, 'panitia', 'Panitia', $panitia, fn () => $penghapusan->hapusPanitia($panitia->id));
    }

    public function juriIndex()
    {
        $daftarJuri = Juri::orderBy('nama')->get();
        return view('admin.akun.juri_index', compact('daftarJuri'));
    }

    public function juriCreateForm()
    {
        return view('admin.akun.juri_create');
    }

    public function juriStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:juri,email',
            'password' => 'nullable|string|min:6',
        ]);

        $passwordAsli = !empty($validated['password']) ? $validated['password'] : Str::random(10);

        Juri::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($passwordAsli),
        ]);

        return redirect()
            ->route('admin.akun.juri.index')
            ->with('sukses', "Akun Juri berhasil dibuat. Email: {$validated['email']} | Password: {$passwordAsli} (catat sekarang, tidak akan ditampilkan lagi)");
    }

    public function juriResetForm($id)
    {
        $juri = Juri::findOrFail($id);
        return view('admin.akun.juri_reset', compact('juri'));
    }

    public function juriReset(Request $request, $id)
    {
        $validated = $request->validate([
            'password' => 'nullable|string|min:6',
        ]);

        $juri = Juri::findOrFail($id);
        $passwordBaru = !empty($validated['password']) ? $validated['password'] : Str::random(10);

        $juri->update([
            'password_hash' => Hash::make($passwordBaru),
        ]);

        return redirect()
            ->route('admin.akun.juri.index')
            ->with('sukses', "Password untuk {$juri->nama} ({$juri->email}) berhasil direset. Password baru: {$passwordBaru} (catat sekarang, tidak akan ditampilkan lagi)");
    }

    public function juriHapusForm($id, PenghapusanData $penghapusan)
    {
        $juri = Juri::findOrFail($id);

        return $this->tampilKonfirmasi('juri', 'Juri', $juri, $penghapusan->ringkasanJuri($juri->id));
    }

    public function juriHapus(Request $request, $id, PenghapusanData $penghapusan)
    {
        $juri = Juri::findOrFail($id);

        return $this->prosesHapus($request, 'juri', 'Juri', $juri, fn () => $penghapusan->hapusJuri($juri->id));
    }

    public function pesertaIndex()
    {
        $daftarPeserta = Peserta::orderBy('nama')->get();
        return view('admin.akun.peserta_index', compact('daftarPeserta'));
    }

    public function pesertaResetForm($id)
    {
        $peserta = Peserta::findOrFail($id);
        return view('admin.akun.peserta_reset', compact('peserta'));
    }

    public function pesertaReset(Request $request, $id)
    {
        $validated = $request->validate([
            'password' => 'nullable|string|min:6',
        ]);

        $peserta = Peserta::findOrFail($id);
        $passwordBaru = !empty($validated['password']) ? $validated['password'] : Str::random(10);

        $peserta->update([
            'password_hash' => Hash::make($passwordBaru),
        ]);

        return redirect()
            ->route('admin.akun.peserta.index')
            ->with('sukses', "Password untuk {$peserta->nama} ({$peserta->email}) berhasil direset. Password baru: {$passwordBaru} (catat sekarang, tidak akan ditampilkan lagi)");
    }

    public function pesertaHapusForm($id, PenghapusanData $penghapusan)
    {
        $peserta = Peserta::findOrFail($id);

        return $this->tampilKonfirmasi('peserta', 'Peserta', $peserta, $penghapusan->ringkasanPeserta($peserta->id));
    }

    public function pesertaHapus(Request $request, $id, PenghapusanData $penghapusan)
    {
        $peserta = Peserta::findOrFail($id);

        return $this->prosesHapus($request, 'peserta', 'Peserta', $peserta, fn () => $penghapusan->hapusPeserta($peserta->id));
    }

    public function pimpinanIndex()
    {
        $daftarPimpinan = Pimpinan::orderBy('nama')->get();
        return view('admin.akun.pimpinan_index', compact('daftarPimpinan'));
    }

    public function pimpinanCreateForm()
    {
        return view('admin.akun.pimpinan_create');
    }

    public function pimpinanStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pimpinan,email',
            'password' => 'nullable|string|min:6',
        ]);

        $passwordAsli = !empty($validated['password']) ? $validated['password'] : Str::random(10);

        Pimpinan::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($passwordAsli),
        ]);

        return redirect()
            ->route('admin.akun.pimpinan.index')
            ->with('sukses', "Akun Pimpinan berhasil dibuat. Email: {$validated['email']} | Password: {$passwordAsli} (catat sekarang, tidak akan ditampilkan lagi)");
    }

    public function pimpinanResetForm($id)
    {
        $pimpinan = Pimpinan::findOrFail($id);
        return view('admin.akun.pimpinan_reset', compact('pimpinan'));
    }

    public function pimpinanReset(Request $request, $id)
    {
        $validated = $request->validate([
            'password' => 'nullable|string|min:6',
        ]);

        $pimpinan = Pimpinan::findOrFail($id);
        $passwordBaru = !empty($validated['password']) ? $validated['password'] : Str::random(10);

        $pimpinan->update([
            'password_hash' => Hash::make($passwordBaru),
        ]);

        return redirect()
            ->route('admin.akun.pimpinan.index')
            ->with('sukses', "Password untuk {$pimpinan->nama} ({$pimpinan->email}) berhasil direset. Password baru: {$passwordBaru} (catat sekarang, tidak akan ditampilkan lagi)");
    }

    public function pimpinanHapusForm($id, PenghapusanData $penghapusan)
    {
        $pimpinan = Pimpinan::findOrFail($id);

        return $this->tampilKonfirmasi('pimpinan', 'Pimpinan', $pimpinan, []);
    }

    public function pimpinanHapus(Request $request, $id)
    {
        // Pimpinan hanya-lihat dan tidak meninggalkan data lain.
        $pimpinan = Pimpinan::findOrFail($id);

        return $this->prosesHapus($request, 'pimpinan', 'Pimpinan', $pimpinan, fn () => $pimpinan->delete());
    }

    private function tampilKonfirmasi(string $kunci, string $peran, $akun, array $ringkasan)
    {
        return view('admin.hapus.konfirmasi', [
            'judul' => "Hapus Akun {$peran}",
            'nama' => $akun->nama,
            'sub' => $akun->email,
            'ringkasan' => $ringkasan,
            'action' => route("admin.akun.{$kunci}.hapus", $akun->uuid),
            'batal' => route("admin.akun.{$kunci}.index"),
        ]);
    }

    private function prosesHapus(Request $request, string $kunci, string $peran, $akun, \Closure $hapus)
    {
        $request->validate(
            ['konfirmasi' => 'required|in:HAPUS'],
            ['konfirmasi.*' => 'Ketik HAPUS (huruf besar semua) untuk melanjutkan.']
        );

        $nama = $akun->nama;
        $hapus();

        return redirect()
            ->route("admin.akun.{$kunci}.index")
            ->with('sukses', "Akun {$peran} {$nama} berhasil dihapus beserta data terkaitnya.");
    }
}