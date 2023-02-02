@php
$heads = [
    ['label' => 'No', 'width' => 1],
    'Status',
    ['label' => 'Judul', 'width' => 30],
    'Jenis',
    ['label' => 'NIM'],
    ['label' => 'Nama', 'width' => 30],
    'Semester',
    'Tahun Akademik',
    'Tanggal Pengajuan',
    ['label' => 'Aksi', 'no-export' => true, 'width' => 5],
];

$config = [
    'dom' => 'Bfrtip',
    'buttons' => [
        [
            'extend' => 'excelHtml5',
            'title' => 'Data pengajuan KP & Skripsi'
        ],
        [
            'extend' => 'csvHtml5',
            'title' => 'Data pengajuan KP & Skripsi'
        ],
        [
            'extend' => 'pdfHtml5',
            'title' => 'Data pengajuan KP & Skripsi'
        ],
    ],
    'data' => $pengajuan->map(function ($value, $i) {
        $canAccept = auth()->user()->can('accept', $value);
        $canReject = auth()->user()->can('reject', $value);
        $canPay = auth()->user()->can('pay', $value);
        $canActivate = auth()->user()->can('activate', $value);
        $canView = auth()->user()->can('view', $value);
        $canDelete = auth()->user()->can('delete', $value);

        return [
            'no' => $i + 1,
            'status' => str(view('pengajuan.partials.status', ['pengajuan' => $value])),
            'judul' => $value->proposal->judul,
            'jenis' => str($value->getJenis() . '<br>' . '<nobr>' . $value->proposal->getJenis() . '</nobr>'),
            'nim' => $value->mahasiswa->nim,
            'nama' => $value->mahasiswa->nama,
            'semester' => $value->jadwalPendaftaran->getSemester(),
            'tahunAkademik' => $value->tahunAkademik->nama,
            'tanggalPengajuan' => $value->created_at->format('d M Y'),
            'actions' =>
                str($canAccept ? '<nobr>' . view('partials.buttons.accept', ['route' => route('pengajuan.accept', $value), 'id' => $value->id]) . '</nobr>' : '') .
                str($canReject ? '<nobr>' . view('partials.buttons.reject', ['route' => route('pengajuan.reject', $value), 'id' => $value->id]) . '</nobr>' : '') .
                str($canPay ? '<nobr>' . view('partials.buttons.pay', ['route' => route('pengajuan.pay', $value), 'id' => $value->id]) . '</nobr>' : '') .
                str($canActivate ? '<nobr>' . view('partials.buttons.activate', ['route' => route('pengajuan.activate', $value)]) . '</nobr>' : '') .
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
        ['data' => 'nim'],
        ['data' => 'nama'],
        ['data' => 'semester'],
        ['data' => 'tahunAkademik'],
        ['data' => 'tanggalPengajuan'],
        ['data' => 'actions', 'orderable' => false],
    ],
];
@endphp

{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="jadwal_pendaftaran" :heads="$heads" :config="$config" striped hoverable bordered />
