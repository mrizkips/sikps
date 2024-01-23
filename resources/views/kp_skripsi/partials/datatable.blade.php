@php
$heads = [
    ['label' => 'No', 'width' => 1],
    ['label' => 'Judul', 'width' => 30],
    'Jenis',
    'NIM',
    ['label' => 'Nama'],
    'Semester',
    'Tahun Akademik',
    'Pembimbing',
    ['label' => 'Aksi', 'no-export' => true, 'width' => 5],
];

$config = [
    'dom' => 'Bfrtip',
    'buttons' => [
        [
            'extend' => 'excelHtml5',
            'title' => 'Data KP dan Skripsi'
        ],
        [
            'extend' => 'csvHtml5',
            'title' => 'Data KP dan Skripsi'
        ],
        [
            'extend' => 'pdfHtml5',
            'title' => 'Data KP dan Skripsi'
        ],
    ],
    'data' => $kp_skripsi->map(function ($value, $i) use ($dosen) {
        $canView = auth()->user()->can('view', $value);
        $canUpdate = auth()->user()->can('update', $value);
        $canAssign = auth()->user()->can('assignDosen', $value);
        $canPrint = auth()->user()->can('printFormBimbingan', $value);
        $canGraduate = auth()->user()->can('graduate', $value);

        return [
            'no' => $i + 1,
            'judul' => $value->proposal->judul,
            'jenis' => str($value->proposal->getJenis()),
            'nim' => $value->mahasiswa->nim,
            'nama' => $value->mahasiswa->nama,
            'semester' => $value->jadwalPendaftaran->getSemester(),
            'tahunAkademik' => $value->tahunAkademik->nama,
            'pembimbing' => $value->dosen->nama ?? '-',
            'actions' =>
                str($canView ? '<nobr>' . view('partials.buttons.download', ['route' => route('proposal.download', $value->proposal)]) . '</nobr>' : '') .
                str($canAssign ? '<nobr>' . view('partials.buttons.assignDosen', ['route' => route('kp_skripsi.assign_dosen', $value), 'id' => $value->id]) . '</nobr>' : '') .
                str($canPrint ? '<nobr>' . view('partials.buttons.printFormBimbingan', ['route' => route('kp_skripsi.print_form_bimbingan', $value)]) . '</nobr>' : '') .
                str($canView ? '<nobr>' . view('partials.buttons.show', ['route' => route('kp_skripsi.show', $value)]) . '</nobr>' : '') .
                str($canUpdate ? '<nobr>' . view('partials.buttons.edit', ['route' => route('kp_skripsi.edit_judul', $value), 'title' => 'Ubah Judul']) . '</nobr>' : '') .
                str($canGraduate ? '<nobr>' . view('partials.buttons.graduate', ['route' => route('kp_skripsi.graduate', $value), 'title' => 'Lulus']) . '</nobr>' : '')
        ];
    }),
    'order' => [[0, 'asc']],
    'columns' => [
        ['data' => 'no'],
        ['data' => 'judul'],
        ['data' => 'jenis'],
        ['data' => 'nim'],
        ['data' => 'nama'],
        ['data' => 'semester'],
        ['data' => 'tahunAkademik'],
        ['data' => 'pembimbing'],
        ['data' => 'actions', 'orderable' => false],
    ],
];
@endphp

{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="jadwal_pendaftaran" :heads="$heads" :config="$config" striped hoverable bordered />
