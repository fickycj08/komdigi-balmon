<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\data_isr;
use App\Models\stasiunRadio;

class Pengukuran extends Model
{
    protected $table = 'pengukuran';

    protected $fillable = [
        'data_isr_id',
        'stasiun_radio_id',
        'lokasi_pemancar_id',
        'perangkat_pemancar_id',
        'pengukuran_frekuensi_id',
        'pengukuran_studio_id',
        'tanggal_pengukuran',
        'catatan',
        

    ];
    public function data_isr()
    {
        return $this->belongsTo(data_isr::class);
    }



    public function stasiunRadio()
    {
        return $this->belongsTo(StasiunRadio::class);
    }

    public function lokasiPemancar()
    {
        return $this->belongsTo(LokasiPemancar::class);
        
    }

    // Di Pengukuran.php
    public function perangkatPemancar()
    {
        return $this->belongsTo(PerangkatPemancar::class);
       
    }



    public function pengukuranFrekuensi()
    {
        return $this->belongsTo(PengukuranFrekuensi::class);
    }

    public function pengukuranStudio()
    {
        return $this->belongsTo(\App\Models\PengukuranStudio::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    
}
