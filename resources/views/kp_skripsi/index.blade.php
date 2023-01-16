@extends('layouts.app')

@section('title', 'Kerja Praktek & Skripsi')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Kerja Praktek & Skripsi</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Kerja Praktek & Skripsi</li>
            </ol>
        </div>
    </div>
@stop

@php
    $config = [
        'tags' => true,
        'placeholder' => 'Pilih Dosen Pembimbing',
        'data' => $dosen->map(function ($value, $i) {
            return [
                'id' => $value->id,
                'text' => $value->kd_dosen . ' - ' . $value->nama,
            ];
        }),
    ];
@endphp

@section('content')
    <p>Mengelola data kerja praktek & skripsi.</p>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="mr-auto">Data Kerja Praktek & Skripsi</span>
        </div>
        <div class="card-body">
            <section>
                @include('kp_skripsi.partials.datatable', ['kp_skripsi' => $kp_skripsi, 'dosen' => $dosen])
            </section>
        </div>
    </div>

    <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignLabel" aria-hidden="true" data-focus="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignLabel">Tetapkan Dosen Pembimbing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="assignForm">
                    <div class="modal-body">
                        @csrf

                        @section('plugins.Select2', true)

                        <x-adminlte-select2 name="dosen_pembimbing_id" :config="$config" />

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin dengan aksi ini?')"><i class="fas fa-user-check"></i> Tetapkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $('#assignModal').on('show.bs.modal', (event) => {
                const id = $(event.relatedTarget).data('id')
                $('#assignForm').attr('action', '/kp_skripsi/' + id + '/assignDosen')
            })
        </script>
    @endpush
@stop
