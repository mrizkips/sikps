<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\KpSkripsi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KpSkripsiController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', KpSkripsi::class);

        $kpSkripsi = KpSkripsi::with([
            'proposal',
            'pengajuan',
            'mahasiswa',
            'dosen',
            'tahunAkademik',
            'jadwalPendaftaran'
        ]);

        if (auth()->user()->hasRole('Mahasiswa')) {
            $kpSkripsi->where('mahasiswa_id', auth()->user()->mahasiswa->id);
        }

        return view('kp_skripsi.index', [
            'kp_skripsi' => $kpSkripsi->get(),
            'dosen' => Dosen::all(),
        ]);
    }

    public function show(KpSkripsi $kpSkripsi)
    {
        return view('kp_skripsi.show', ['kp_skripsi' => $kpSkripsi]);
    }

    public function assignDosen(Request $request, KpSkripsi $kpSkripsi)
    {
        $this->authorize('assignDosen', $kpSkripsi);

        $data = $request->validate([
            'dosen_pembimbing_id' => ['required', 'exists:dosen,id']
        ]);

        $kpSkripsi->update($data);

        return redirect()->route('kp_skripsi.index')->with([
            'success' => 'Berhasil menentukan dosen pembimbing'
        ]);
    }

    public function printFormBimbingan(KpSkripsi $kpSkripsi)
    {
        $this->authorize('printFormBimbingan', $kpSkripsi);

        if (!$kpSkripsi->printFormBimbingan()) {
            return redirect()->route('kp_skripsi.index')->with([
                'fail' => 'Dosen pembimbing belum ditentukan'
            ]);
        }

        $pdf = Pdf::loadView('kp_skripsi.pdf.form_bimbingan', ['kpSkripsi' => $kpSkripsi->fresh()]);

        $file = 'Form_bimbingan_' . $kpSkripsi->mahasiswa->nim;
        return $pdf->stream($file . '.pdf');
    }
}
