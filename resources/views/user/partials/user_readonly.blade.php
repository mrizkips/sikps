<div class="mb-3 row">
    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
    <div class="col-sm-10">
        <p id="nama" class="form-control-plaintext">{{ $user->nama }}</p>
    </div>
</div>
<div class="mb-3 row">
    <label for="username" class="col-sm-2 col-form-label">Username</label>
    <div class="col-sm-10">
        <p id="username" class="form-control-plaintext">{{ $user->username }}</p>
    </div>
</div>
<div class="mb-3 row">
    <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
    <div class="col-sm-10">
        <p id="jk" class="form-control-plaintext">{{ $user->getJk() ?? '-' }}</p>
    </div>
</div>
<div class="mb-3 row">
    <label for="email" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
        <p id="email" class="form-control-plaintext">{{ $user->email ?? '-' }}</p>
    </div>
</div>
<div class="mb-3 row">
    <label for="no_hp" class="col-sm-2 col-form-label">No. Hp</label>
    <div class="col-sm-10">
        <p id="no_hp" class="form-control-plaintext">{{ $user->no_hp ?? '-' }}</p>
    </div>
</div>
<div class="mb-3 row">
    <label for="roles" class="col-sm-2 col-form-label">Peran</label>
    <div class="col-sm-10">
        <p id="roles" class="form-control-plaintext">
            @foreach ($user->getRoleNames() as $role)
                {{ $role }}
                @if (!$loop->last)
                    <br>
                @endif
            @endforeach
        </p>
    </div>
</div>
