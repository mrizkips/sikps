@php
$heads = [
    ['label' => 'No', 'width' => 1],
    'Status',
    ['label' => 'Judul', 'width' => 20],
    'Jenis',
    ['label' => 'Mahasiswa', 'width' => 30],
    'Semester',
    'Tahun Akademik',
    ['label' => 'Aksi', 'no-export' => true, 'width' => 5],
];

$config = [
    'data' => $pengajuan->map(function ($value, $i) {
        $canAccept = auth()->user()->can('accept', $value);
        $canReject = auth()->user()->can('reject', $value);
        $canPay = auth()->user()->can('pay', $value);
        $canView = auth()->user()->can('view', $value);
        $canDelete = auth()->user()->can('delete', $value);

        return [
            'no' => $i + 1,
            'status' => str(view('pengajuan.partials.status', ['pengajuan' => $value])),
            'judul' => $value->proposal->judul,
            'jenis' => str($value->getJenis() . '<br>' . '<nobr>' . $value->proposal->getJenis() . '</nobr>'),
            'mahasiswa' => str(view('pengajuan.partials.mahasiswa_view', ['mahasiswa' => $value->mahasiswa])),
            'semester' => $value->jadwalPendaftaran->getSemester(),
            'tahunAkademik' => $value->tahunAkademik->nama,
            'actions' =>
                str($canAccept ? '<nobr>' . view('partials.buttons.accept', ['route' => route('pengajuan.accept', $value), 'id' => $value->id]) . '</nobr>' : '') .
                str($canReject ? '<nobr>' . view('partials.buttons.reject', ['route' => route('pengajuan.reject', $value), 'id' => $value->id]) . '</nobr>' : '') .
                str($canPay ? '<nobr>' . view('partials.buttons.pay', ['route' => route('pengajuan.pay', $value), 'id' => $value->id]) . '</nobr>' : '') .
                str($canView ? '<nobr>' . view('partials.buttons.download', ['route' => route('proposal.download', $value->proposal)]) . '</nobr>' : '') .
                str($canView ? '<nobr>' . view('partials.buttons.show', ['route' => route('pengajuan.show', $value)]) . '</nobr>' : '') .
                str($canDelete ? '<nobr>' . view('partials.buttons.delete', ['route' => route('pengajuan.destroy', $value)]) . '</nobr>' : ''),
        ];
    }),
    'order' => [[0, 'asc']],
    'columns' => [
        ['data' => 'no'],
        ['data' => 'status'],
        ['data' => 'judul'],
        ['data' => 'jenis'],
        ['data' => 'mahasiswa'],
        ['data' => 'semester'],
        ['data' => 'tahunAkademik'],
        ['data' => 'actions', 'orderable' => false],
    ],
];
@endphp

{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="jadwal_pendaftaran" :heads="$heads" :config="$config" striped hoverable bordered />
