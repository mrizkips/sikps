<?php

namespace App\Http\Controllers;

use App\Models\JadwalPendaftaran;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $pengajuan = Pengajuan::with('mahasiswa', 'jadwalPendaftaran', 'tahunAkademik', 'proposal', 'persetujuan')->latest();

        if ($user->hasRole('Mahasiswa')) {
            $pengajuan = Pengajuan::with('mahasiswa', 'jadwalPendaftaran', 'tahunAkademik', 'proposal', 'persetujuan')->where('mahasiswa_id', $user->mahasiswa->id)->latest();
        }

        return view('dashboard', [
            'jadwal_pendaftaran' => JadwalPendaftaran::with('tahunAkademik')->orderBy('tgl_pembukaan', 'desc')->limit(5)->get(),
            'pengajuan' => $pengajuan->limit(10)->get(),
        ]);
    }
}
