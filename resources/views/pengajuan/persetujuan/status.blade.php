@php

    $color = 'secondary';

    if ($persetujuan->status == '1') {
        $color = 'primary';
    } else if ($persetujuan->status == '2') {
        $color = 'danger';
    }

@endphp

<span class="badge badge-{{ $color }}">
    {{ $persetujuan->getStatus() }}
</span>
