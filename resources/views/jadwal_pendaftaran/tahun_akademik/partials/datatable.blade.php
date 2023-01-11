@php
$heads = [
    'No',
    'Nama',
    ['label' => 'Aksi', 'no-export' => true, 'width' => 5],
];

$config = [
    'data' => $tahun_akademik->map(function ($value, $i) {
        $canDelete = auth()->user()->can('delete', $value);

        return [
            'no' => $i + 1,
            'nama' => $value->nama,
            'actions' =>
                $canDelete ? '<nobr>' . view('partials.delete_button', ['route' => route('tahun_akademik.destroy', $value)]) . '</nobr>' : '',
        ];
    }),
    'order' => [[0, 'asc']],
    'columns' => [
        ['data' => 'no'],
        ['data' => 'nama'],
        ['data' => 'actions', 'orderable' => false]
    ],
];
@endphp

{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="tahun_akademik" :heads="$heads" :config="$config" striped hoverable bordered />
