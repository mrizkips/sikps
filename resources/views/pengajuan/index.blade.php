@extends('layouts.app')

@section('title', 'Pengajuan')

@section('content_header')
    <h1>Pengajuan</h1>
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

            </section>
        </div>
    </div>
@stop
