<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordPeserta;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
            'kontak' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'captcha' => 'required|captcha',
        ], [
            'captcha.required' => 'Jawaban captcha wajib diisi.',
            'captcha.captcha' => 'Jawaban captcha salah. Silakan coba lagi.',
        ]);

        $peserta = Peserta::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'kontak' => $validated['kontak'],
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
            'captcha' => 'required|captcha',
        ], [
            'captcha.required' => 'Jawaban captcha wajib diisi.',
            'captcha.captcha' => 'Jawaban captcha salah. Silakan coba lagi.',
        ]);

        unset($credentials['captcha']);

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

    public function showForgotPasswordForm()
    {
        return view('peserta.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'captcha' => 'required|captcha',
        ], [
            'captcha.required' => 'Jawaban captcha wajib diisi.',
            'captcha.captcha' => 'Jawaban captcha salah. Silakan coba lagi.',
        ]);

        $peserta = Peserta::where('email', $request->email)->first();

        if ($peserta) {
            $token = Str::random(64);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $peserta->email],
                [
                    'token' => Hash::make($token),
                    'created_at' => now(),
                ]
            );

            $resetUrl = route('peserta.password.reset', [
                'token' => $token,
                'email' => $peserta->email,
            ]);

            try {
                Mail::to($peserta->email)->send(new ResetPasswordPeserta($peserta, $resetUrl));
            } catch (\Exception $e) {
                Log::error('Gagal kirim email reset password: ' . $e->getMessage());
            }
        }

        // Tetap tampilkan pesan sukses generik demi keamanan (mencegah user enumeration)
        return back()->with('sukses', 'Jika alamat email tersebut terdaftar di sistem, tautan atur ulang kata sandi telah dikirimkan ke email Anda.');
    }

    public function showResetPasswordForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        return view('peserta.auth.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record) {
            return redirect()->route('peserta.password.request')->withErrors(['email' => 'Permintaan atur ulang kata sandi tidak valid atau telah kedaluwarsa.']);
        }

        // Cek kedaluwarsa (60 menit)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return redirect()->route('peserta.password.request')->withErrors(['email' => 'Tautan atur ulang kata sandi telah kedaluwarsa. Silakan ajukan kembali.']);
        }

        // Verifikasi token
        if (!Hash::check($request->token, $record->token)) {
            return redirect()->route('peserta.password.request')->withErrors(['email' => 'Tautan atur ulang kata sandi tidak valid.']);
        }

        // Update password peserta
        $peserta = Peserta::where('email', $request->email)->first();
        if ($peserta) {
            $peserta->update([
                'password_hash' => Hash::make($request->password),
            ]);
        }

        // Hapus token setelah digunakan
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('peserta.login')->with('sukses', 'Kata sandi berhasil diatur ulang. Silakan masuk menggunakan kata sandi baru Anda.');
    }
}
