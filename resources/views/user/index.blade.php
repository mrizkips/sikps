@extends('layouts.app')

@section('title', 'Pengguna')

@section('content_header')
    <h1>Pengguna</h1>
@stop

@section('content')
    <p>Mengelola data pengguna.</p>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="mr-auto">Data pengguna</span>
            @can('create', App\Models\User::class)
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
            @endcan
        </div>
        <div class="card-body">
            <section>
                @include('user.partials.datatable')
            </section>
        </div>
    </div>
@stop
