@extends('layouts.admin')

@section('title', 'Reset Password Peserta')

@section('content')
    @include('admin.akun._form-reset', [
        'kunci' => 'peserta',
        'nama' => $peserta->nama,
        'email' => $peserta->email,
        'action' => route('admin.akun.peserta.reset', $peserta->id),
    ])
@endsection