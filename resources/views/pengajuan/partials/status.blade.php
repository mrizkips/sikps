@php

    $color = 'secondary';

    if ($pengajuan->status == '1') {
        $color = 'primary';
    } else if ($pengajuan->status == '2') {
        $color = 'danger';
    } else if ($pengajuan->status == '3') {
        $color = 'warning';
    } else if ($pengajuan->status == '4') {
        $color = 'primary';
    } else if ($pengajuan->status == '5') {
        $color = 'success';
    }

@endphp

<span class="badge badge-{{ $color }}">
    {{ $pengajuan->getStatus() }}
</span>
