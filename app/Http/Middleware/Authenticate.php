<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        if ($request->is('peserta/*')) {
            return route('peserta.login');
        }

        if ($request->is('panitia/*')) {
            return route('panitia.login');
        }

        if ($request->is('juri/*')) {
            return route('juri.login');
        }

        if ($request->is('admin/*')) {
            return route('admin.login');
        }

        if ($request->is('pimpinan/*')) {
            return route('pimpinan.login');
        }

        return route('peserta.login'); // fallback
    }
}