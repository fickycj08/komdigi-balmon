<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengukuran;
use App\Models\LokasiPemancar;
use App\Models\Location; // 

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

        // Ambil nama kota unik, diurutkan alfabet
    $kotaList = Location::select('kota')
        ->distinct()
        ->orderBy('kota')
        ->pluck('kota');  // koleksi string

    // ambil data pengukuran seperti biasa
    $pengukurans = Pengukuran::with('lokasiPemancar', 'data_isr')
        ->latest()
        ->get();

        $lokasiPemancars = LokasiPemancar::all();

         $locations = \App\Models\Location::orderBy('kota')->get();

        return view('pengukuran.index', compact('pengukurans', 'lokasiPemancars', 'locations'));
    }
}
