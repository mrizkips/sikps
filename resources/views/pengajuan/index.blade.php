@extends('layouts.app')

@section('title', 'Pengajuan')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Pengajuan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Pengajuan</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <p>Mengelola data pengajuan.</p>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="mr-auto">Data Pengajuan</span>
            {{-- @can('create', App\Models\Pengajuan::class)
            <a href="{{ route('pengajuan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
            @endcan --}}
        </div>
        <div class="card-body">
            <section>
                @include('pengajuan.partials.datatable')
            </section>
        </div>
    </div>
@stop
