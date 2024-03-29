<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengajuanRequest;
use App\Models\JadwalPendaftaran;
use App\Models\Pengajuan;
use App\Models\Proposal;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Pengajuan::class);

        $pengajuan = Pengajuan::query();

        if (auth()->user()->hasRole('Prodi')) {
            $pengajuan = Pengajuan::persetujuanProdi();
        }

        if (auth()->user()->hasRole('Keuangan')) {
            $pengajuan = Pengajuan::persetujuanKeuangan();
        }

        if (auth()->user()->hasRole('Mahasiswa')) {
            $pengajuan = Pengajuan::byMahasiswaId(auth()->user()->mahasiswa->id);
        }

        if ($jurusan = $request->get('filter_jurusan')) {
            $pengajuan->byJurusan($jurusan);
        }

        if ($request->get('filter_status') || $request->get('filter_status') == '0') {
            $status = $request->get('filter_status');
            $pengajuan->byStatus($status);
        }

        return view('pengajuan.index', [
            'pengajuan' => $pengajuan->latest()->get(),
        ]);
    }

    public function show(Pengajuan $pengajuan)
    {
        $this->authorize('view', $pengajuan);

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

        $catatan = $request->input('catatan');
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

        $catatan = $request->input('catatan');
        $pengajuan->pay($catatan);

        return redirect()->route('pengajuan.index')->with([
            'success' => 'Berhasil menerima pengajuan'
        ]);
    }

    public function activate(Pengajuan $pengajuan)
    {
        $this->authorize('activate', $pengajuan);

        $pengajuan->activate();

        return redirect()->route('pengajuan.index')->with([
            'success' => 'Berhasil mengaktivasi kp/skripsi'
        ]);
    }
}
