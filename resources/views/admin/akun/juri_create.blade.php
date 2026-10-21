@extends('layouts.admin')

@section('title', 'Tambah Akun Juri')

@section('content')
    @include('admin.akun._form-buat', ['kunci' => 'juri', 'peran' => 'Juri'])
@endsection