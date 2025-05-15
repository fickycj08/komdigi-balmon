<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengukuranStudio extends Model
{
    use HasFactory;

    protected $table = 'pengukuran_studio';

    protected $fillable = [
        'jenis_stl',
        'no_spt',
        'tgl_spt',
        'jenis_sbk',
        'kecamatan',
        'jalan',
        'merk_alat_ukur',
        'tipe_alat_ukur',
    ];

    protected $casts = [
        'tgl_spt' => 'date',
    ];
}
