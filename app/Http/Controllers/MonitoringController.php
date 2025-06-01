<?php

namespace App\Http\Controllers;
use App\Models\Monitoring;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
 public function index()
{
    // Ambil semua monitoring SEKALIGUS relasi location-nya
    $monitoring = Monitoring::with('location')->get();

    // (Optional) Kalau masih mau pakai $locations untuk filter dropdown, bisa diambil dari relasi:
    // $locations = $monitoring->pluck('location.kota')->unique();

    return view('monitoring.index', compact('monitoring'));
}

}
