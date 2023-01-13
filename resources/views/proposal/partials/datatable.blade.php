@php
$heads = [
    'No',
    'Judul',
    'Jenis',
    'Deskripsi',
    'Organisasi',
    ['label' => 'Aksi', 'no-export' => true, 'width' => 5],
];

$config = [
    'data' => $proposal->map(function ($value, $i) {
        $canView = auth()->user()->can('view', $value);
        $canUpdate = auth()->user()->can('update', $value);
        $canDelete = auth()->user()->can('delete', $value);
        $canSend = auth()->user()->can('send', $value);

        return [
            'no' => $i + 1,
            'judul' => $value->judul,
            'jenis' => $value->getJenis(),
            'deskripsi' => $value->deskripsi,
            'organisasi' => $value->organisasi ?? '-',
            'actions' =>
                str($canView ? '<nobr>' . view('partials.buttons.download', ['route' => route('proposal.download', $value)]) . '</nobr>' : '') .
                str($canSend ? '<nobr>' . view('partials.buttons.send', ['route' => route('proposal.send', $value)]) . '</nobr>' : '') .
                str($canView ? '<nobr>' . view('partials.buttons.show', ['route' => route('proposal.show', $value)]) . '</nobr>' : '') .
                str($canUpdate ? '<nobr>' . view('partials.buttons.edit', ['route' => route('proposal.edit', $value)]) . '</nobr>' : '') .
                str($canDelete ? '<nobr>' . view('partials.buttons.delete', ['route' => route('proposal.destroy', $value)]) . '</nobr>' : ''),
        ];
    }),
    'order' => [[0, 'asc']],
    'columns' => [
        ['data' => 'no'],
        ['data' => 'judul'],
        ['data' => 'jenis'],
        ['data' => 'deskripsi'],
        ['data' => 'organisasi'],
        ['data' => 'actions', 'orderable' => false]
    ],
];
@endphp

{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="jadwal_pendaftaran" :heads="$heads" :config="$config" striped hoverable bordered />
