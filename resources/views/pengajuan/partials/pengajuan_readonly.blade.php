<table class="table">
    <tbody>
        <tr>
            <th>Status</th>
            <td>@include('pengajuan.partials.status')</td>
        </tr>
        <tr>
            <th>Semester</th>
            <td>{{ $pengajuan->jadwalPendaftaran->getSemester() }}</td>
        </tr>
        <tr>
            <th>Tahun Akademik</th>
            <td>{{ $pengajuan->tahunAkademik->nama }}</td>
        </tr>
        <tr>
            <th>Jenis</th>
            <td>{{ $pengajuan->getJenis() }}</td>
        </tr>
    </tbody>
</table>
