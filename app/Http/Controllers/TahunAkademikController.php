<?php

namespace App\Http\Controllers;

use App\Helpers\TahunAkademikHelper;
use App\Http\Requests\Akademik\TahunAkademikRequest;
use App\Models\TahunAkademik;
use Carbon\Carbon;
use Inertia\Inertia;

class TahunAkademikController extends Controller
{
    public function create()
    {
        return view('jadwal_pendaftaran.tahun_akademik.create', [
            'years' => TahunAkademikHelper::generateYears(),
        ]);
    }

    /**
     * Handling store resource request
     *
     * @param TahunAkademikRequest $request
     * @return mixed
     */
    public function store(TahunAkademikRequest $request)
    {
        $data = $request->tahunAkademikData();

        TahunAkademik::create($data);

        return redirect()->route('jadwal_pendaftaran.index')->with([
            'success' => 'Berhasil menambahkan tahun akademik'
        ]);
    }

    /**
     * Handling delete resource request
     *
     * @param TahunAkademik $tahunAkademik
     * @return mixed
     */
    public function destroy(TahunAkademik $tahunAkademik)
    {
        $this->authorize('delete', $tahunAkademik);

        $tahunAkademik->delete();

        return redirect()->route('jadwal_pendaftaran.index')->with([
            'success' => 'Berhasil menghapus tahun akademik'
        ]);
    }
}
