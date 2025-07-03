<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\KpSkripsi;
use Illuminate\Http\Request;

class KpSkripsiController extends Controller
{
    public function index()
    {
        $listKpSkripsi = KpSkripsi::all();
        return response()->json([
            'message' => 'List data proposal KP & Skripsi Aktif',
            'status' =>  200,
            'data' => $listKpSkripsi->map(function ($kpSkripsi) {
                $proposal = $kpSkripsi->proposal;
                return [
                    'judul' => $proposal->judul,
                    'file_proposal' => route('proposal.stream', $proposal->id),
                    'jenis' => $kpSkripsi->jenis,
                    'nama_jenis' => $kpSkripsi->getJenis(),
                ];
            })
        ]);
    }
}
