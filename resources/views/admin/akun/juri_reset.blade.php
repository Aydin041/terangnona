@extends('layouts.admin')

@section('title', 'Reset Password Juri')

@section('content')
    @include('admin.akun._form-reset', [
        'kunci' => 'juri',
        'nama' => $juri->nama,
        'email' => $juri->email,
        'action' => route('admin.akun.juri.reset', $juri->id),
    ])
@endsection