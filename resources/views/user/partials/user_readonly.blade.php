<table class="table table-borderless">
    <tbody>
        <tr>
            <th width="5">Nama</th>
            <td>{{ $user->nama }}</td>
        </tr>
        <tr>
            <th>Username</th>
            <td>{{ $user->username }}</td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td>{{ $user->getJk() ?? '-' }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email ?? '-' }}</td>
        </tr>
        <tr>
            <th>No. Hp</th>
            <td>{{ $user->no_hp ?? '-' }}</td>
        </tr>
        <tr>
            <th>Peran</th>
            <td>
                @foreach ($user->getRoleNames() as $role)
                    {{ $role }} {{ !$loop->last ? ', ' : '' }}
                @endforeach
            </td>
        </tr>
    </tbody>
</table>
