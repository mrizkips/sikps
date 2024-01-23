<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditJudulProposalRequest;
use App\Models\Dosen;
use App\Models\KpSkripsi;
use App\Models\LogPerubahanJudul;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KpSkripsiController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', KpSkripsi::class);

        $user = auth()->user();

        $kpSkripsi = KpSkripsi::query();

        if ($user->hasRole('Mahasiswa')) {
            $kpSkripsi = KpSkripsi::byMahasiswaId($user->mahasiswa->id);
        }

        if ($user->hasExactRoles('Dosen')) {
            $kpSkripsi = KpSkripsi::byDosenId($user->dosen->id);
        }

        if ($user->can('assign dosen kp skripsi') && $dosen_pembimbing = $request->input('filter_dosen_pembimbing')) {
            if ($dosen_pembimbing != 'null' && $dosen_pembimbing != null) {
                $kpSkripsi = KpSkripsi::byDosenId($dosen_pembimbing);
            } else {
                $kpSkripsi = KpSkripsi::doesntHaveMentor();
            }
        }

        return view('kp_skripsi.index', [
            'kp_skripsi' => $kpSkripsi->byStatusNotLulus()->get(),
            'dosen' => Dosen::all(),
        ]);
    }

    public function show(KpSkripsi $kpSkripsi)
    {
        $logs = LogPerubahanJudul::findByKpSkripsiId($kpSkripsi->id)->limit(5)->get();

        return view('kp_skripsi.show', [
            'kp_skripsi' => $kpSkripsi,
            'logs' => $logs,
        ]);
    }

    public function editJudul(KpSkripsi $kpSkripsi)
    {
        $logs = LogPerubahanJudul::findByKpSkripsiId($kpSkripsi->id)->limit(5)->get();

        return view('kp_skripsi.editJudul', [
            'kp_skripsi' => $kpSkripsi,
            'logs' => $logs,
        ]);
    }

    public function updateJudul(EditJudulProposalRequest $request, KpSkripsi $kpSkripsi)
    {
        $data = $request->validated();

        $kpSkripsi->updateJudul($data, auth()->user()->id);

        return redirect()->route('kp_skripsi.edit_judul', $kpSkripsi)->with([
            'success' => 'Berhasil mengubah judul proposal'
        ]);
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

    public function graduate(KpSkripsi $kpSkripsi)
    {
        $this->authorize('graduate', $kpSkripsi);

        $kpSkripsi->graduate();

        return redirect()->route('kp_skripsi.index')->with([
            'success' => 'Berhasil mengubah status'
        ]);
    }
}
