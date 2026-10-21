@extends('layouts.admin')

@section('title', 'Reset Password Pimpinan')

@section('content')
    @include('admin.akun._form-reset', [
        'kunci' => 'pimpinan',
        'nama' => $pimpinan->nama,
        'email' => $pimpinan->email,
        'action' => route('admin.akun.pimpinan.reset', $pimpinan->id),
    ])
@endsection