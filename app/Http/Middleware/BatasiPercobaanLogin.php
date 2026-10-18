<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Membatasi percobaan login yang gagal (anti tebak password).
 *
 * - Per akun + alamat IP: maksimal 5 kali gagal dalam 5 menit.
 * - Per alamat IP saja: maksimal 20 kali gagal dalam 5 menit (menahan penebakan banyak email).
 * Login yang berhasil tidak dihitung dan menghapus hitungan gagal untuk akun itu,
 * jadi banyak pengguna sah yang login bersamaan dari jaringan kantor yang sama tidak terblokir.
 *
 * Dipakai di rute: ->middleware(BatasiPercobaanLogin::class . ':peserta')  (nama guard)
 */
class BatasiPercobaanLogin
{
    private const MAKS_PER_AKUN = 5;
    private const MAKS_PER_IP = 20;
    private const DETIK = 300;

    public function handle(Request $request, Closure $next, string $guard): Response
    {
        $kunciAkun = 'login|' . $guard . '|' . Str::lower((string) $request->input('email')) . '|' . $request->ip();
        $kunciIp = 'login-ip|' . $guard . '|' . $request->ip();

        foreach ([[$kunciAkun, self::MAKS_PER_AKUN], [$kunciIp, self::MAKS_PER_IP]] as [$kunci, $maksimal]) {
            if (RateLimiter::tooManyAttempts($kunci, $maksimal)) {
                $menit = max(1, (int) ceil(RateLimiter::availableIn($kunci) / 60));

                throw ValidationException::withMessages([
                    'email' => "Terlalu banyak percobaan login yang gagal. Coba lagi dalam {$menit} menit.",
                ]);
            }
        }

        $response = $next($request);

        if (Auth::guard($guard)->check()) {
            RateLimiter::clear($kunciAkun);
        } else {
            RateLimiter::hit($kunciAkun, self::DETIK);
            RateLimiter::hit($kunciIp, self::DETIK);
        }

        return $response;
    }
}