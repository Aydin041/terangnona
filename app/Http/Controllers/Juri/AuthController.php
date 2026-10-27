<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('juri.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ], [
            'captcha.required' => 'Jawaban captcha wajib diisi.',
            'captcha.captcha' => 'Jawaban captcha salah. Silakan coba lagi.',
        ]);

        unset($credentials['captcha']);

        if (Auth::guard('juri')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('juri.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('juri')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('juri.login');
    }
}