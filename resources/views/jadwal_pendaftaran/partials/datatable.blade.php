@php
$heads = [
    ['label' => 'No', 'width' => 1],
    ['label' => 'Judul', 'width' => 50],
    'Jenis',
    ['label' => 'Periode', 'width' => 25],
    'Semester',
    'Tahun Akademik',
    ['label' => 'Aksi', 'no-export' => true, 'width' => 5],
];

$config = [
    'data' => $jadwal_pendaftaran->map(function ($value, $i) {
        $canUpdate = auth()->user()->can('update', $value);
        $canDelete = auth()->user()->can('delete', $value);

        return [
            'no' => $i + 1,
            'judul' => $value->judul,
            'jenis' => $value->getJenis(),
            'periode' => $value->tgl_pembukaan->format('d F Y') . ' - ' . $value->tgl_penutupan->format('d F Y'),
            'semester' => $value->getSemester(),
            'tahun_akademik' => $value->tahunAkademik->nama,
            'actions' =>
                str($canUpdate ? '<nobr>' . view('partials.buttons.edit', ['route' => route('jadwal_pendaftaran.edit', $value)]) . '</nobr>' : '') .
                str($canDelete ? '<nobr>' . view('partials.buttons.delete', ['route' => route('jadwal_pendaftaran.destroy', $value)]) . '</nobr>' : ''),
        ];
    }),
    'order' => [[0, 'asc']],
    'columns' => [
        ['data' => 'no'],
        ['data' => 'judul'],
        ['data' => 'jenis'],
        ['data' => 'periode'],
        ['data' => 'semester'],
        ['data' => 'tahun_akademik'],
        ['data' => 'actions', 'orderable' => false]
    ],
];
@endphp

{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="jadwal_pendaftaran" :heads="$heads" :config="$config" striped hoverable bordered />
