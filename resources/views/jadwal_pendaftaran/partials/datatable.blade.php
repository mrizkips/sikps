@php
$heads = [
    ['label' => 'Judul', 'width' => 50],
    'Jenis',
    'Mulai',
    'Berakhir',
    ['label' => 'Aksi', 'no-export' => true, 'width' => 5],
];

$config = [
    'data' => $jadwal_pendaftaran->map(function ($value, $i) {
        $canUpdate = auth()->user()->can('update', $value);
        $canDelete = auth()->user()->can('delete', $value);

        return [
            'no' => $i + 1,
            'judul' => $value->judul . '<br>' . '<small>' . $value->tahunAkademik->nama . ' - ' . $value->getSemester() . '</small>',
            'jenis' => $value->getJenis(),
            'mulai' => $value->tgl_pembukaan->format('d M Y'),
            'berakhir' => $value->tgl_penutupan->format('d M Y'),
            'actions' =>
                str($canUpdate ? '<nobr>' . view('partials.buttons.edit', ['route' => route('jadwal_pendaftaran.edit', $value)]) . '</nobr>' : '') .
                str($canDelete ? '<nobr>' . view('partials.buttons.delete', ['route' => route('jadwal_pendaftaran.destroy', $value)]) . '</nobr>' : ''),
        ];
    }),
    'order' => [[2, 'desc']],
    'columns' => [
        ['data' => 'judul', 'orderable' => false],
        ['data' => 'jenis', 'orderable' => false],
        ['data' => 'mulai'],
        ['data' => 'berakhir'],
        ['data' => 'actions', 'orderable' => false, 'searchable' => false]
    ],
];
@endphp

{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="jadwal_pendaftaran" :heads="$heads" :config="$config" striped hoverable bordered />
