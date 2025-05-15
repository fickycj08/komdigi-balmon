<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\Gangguan;
use Carbon\Carbon;

class ExportController extends Controller
{
    public function exportPDF()
    {
        $gangguan = Gangguan::with(['location', 'pengganggu'])
            ->orderBy('waktu_kejadian', 'desc')
            ->get();

        $pdf = PDF::loadView('pdf_template', compact('gangguan'))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'helvetica',
                'dpi' => 96,
                'margin_top' => 30,
                'margin_bottom' => 25
            ]);

        return $pdf->download('Laporan_Gangguan_'.Carbon::now()->format('Ymd_His').'.pdf');
    }
}