<table class="table table-borderless">
    <tbody>
        <tr>
            <th>NIM</th>
            <td>{{ $mahasiswa->nim }}</td>
        </tr>
        <tr>
            <th>Jurusan</th>
            <td>{{ $mahasiswa->getJurusan() }}</td>
        </tr>
    </tbody>
</table>
