@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('content_header')
    <h1>Detail Pengguna</h1>
@stop

@section('content')
    <p>Mengelola data detail pengguna.</p>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Data Pengguna</span>
                </div>
                <div class="card-body">
                    @include('user.partials.user_readonly')
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Hak Akses</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($user->getAllPermissions() as $permission)
                            <div class="col-lg-4 col-sm-6 mb-1">
                                {{ $permission->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            @if ($mahasiswa = $user->mahasiswa)
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Data Mahasiswa</span>
                </div>
                <div class="card-body">
                    @include('user.partials.mahasiswa_readonly')
                </div>
            </div>
            @endif
            @if ($dosen = $user->dosen)
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Data Dosen</span>
                </div>
                <div class="card-body">
                    @include('user.partials.dosen_readonly')
                </div>
            </div>
            @endif
        </div>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-secondary my-2">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@stop
