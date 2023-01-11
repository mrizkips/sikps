@php
    $options = $tahun_akademik->map(function ($value) {
        return [
            'value' => $value->id,
            'name' => $value->nama,
        ];
    });

    $tglPembukaanConfig = [
        "singleDatePicker" => true,
        "startDate" => isset($jadwal_pendaftaran) ? 'js:moment("' . $jadwal_pendaftaran->tgl_pembukaan->format('Y-m-d') . '")' : 'js:moment()',
        "locale" => ['format' => "DD-MM-YYYY"],
    ];

    $tglPenutupanConfig = [
        "singleDatePicker" => true,
        "startDate" => isset($jadwal_pendaftaran) ? 'js:moment("' . $jadwal_pendaftaran->tgl_penutupan->format('Y-m-d') . '")' : 'js:moment()',
        "locale" => ['format' => "DD-MM-YYYY"],
    ];
@endphp

<x-adminlte-input
    type="text"
    id="judul"
    name="judul"
    label="Judul*"
    value="{{ old('judul', $jadwal_pendaftaran->judul ?? '') }}"
    />

<div class="form-group">
    <label for="jenis">Jenis*</label>
    <div class="input-group">
        <div class="form-check">
            <input class="form-check-input @error('jenis') is-invalid @enderror" type="radio" name="jenis" value="1" @checked(old('jenis', $jadwal_pendaftaran->jenis ?? '') === '1')>
            <label class="form-check-label">Proposal</label>
        </div>
    </div>
    <div class="input-group">
        <div class="form-check">
            <input class="form-check-input @error('jenis') is-invalid @enderror" type="radio" name="jenis" value="2" @checked(old('jenis', $jadwal_pendaftaran->jenis ?? '') === '2')>
            <label class="form-check-label">Pra-Sidang</label>
        </div>
    </div>
    <div class="input-group">
        <div class="form-check">
            <input class="form-check-input @error('jenis') is-invalid @enderror" type="radio" name="jenis" value="3" @checked(old('jenis', $jadwal_pendaftaran->jenis ?? '') === '3')>
            <label class="form-check-label">Sidang</label>
            @error('jenis')
                <div class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>
    </div>
</div>

@section('plugins.DateRangePicker', true)

<x-adminlte-date-range name="tgl_pembukaan" label="Tanggal Pembukaan" :config="$tglPembukaanConfig">
    <x-slot name="appendSlot">
        <div class="input-group-text">
            <i class="far fa-calendar-alt"></i>
        </div>
    </x-slot>
</x-adminlte-date-range>

<x-adminlte-date-range name="tgl_penutupan" label="Tanggal Penutupan" :config="$tglPenutupanConfig">
    <x-slot name="appendSlot">
        <div class="input-group-text">
            <i class="far fa-calendar-alt"></i>
        </div>
    </x-slot>
</x-adminlte-date-range>

<div class="form-group">
    <label for="semester">Semester*</label>
    <div class="input-group">
        <div class="form-check">
            <input class="form-check-input @error('semester') is-invalid @enderror" type="radio" name="semester" value="1" @checked(old('semester', $jadwal_pendaftaran->semester ?? '') === '1')>
            <label class="form-check-label">Ganjil</label>
        </div>
    </div>
    <div class="input-group">
        <div class="form-check">
            <input class="form-check-input @error('semester') is-invalid @enderror" type="radio" name="semester" value="2" @checked(old('semester', $jadwal_pendaftaran->semester ?? '') === '2')>
            <label class="form-check-label">Genap</label>
        </div>
    </div>
    <div class="input-group">
        <div class="form-check">
            <input class="form-check-input @error('semester') is-invalid @enderror" type="radio" name="semester" value="3" @checked(old('semester', $jadwal_pendaftaran->semester ?? '') === '3')>
            <label class="form-check-label">Antara</label>
            @error('semester')
                <div class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>
    </div>
</div>

<x-adminlte-select
    id="tahun_akademik_id"
    name="tahun_akademik_id"
    label="Tahun Akademik">
    <option selected disabled">Pilih Tahun Akademik</option>
    @foreach ($options as $option)
        <option value="{{ $option['value'] }}" @selected(old('tahun_akademik_id', $jadwal_pendaftaran->tahun_akademik_id ?? '') == $option['value'])>{{ $option['name'] }}</option>
    @endforeach
</x-adminlte-select>
