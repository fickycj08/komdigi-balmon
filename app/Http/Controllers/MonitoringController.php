<?php

namespace App\Http\Controllers;
use App\Models\Monitoring;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
 public function index()
    {
        $monitorings = Monitoring::all();
        $locations = $monitorings->pluck('kab_kota')->unique();

        $monitoring = Monitoring::all(); // atau pakai paginate() kalau perlu
    return view('monitoring.index', compact('monitoring'));
    }
}
