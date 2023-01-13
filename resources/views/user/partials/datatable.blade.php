@php
$heads = [
    ['label' => 'No', 'width' => 1],
    ['label' => 'Nama', 'width' => 25],
    'Info',
    ['label' => 'Peran', 'width' => 15],
    ['label' => 'Aksi', 'no-export' => true, 'width' => 5],
];

$config = [
    'data' => $users->map(function ($value, $i) {
        $canView = auth()->user()->can('view', $value);
        $canUpdate = auth()->user()->can('update', $value);
        $canDelete = auth()->user()->can('delete', $value);

        return [
            'no' => $i + 1,
            'nama' => $value->nama,
            'info' => str(view('user.partials.info_view', ['user' => $value])),
            'peran' => $value->getRoleNames(),
            'actions' =>
                str($canView ? '<nobr>' . view('partials.buttons.show', ['route' => route('users.show', $value)]) . '</nobr>' : '') .
                str($canUpdate ? '<nobr>' . view('partials.buttons.edit', [
                    'route' => $value->id === auth()->user()->id ? route('profile.edit') : route('users.edit', $value)
                ]) . '</nobr>' : '') .
                str($canDelete ? '<nobr>' . view('partials.buttons.delete', ['route' => route('users.destroy', $value)]) . '</nobr>' : ''),
        ];
    }),
    'order' => [[0, 'asc']],
    'columns' => [
        ['data' => 'no'],
        ['data' => 'nama'],
        ['data' => 'info'],
        ['data' => 'peran'],
        ['data' => 'actions', 'orderable' => false],
    ],
];
@endphp

{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="users" :heads="$heads" :config="$config" striped hoverable bordered />
