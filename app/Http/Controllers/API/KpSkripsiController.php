<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\KpSkripsi;
use Illuminate\Http\Request;

class KpSkripsiController extends Controller
{
    public function index()
    {
        $kpSkripsi = KpSkripsi::all();
        return response()->json([
            'message' => 'List data proposal KP & Skripsi Aktif',
            'status' =>  200,
            'data' => $kpSkripsi
        ]);
    }
}
