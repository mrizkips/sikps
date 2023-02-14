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

@section('plugins.Select2', true)

@section('content')
    <p>Selamat datang kembali, {{ auth()->user()->nama }}</p>

    <div class="row">
        @if ($jadwal_pendaftaran->isNotEmpty())
        <div class="col-lg-6">
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
        @endif
        @if ($kp_skripsi->isNotEmpty())
        @php
            $configFilter = [
                'allowClear' => true,
                'placeholder' => 'Pilih Jadwal Pendaftaran',
                'data' => $jadwal_pendaftaran->map(function ($value, $i) {
                    return [
                        'id' => $value->id,
                        'text' => $value->judul
                    ];
                }),
            ];
        @endphp
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <div class="col-lg">Statistik Jumlah Bimbingan</div>
                    <div class="col-lg ml-auto">
                        <form action="{{ request()->fullUrl() }}">
                            <x-adminlte-select2
                                name="filter_jadwal_pendaftaran"
                                :config="$configFilter" />
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sm fa-filter"></i> Filter Data
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Dosen</th>
                                    <th style="min-width: 200px">Periode Pengajuan</th>
                                    <th>Jumlah Bimbingan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kp_skripsi as $kpSkripsi)
                                    <tr>
                                        <td>{{ $kpSkripsi->dosen }}</td>
                                        <td>{{ $kpSkripsi->judul }}<br><small>{{ $kpSkripsi->nama }} - @switch($kpSkripsi->semester)
                                            @case('1')
                                                Ganjil
                                                @break
                                            @case(2)
                                                Genap
                                                @break
                                            @case(3)
                                                Antara
                                                @break
                                            @default

                                        @endswitch</small></td>
                                        <td>{{ $kpSkripsi->total_bimbingan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if ($pengajuan->isNotEmpty())
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">List Pengajuan</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
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
        @endif
    </div>
@stop
