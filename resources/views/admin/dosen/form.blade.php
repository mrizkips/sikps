@extends('layouts.base')

@section('title', isset($dosen) ? 'Edit Dosen - '.config('app.name') : 'Tambah Dosen - '.config('app.name'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dosen.index') }}">Dosen</a></li>
    <li class="breadcrumb-item active">{{ isset($dosen) ? 'Edit' : 'Tambah' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <h3 class="mb-4"><strong><i class="cil-education">
            </i>&nbsp;Form</strong>&nbsp;<small>{{ isset($dosen) ? 'Edit' : 'Tambah' }} Dosen</small>
        </h3>
        <small class="text-danger"><em>Isian bertanda (*) wajib diisi</em></small>
        <form class="form-horizontal" action="{{ isset($dosen) ? route('admin.dosen.update', $dosen->id) : route('admin.dosen.store') }}" method="post">
            @csrf
            @isset($dosen) @method('PUT') @endif
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-accent-primary">
                        <div class="card-header"><strong class="text-primary">Input Data Dosen</strong></div>
                        <div class="card-body">
                            @include('dosen.component.fields')
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary"><i class="cil-arrow-thick-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-success float-right"><i class="cil-send"></i> Kirim</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
