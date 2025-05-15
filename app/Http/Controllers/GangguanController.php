<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gangguan;
use App\Models\Location; // Pastikan model Location sudah ada
use App\Models\Pengganggu; 

class GangguanController extends Controller
{
    public function index()
    {
        $gangguan = Gangguan::all(); // Ambil semua data gangguan dari tabel gangguan
        $gangguan = Gangguan::with('location')->get();
        $locations = Location::select('kota')->distinct()->pluck('kota'); // Ambil daftar kota unik dari tabel locations
        $pengganggu = Pengganggu::all(); // Ambil semua data dari tabel pengganggu

        

        
        return view('gangguan.index', compact('gangguan', 'locations', 'pengganggu'));
    }

    // GangguanController.php
public function index2()
{
    return view('gangguan.index2');
}

}
