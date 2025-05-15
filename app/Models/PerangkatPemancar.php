<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerangkatPemancar extends Model
{
    use HasFactory;

    protected $table = 'perangkat_pemancar';

    protected $fillable = [
        'merk',
        'jenis_type',
        'nomor_seri',
        'negara_pembuat',
        'tahun_pembuat',
        'frekuensi_mhz',
        'kelas_emisi',
        'bandwidth_khz',
        'kedalaman_modulasi_percent',
        'max_power_dbm',
        'jenis_antena',
        'polarisasi',
        'jumlah_elemen_bay',
        'gain_db',
        'beam_arah',
        'jenis_kabel_feeder',
        'tipe_kabel',
        'panjang_kabel_m',
    ];

    protected $casts = [
        'tahun_pembuat' => 'integer',
        'frekuensi_mhz' => 'float',
        'bandwidth_khz' => 'float',
        'kedalaman_modulasi_percent' => 'integer',
        'max_power_dbm' => 'float',
        'gain_db' => 'float',
        'panjang_kabel_m' => 'float',
        'tahun_pembuat' => 'integer',
        'jumlah_elemen_bay' => 'integer',
    ];
}
