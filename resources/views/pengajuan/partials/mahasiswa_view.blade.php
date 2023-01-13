@if ($mahasiswa)
    <dl>
        <dt>Nama</dt>
        <dd>{{ $mahasiswa->nama }}</dd>
    </dl>
    <dl>
        <dt>NIM</dt>
        <dd>{{ $mahasiswa->nim }}</dd>
    </dl>
@else
    <span>-</span>
@endif
