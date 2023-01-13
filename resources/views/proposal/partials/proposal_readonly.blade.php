<table class="table">
    <tbody>
        <tr>
            <th>Judul</th>
            <td>{{ $proposal->judul }}</td>
        </tr>
        <tr>
            <th>Jenis</th>
            <td>{{ $proposal->getJenis() }}</td>
        </tr>
        <tr>
            <th>File Proposal</th>
            <td>
                <a href="{{ route('proposal.download', $proposal) }}" class="btn btn-primary btn-sm"><i class="fas fa-file-download"></i> Download file</a>
            </td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>{{ $proposal->deskripsi }}</td>
        </tr>
        <tr>
            <th>Organisasi</th>
            <td>{{ $proposal->organisasi }}</td>
        </tr>
    </tbody>
</table>
