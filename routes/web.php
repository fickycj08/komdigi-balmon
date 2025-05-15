<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GangguanController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PengukuranController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PenggangguController;

Route::get('/', function () {
    return view('auth.login');  
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/gangguan', [GangguanController::class, 'index'])->name('gangguan.index');

    Route::get('/export-pdf', [ExportController::class, 'exportPDF'])->name('export.pdf');

    Route::get('/gangguan-v2', [GangguanController::class, 'index2'])->middleware(['auth'])->name('gangguan.v2');

    Route::get('/pengukuran', [PengukuranController::class, 'index'])->name('pengukuran.index');

    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');


});

require __DIR__ . '/auth.php';
