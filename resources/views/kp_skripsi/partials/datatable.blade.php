@php
$heads = [
    ['label' => 'No', 'width' => 1],
    ['label' => 'Judul', 'width' => 30],
    'Jenis',
    ['label' => 'Mahasiswa', 'width' => 30],
    'Semester',
    'Tahun Akademik',
    'Pembimbing',
    ['label' => 'Aksi', 'no-export' => true, 'width' => 5],
];

$config = [
    'data' => $kp_skripsi->map(function ($value, $i) use ($dosen) {
        $canView = auth()->user()->can('view', $value);
        $canAssign = auth()->user()->can('assignDosen', $value);
        $canPrint = auth()->user()->can('printFormBimbingan', $value);

        return [
            'no' => $i + 1,
            'judul' => $value->proposal->judul,
            'jenis' => str($value->proposal->getJenis()),
            'mahasiswa' => str(view('pengajuan.partials.mahasiswa_view', ['mahasiswa' => $value->mahasiswa])),
            'semester' => $value->jadwalPendaftaran->getSemester(),
            'tahunAkademik' => $value->tahunAkademik->nama,
            'pembimbing' => $value->dosen->nama ?? '-',
            'actions' =>
                str($canView ? '<nobr>' . view('partials.buttons.download', ['route' => route('proposal.download', $value->proposal)]) . '</nobr>' : '') .
                str($canAssign ? '<nobr>' . view('partials.buttons.assignDosen', ['route' => route('kp_skripsi.assign_dosen', $value), 'id' => $value->id]) . '</nobr>' : '') .
                str($canPrint ? '<nobr>' . view('partials.buttons.printFormBimbingan', ['route' => route('kp_skripsi.print_form_bimbingan', $value)]) . '</nobr>' : '') .
                str($canView ? '<nobr>' . view('partials.buttons.show', ['route' => route('kp_skripsi.show', $value)]) . '</nobr>' : '')
        ];
    }),
    'order' => [[0, 'asc']],
    'columns' => [
        ['data' => 'no'],
        ['data' => 'judul'],
        ['data' => 'jenis'],
        ['data' => 'mahasiswa'],
        ['data' => 'semester'],
        ['data' => 'tahunAkademik'],
        ['data' => 'pembimbing'],
        ['data' => 'actions', 'orderable' => false],
    ],
];
@endphp

{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="jadwal_pendaftaran" :heads="$heads" :config="$config" striped hoverable bordered />
