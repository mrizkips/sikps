<?php

namespace App\Http\Controllers;

use App\Models\KpSkripsi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KpSkripsiController extends Controller
{
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

        $kpSkripsi->printFormBimbingan();

        $pdf = Pdf::loadView('kp_skripsi.pdf.form_bimbingan', ['kpSkripsi' => $kpSkripsi->fresh()]);

        $file = 'Form_bimbingan_' . $kpSkripsi->mahasiswa->nim;
        return $pdf->stream($file . '.pdf');
    }
}
