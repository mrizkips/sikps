<?php

namespace App\Http\Controllers;

use App\Models\JadwalPendaftaran;
use App\Models\KpSkripsi;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $pengajuan = Pengajuan::latest();
        $kpSkripsi = KpSkripsi::groupByJadwalPendaftaranIdAndDosenId();

        if ($user->hasRole('Mahasiswa')) {
            $pengajuan = Pengajuan::byMahasiswaId($user->mahasiswa->id)->latest();
        }

        if ($jadwalPendaftaranId = $request->get('filter_jadwal_pendaftaran')) {
            $kpSkripsi = KpSkripsi::groupByJadwalPendaftaranIdAndDosenId($jadwalPendaftaranId);
        }

        return view('dashboard', [
            'jadwal_pendaftaran' => JadwalPendaftaran::with('tahunAkademik')->orderBy('tgl_pembukaan', 'desc')->limit(5)->get(),
            'pengajuan' => $pengajuan->limit(10)->get(),
            'kp_skripsi' => $kpSkripsi->get(),
        ]);
    }
}
