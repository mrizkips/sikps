@php
    $options = collect($years)->map(function ($value) {
        return [
            'value' => $value,
            'name' => $value . '/' . $value + 1,
        ];
    });
@endphp

<x-adminlte-select
    id="tahun_awal"
    name="tahun_awal"
    label="Tahun Akademik">
    <option selected disabled">Pilih Tahun Akademik</option>
    @foreach ($options as $option)
        <option value="{{ $option['value'] }}">{{ $option['name'] }}</option>
    @endforeach
</x-adminlte-select>
