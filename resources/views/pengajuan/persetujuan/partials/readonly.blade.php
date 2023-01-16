<table class="table">
    <thead>
        <tr>
            <th width="3">#</th>
            <th width="5">Peran</th>
            <th>Nama</th>
            <th width="5">Status</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($persetujuan as $persetujuan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $persetujuan->role_name }}</td>
                <td>{{ $persetujuan->user->nama ?? '-' }}</td>
                <td>@include('pengajuan.persetujuan.status')</td>
                <td>{{ $persetujuan->catatan ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
