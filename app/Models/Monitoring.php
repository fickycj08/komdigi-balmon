<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    protected $table = 'monitoring';

    protected $fillable = [
        'upt', 'stasiun_monitor', 'tanggal', 'kab_kota', 'alamat',
        'lat', 'lng', 'no_spt',
        'isrmon_jumlah_isr', 'isrmon_target', 'isrmon_termonitor', 'isrmon_capaian',
        'target_pita', 'occ_target_pita', 'occ_capaian',
        'iden_jumlah_termonitor', 'iden_target', 'iden_teridentifikasi', 'iden_capaian',
        'capaian_pk_obs', 'catatan'
    ];
}
