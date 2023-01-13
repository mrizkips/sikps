<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengajuanRequest;
use App\Models\JadwalPendaftaran;
use App\Models\Pengajuan;
use App\Models\Proposal;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index()
    {
        return view('pengajuan.index', [
            'pengajuan' => Pengajuan::with('mahasiswa', 'jadwalPendaftaran', 'tahunAkademik', 'proposal', 'persetujuan')->latest()->get(),
        ]);
    }

    public function show(Pengajuan $pengajuan)
    {
        return view('pengajuan.show', compact('pengajuan'));
    }

    public function store(PengajuanRequest $request)
    {
        $proposal = Proposal::find($request->safe()->only('proposal_id'))->first();

        $proposal->submit($request->input('jadwal_pendaftaran_id'));

        return redirect()->route('pengajuan.index')->with([
            'success' => 'Berhasil menambahkan pengajuan'
        ]);
    }

    public function destroy(Pengajuan $pengajuan)
    {
        $this->authorize('delete', $pengajuan);

        $pengajuan->cancel();

        return redirect()->route('pengajuan.index')->with([
            'success' => 'Berhasil menghapus pengajuan'
        ]);
    }

    public function accept(Request $request, Pengajuan $pengajuan)
    {
        $this->authorize('accept', $pengajuan);

        $catatan = $request->validate([
            'catatan' => ['nullable', 'string'],
        ]);

        $pengajuan->accept($catatan);

        return redirect()->route('pengajuan.index')->with([
            'success' => 'Berhasil menerima pengajuan'
        ]);
    }

    public function reject(Request $request, Pengajuan $pengajuan)
    {
        $this->authorize('reject', $pengajuan);

        $request->validate([
            'catatan' => ['nullable', 'string'],
        ]);

        $catatan = $request->input('catatan');
        $pengajuan->reject($catatan);

        return redirect()->route('pengajuan.index')->with([
            'success' => 'Berhasil menolak pengajuan'
        ]);
    }

    public function pay(Request $request, Pengajuan $pengajuan)
    {
        $this->authorize('pay', $pengajuan);

        $catatan = $request->validate([
            'catatan' => ['nullable', 'string'],
        ]);

        $pengajuan->pay($catatan);

        return redirect()->route('pengajuan.index')->with([
            'success' => 'Berhasil menerima pengajuan'
        ]);
    }

    public function kpSkripsi(Pengajuan $pengajuan)
    {
        $this->authorize('kpSkripsi', $pengajuan);

        $pengajuan->kpSkripsi();

        return redirect()->route('kp_skripsi.index')->with([
            'success' => 'Berhasil menambahkan kp/skripsi'
        ]);
    }
}
