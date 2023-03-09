@extends('layouts.app')

@section('title', 'Ubah Judul Proposal')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Ubah Judul Proposal</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kp_skripsi.index') }}">KP & Skripsi</a></li>
                <li class="breadcrumb-item active">Ubah Judul</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <p>Mengubah judul proposal</p>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Form Judul Proposal</div>
                <div class="card-body">
                    <form action="{{ route('kp_skripsi.update_judul', $kp_skripsi) }}" method="post">
                        @csrf
                        @method('put')

                        <x-adminlte-input
                            type="text"
                            label="Judul Lama"
                            name="judul_lama"
                            value="{!! $kp_skripsi->proposal->judul !!}"
                            readonly />

                        <x-adminlte-input
                            type="text"
                            label="Judul Baru*"
                            name="judul"
                            value="{!! old('judul') !!}"
                            />

                        <div class="d-flex justify-content-end">
                            <x-adminlte-button type="submit" label="Simpan" theme="warning" icon="fas fa-save"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if ($logs->isNotEmpty())
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Log Perubahan Judul</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Judul Lama</th>
                                    <th>Judul Baru</th>
                                    <th>Oleh</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        <td>{{ $log->judul_lama }}</td>
                                        <td>{{ $log->judul_baru }}</td>
                                        <td>{{ $log->user->nama }}</td>
                                        <td>{{ $log->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <a href="{{ route('kp_skripsi.index') }}" class="btn btn-secondary my-2">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@stop
