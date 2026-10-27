<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('panitia.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ], [
            'captcha.required' => 'Jawaban captcha wajib diisi.',
            'captcha.captcha' => 'Jawaban captcha salah. Silakan coba lagi.',
        ]);

        unset($credentials['captcha']);

        if (Auth::guard('panitia')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('panitia.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('panitia')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('panitia.login');
    }
}