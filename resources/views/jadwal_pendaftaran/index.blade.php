@extends('layouts.app')

@section('title', 'Jadwal Pendaftaran')

@section('content_header')
    <h1>Jadwal Pendaftaran</h1>
@stop

@section('content')
    <p>Mengelola data jadwal pendaftaran.</p>

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Data tahun akademik</span>
                    @can('create', App\Models\TahunAkademik::class)
                    <a href="{{ route('tahun_akademik.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Data
                    </a>
                    @endcan
                </div>
                <div class="card-body">
                    <section>
                        @include('jadwal_pendaftaran.tahun_akademik.partials.datatable')
                    </section>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Data jadwal pendaftaran</span>
                    @can('create', App\Models\JadwalPendaftaran::class)
                    <a href="{{ route('jadwal_pendaftaran.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Data
                    </a>
                    @endcan
                </div>
                <div class="card-body">
                    <section>
                        @include('jadwal_pendaftaran.partials.datatable')
                    </section>
                </div>
            </div>
        </div>
    </div>
@stop
