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
            'pengajuan' => Pengajuan::latest(),
        ]);
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

    public function accept(Pengajuan $pengajuan)
    {
        $this->authorize('accept', $pengajuan);

        $pengajuan->accept();

        return redirect()->route('pengajuan.index')->with([
            'success' => 'Berhasil menerima pengajuan'
        ]);
    }

    public function reject(Pengajuan $pengajuan)
    {
        $this->authorize('reject', $pengajuan);

        $pengajuan->reject();

        return redirect()->route('pengajuan.index')->with([
            'success' => 'Berhasil menolak pengajuan'
        ]);
    }

    public function pay(Pengajuan $pengajuan)
    {
        $this->authorize('pay', $pengajuan);

        $pengajuan->pay();

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
