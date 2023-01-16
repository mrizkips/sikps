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
                <div class="card-body p-0">
                    @include('user.partials.user_readonly')
                </div>
            </div>
        </div>
        @if ($mahasiswa = $user->mahasiswa)
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Data Mahasiswa</span>
                </div>
                <div class="card-body p-0">
                    @include('user.partials.mahasiswa_readonly')
                </div>
            </div>
        </div>
        @endif
        @if ($dosen = $user->dosen)
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Data Dosen</span>
                </div>
                <div class="card-body p-0">
                    @include('user.partials.dosen_readonly')
                </div>
            </div>
        </div>
        @endif
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Hak Akses</span>
                </div>
                <div class="card-body p-0">
                    <table class="table table-borderless">
                        <tbody>
                            @foreach ($user->getAllPermissions() as $permission)
                                @if ($loop->iteration % 3 == 1)
                                    </tr>
                                @endif
                                    <td>{{ $permission->name }}</td>
                                @if ($loop->iteration % 3 == 0)
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-secondary my-2">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@stop
