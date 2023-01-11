<x-adminlte-input
    type="text"
    name="nama"
    label="Nama*"
    value="{{ $user->nama }}"
    required
    readonly
    />

<x-adminlte-input
    type="text"
    name="username"
    label="Username*"
    value="{{ $user->username }}"
    required
    readonly
    />

<div class="form-group">
    <label for="jk">Jenis Kelamin</label>
    <div class="input-group">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="jk" value="L" @checked($user->jk === 'L')>
            <label class="form-check-label">Laki-laki</label>
        </div>
    </div>
    <div class="input-group">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="jk" value="P" @checked($user->jk === 'P')>
            <label class="form-check-label">Perempuan</label>
        </div>
    </div>
</div>

<x-adminlte-input
    type="email"
    name="email"
    label="Email"
    value="{{ $user->email }}"
    />

<x-adminlte-input
    type="numeric"
    name="no_hp"
    label="No. Hp"
    value="{{ $user->no_hp }}"
    />

