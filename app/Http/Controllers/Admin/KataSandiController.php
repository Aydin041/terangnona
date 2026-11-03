<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KataSandiController extends Controller
{
    public function form()
    {
        return view('admin.kata-sandi.form');
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'password_lama' => 'required|string',
            'password_baru' => 'required|string|min:10|confirmed|different:password_lama',
        ], [
            'password_lama.required' => 'Kata sandi saat ini wajib diisi.',
            'password_baru.required' => 'Kata sandi baru wajib diisi.',
            'password_baru.min' => 'Kata sandi baru minimal :min karakter.',
            'password_baru.confirmed' => 'Konfirmasi kata sandi baru tidak sama.',
            'password_baru.different' => 'Kata sandi baru tidak boleh sama dengan kata sandi saat ini.',
        ]);

        if (! Hash::check($request->input('password_lama'), $admin->password_hash)) {
            return back()->withErrors(['password_lama' => 'Kata sandi saat ini salah.']);
        }

        $admin->forceFill([
            'password_hash' => Hash::make($request->input('password_baru')),
        ])->save();

        $request->session()->regenerate();

        return redirect()->route('admin.kata-sandi.form')->with('sukses', 'Kata sandi berhasil diganti.');
    }
}