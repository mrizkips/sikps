@extends('layouts.app')

@section('content_header')
<div class="row">
    <div class="col-sm-6">
        <h1>Halaman error @yield('code')</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Error @yield('code')</li>
        </ol>
    </div>
</div>
@stop

@section('content')
<div class="error-page">
    <h2 class="headline text-@yield('message.color')">@yield('code')</h2>
    <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-@yield('message.color')"></i> @yield('message.title')</h3>
        <p>
            @yield('message.body')
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke halaman Dashboard</a>
    </div>

</div>
@stop
