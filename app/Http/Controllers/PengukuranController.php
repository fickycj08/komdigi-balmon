<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengukuran;
use App\Models\LokasiPemancar;

class PengukuranController extends Controller
{
    public function index()
    {
        $pengukurans = Pengukuran::with([
            'data_isr',
            'stasiunRadio',
            'lokasiPemancar',
            'perangkatPemancar',
            'pengukuranFrekuensi',
            'pengukuranStudio',
        ])->get();

        $lokasiPemancars = LokasiPemancar::all();

        return view('pengukuran.index', compact('pengukurans', 'lokasiPemancars'));
    }
}
