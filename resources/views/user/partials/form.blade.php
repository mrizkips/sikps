<x-adminlte-input
    type="text"
    label="Nama*"
    name="nama"
    value="{{ old('nama', $user->nama ?? '') }}"
    />

<x-adminlte-input
    type="text"
    label="Username*"
    name="username"
    value="{{ old('username', $user->username ?? '') }}"
    />

<div class="form-group">
    <label for="jk">Jenis Kelamin</label>
    <div class="input-group">
        <div class="form-check">
            <input class="form-check-input @error('jk') is-invalid @enderror" type="radio" name="jk" value="L" @checked(old('jk', $user->jk ?? '') === 'L')>
            <label class="form-check-label">Laki-laki</label>
        </div>
    </div>
    <div class="input-group">
        <div class="form-check">
            <input class="form-check-input @error('jk') is-invalid @enderror" type="radio" name="jk" value="P" @checked(old('jk', $user->jk ?? '') === 'P')>
            <label class="form-check-label">Perempuan</label>
            @error('jk')
                <div class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>
    </div>
</div>

<x-adminlte-input
    type="email"
    label="Email"
    name="email"
    value="{{ old('email', $user->email ?? '') }}"
    />

<x-adminlte-input
    type="number"
    label="No. Hp"
    name="no_hp"
    value="{{ old('no_hp', $user->no_hp ?? '') }}"
    />

<div class="form-group">
    <label for="jk">Peran*</label>
    @foreach ($roles as $role)
    <div class="input-group">
        <div class="form-check">
            <input
                class="form-check-input @error('roles') is-invalid @enderror"
                type="checkbox"
                name="roles[]"
                id="{{ str($role->name)->lower() }}"
                value="{{ $role->name }}"
                onclick="handleRoleChecked(this)"
                @checked(collect(old('roles', isset($user) ? $user->getRoleNames() : false))->contains($role->name))
                >
            <label class="form-check-label">{{ $role->name }}</label>
            @if ($loop->last)
                @error('roles')
                    <div class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            @endif
        </div>
    </div>
    @endforeach
</div>

<section id="form-mahasiswa" style="display: none">

    <x-adminlte-input
        type="text"
        label="NIM*"
        name="nim"
        value="{{ old('nim', $user->mahasiswa->nim ?? '') }}"
        />

    <x-adminlte-select
        label="Jurusan*"
        name="jurusan"
        >
        <option selected disabled>Pilih Jurusan</option>
        <option value="1" @selected(old('jurusan', $user->mahasiswa->jurusan ?? '') === '1')>Sistem Informasi</option>
        <option value="2" @selected(old('jurusan', $user->mahasiswa->jurusan ?? '') === '2')>Teknik Informatika</option>
    </x-adminlte-select>

</section>

<section id="form-dosen" style="display: none">

    <x-adminlte-input
        type="text"
        label="Kode Dosen*"
        name="kd_dosen"
        value="{{ old('kd_dosen', $user->dosen->kd_dosen ?? '') }}"
        />

    <x-adminlte-input
        type="text"
        label="NIDN"
        name="nidn"
        value="{{ old('nidn', $user->dosen->nidn ?? '') }}"
        />

    <x-adminlte-input
        type="text"
        label="Inisial*"
        name="inisial"
        value="{{ old('inisial', $user->dosen->inisial ?? '') }}"
        />

</section>

@section('js')
<script>
    $(document).ready(() => {
        $('#form-mahasiswa').toggle($('#mahasiswa').is(':checked'))
        $('#form-dosen').toggle($('#dosen').is(':checked'))
    })

    const handleRoleChecked = ({ id, checked }) => {
        if (id === 'mahasiswa') {
            $('#form-mahasiswa').slideToggle(checked)
        }

        if (id === 'dosen') {
            $('#form-dosen').slideToggle(checked)
        }
    }
</script>
@stop
