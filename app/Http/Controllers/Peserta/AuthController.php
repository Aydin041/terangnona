<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('peserta.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:peserta,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $peserta = Peserta::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
        ]);

        Auth::guard('peserta')->login($peserta);

        return redirect()->route('peserta.dashboard');
    }

    public function showLoginForm()
    {
        return view('peserta.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('peserta')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('peserta.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('peserta')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('peserta.login');
    }
}