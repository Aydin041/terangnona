@extends('layouts.admin')

@section('title', 'Reset Password Panitia')

@section('content')
    @include('admin.akun._form-reset', [
        'kunci' => 'panitia',
        'nama' => $panitia->nama,
        'email' => $panitia->email,
        'action' => route('admin.akun.panitia.reset', $panitia->uuid),
    ])
@endsection