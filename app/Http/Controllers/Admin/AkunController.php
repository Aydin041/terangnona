<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Juri;
use App\Models\Panitia;
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
        ]);

        $passwordAsli = Str::random(10);

        Panitia::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($passwordAsli),
        ]);

        return redirect()
            ->route('admin.akun.panitia.index')
            ->with('sukses', "Akun Panitia berhasil dibuat. Email: {$validated['email']} | Password: {$passwordAsli} (catat sekarang, tidak akan ditampilkan lagi)");
    }

    public function panitiaReset($id)
    {
        $panitia = Panitia::findOrFail($id);
        $passwordBaru = Str::random(10);

        $panitia->update([
            'password_hash' => Hash::make($passwordBaru),
        ]);

        return redirect()
            ->route('admin.akun.panitia.index')
            ->with('sukses', "Password untuk {$panitia->nama} ({$panitia->email}) berhasil direset. Password baru: {$passwordBaru} (catat sekarang, tidak akan ditampilkan lagi)");
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
        ]);

        $passwordAsli = Str::random(10);

        Juri::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($passwordAsli),
        ]);

        return redirect()
            ->route('admin.akun.juri.index')
            ->with('sukses', "Akun Juri berhasil dibuat. Email: {$validated['email']} | Password: {$passwordAsli} (catat sekarang, tidak akan ditampilkan lagi)");
    }

    public function juriReset($id)
    {
        $juri = Juri::findOrFail($id);
        $passwordBaru = Str::random(10);

        $juri->update([
            'password_hash' => Hash::make($passwordBaru),
        ]);

        return redirect()
            ->route('admin.akun.juri.index')
            ->with('sukses', "Password untuk {$juri->nama} ({$juri->email}) berhasil direset. Password baru: {$passwordBaru} (catat sekarang, tidak akan ditampilkan lagi)");
    }
}