<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'peserta' => [
            'driver' => 'session',
            'provider' => 'peserta',
        ],

        'panitia' => [
            'driver' => 'session',
            'provider' => 'panitia',
        ],

        'juri' => [
            'driver' => 'session',
            'provider' => 'juri',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admin',
        ],

        'pimpinan' => [
            'driver' => 'session',
            'provider' => 'pimpinan',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'peserta' => [
            'driver' => 'eloquent',
            'model' => App\Models\Peserta::class,
        ],

        'panitia' => [
            'driver' => 'eloquent',
            'model' => App\Models\Panitia::class,
        ],

        'juri' => [
            'driver' => 'eloquent',
            'model' => App\Models\Juri::class,
        ],

        'admin' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'pimpinan' => [
            'driver' => 'eloquent',
            'model' => App\Models\Pimpinan::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */

    'password_timeout' => 10800,

];