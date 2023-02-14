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

@php
    $configFilter = [
        'allowClear' => true,
        'placeholder' => 'Pilih Prodi',
        'data' => collect([
            ['id' => '1', 'text' => 'Sistem Informasi', 'selected' => request()->get('filter_jurusan') == 1],
            ['id' => '2', 'text' => 'Teknik Informatika', 'selected' => request()->get('filter_jurusan') == 2]
        ]),
    ];
@endphp

@section('plugins.Select2', true)

@section('content')
    <p>Mengelola data pengajuan.</p>

    <div class="card">
        <div class="card-header">Filter Data</div>
        <div class="card-body">
            <form action="{{ request()->fullUrl() }}" method="get">
                <div class="row">
                    <div class="col-lg-4">
                        <x-adminlte-select2
                            label="Berdasarkan prodi"
                            name="filter_jurusan"
                            :config="$configFilter" />
                    </div>
                </div>
                <button class="btn btn-primary">
                    <i class="fas fa-sm fa-filter"></i> Filter Data
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="mr-auto">Data Pengajuan</span>
        </div>
        <div class="card-body">
            <section>
                @include('pengajuan.partials.datatable')
            </section>
        </div>
    </div>
@stop
