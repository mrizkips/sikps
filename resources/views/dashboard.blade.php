@extends('layouts.app')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Dashboard</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <p>Selamat datang kembali, {{ auth()->user()->nama }}</p>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">List Jadwal Pendaftaran</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="min-width: 200px">Judul</th>
                                    <th>Jenis</th>
                                    <th>Mulai</th>
                                    <th>Berakhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwal_pendaftaran as $jadwal)
                                    <tr>
                                        <td>{{ $jadwal->judul }}<br><small>{{ $jadwal->tahunAkademik->nama }} - {{ $jadwal->getSemester() }}</small></td>
                                        <td>{{ $jadwal->getJenis() }}</td>
                                        <td>{{ $jadwal->tgl_pembukaan->format('d M Y') }}</td>
                                        <td>{{ $jadwal->tgl_penutupan->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">List Pengajuan</div>
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Judul</th>
                                <th>Jenis</th>
                                <th>Mahasiswa</th>
                                <th>Tahun Akademik</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengajuan as $pengajuan)
                                <tr>
                                    <td>@include('pengajuan.partials.status', ['pengajuan' => $pengajuan])</td>
                                    <td>{{ $pengajuan->proposal->judul }}</td>
                                    <td>{{ $pengajuan->getJenis() }}<br>{{ $pengajuan->proposal->getJenis() }}</td>
                                    <td>@include('pengajuan.partials.mahasiswa_view', ['mahasiswa' => $pengajuan->mahasiswa])</td>
                                    <td>{{ $pengajuan->tahunAkademik->nama }}<br>{{ $pengajuan->jadwalPendaftaran->getSemester() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
