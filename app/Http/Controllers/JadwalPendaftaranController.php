<?php

namespace App\Http\Controllers;

use App\Http\Requests\Akademik\JadwalPendaftaranRequest;
use App\Models\JadwalPendaftaran;
use App\Models\TahunAkademik;

class JadwalPendaftaranController extends Controller
{
    public function index()
    {
        $this->authorize('view any akademik');

        return view('jadwal_pendaftaran.index', [
            'tahun_akademik' => TahunAkademik::orderBy('tahun_awal', 'desc')->get(),
            'jadwal_pendaftaran' => JadwalPendaftaran::with('tahunAkademik')->get(),
        ]);
    }

    public function create()
    {
        return view('jadwal_pendaftaran.create', [
            'tahun_akademik' => TahunAkademik::orderBy('tahun_awal', 'desc')->get(),
        ]);
    }

    /**
     * Handling incoming store request
     *
     * @param JadwalPendaftaranRequest $request
     * @return mixed
     */
    public function store(JadwalPendaftaranRequest $request)
    {
        $data = $request->validated();

        JadwalPendaftaran::create($data);

        return redirect()->route('jadwal_pendaftaran.index')->with([
            'success' => 'Berhasil menambahkan jadwal pendaftaran',
        ]);
    }

    public function edit(JadwalPendaftaran $jadwalPendaftaran)
    {
        return view('jadwal_pendaftaran.edit', [
            'jadwal_pendaftaran' => $jadwalPendaftaran,
            'tahun_akademik' => TahunAkademik::orderBy('tahun_awal', 'desc')->get(),
        ]);
    }

    /**
     * Handling incoming update request
     *
     * @param JadwalPendaftaranRequest $request
     * @param JadwalPendaftaran $jadwalPendaftaran
     * @return mixed
     */
    public function update(JadwalPendaftaranRequest $request, JadwalPendaftaran $jadwalPendaftaran)
    {
        $data = $request->validated();

        $jadwalPendaftaran->update($data);

        return redirect()->route('jadwal_pendaftaran.edit', $jadwalPendaftaran)->with([
            'success' => 'Berhasil mengubah jadwal pendaftaran',
        ]);
    }

    /**
     * Handling incoming delete request
     *
     * @param JadwalPendaftaran $jadwalPendaftaran
     * @return mixed
     */
    public function destroy(JadwalPendaftaran $jadwalPendaftaran)
    {
        $this->authorize('delete', $jadwalPendaftaran);

        $jadwalPendaftaran->delete();

        return redirect()->route('jadwal_pendaftaran.index')->with([
            'success' => 'Berhasil menghapus jadwal pendaftaran',
        ]);
    }
}
