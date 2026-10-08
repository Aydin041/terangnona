<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pengaman server untuk role Pimpinan: hanya boleh membaca.
 * Semua permintaan selain GET/HEAD ditolak, apa pun alamat yang diketik.
 */
class PimpinanReadOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->method(), ['GET', 'HEAD'], true)) {
            abort(403, 'Role Pimpinan hanya dapat melihat data.');
        }

        return $next($request);
    }
}