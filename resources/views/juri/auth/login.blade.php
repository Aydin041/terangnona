@extends('layouts.auth')

@section('title', 'Login Juri')

@section('content')
    @include('auth._form-login', [
        'judul' => 'Login Juri',
        'subjudul' => 'Masuk sebagai Juri',
        'action' => route('juri.login.submit'),
    ])
@endsection