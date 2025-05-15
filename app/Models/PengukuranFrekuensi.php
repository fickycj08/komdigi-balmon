<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengukuranFrekuensi extends Model
{
    use HasFactory;

    protected $table = 'pengukuran_frekuensi';

    protected $fillable = [
        'kanal',
        'frekuensi_terukur_mhz',
        'level_dbm',
        'bandwidth_khz',
        'field_strength_dbuvm',
        'deviasi_frekuensi_khz',
        'kedalaman_modulasi_percent',
        'output_power_tx',
        'cable_loss',
        'frekuensi_h1_mhz',
        'level_h1_dbm',
        'frekuensi_h2_mhz',
        'level_h2_dbm',
        'frekuensi_h3_mhz',
        'level_h3_dbm',
        'latitude',
        'longitude',
        'alamat',
        'data_isr_id',
        'stasiun_radio_id',
        'lokasi_pemancar_id',
        'perangkat_pemancar_id',
        'pengukuran_studio_id',
        'status_hasil',
        'kesimpulan',
        'catatan',
        'rekomendasi',
        'nama_petugas',
        'nip_petugas',
        'tanggal_pengukuran',
        'foto_pengukuran',
        'dokumen_pendukung',
    ];

    protected $casts = [
        'kanal' => 'integer',
        'frekuensi_terukur_mhz' => 'float',
        'level_dbm' => 'float',
        'bandwidth_khz' => 'float',
        'field_strength_dbuvm' => 'float',
        'deviasi_frekuensi_khz' => 'float',
        'kedalaman_modulasi_percent' => 'integer',
        'output_power_tx' => 'float',
        'cable_loss' => 'float',
        'frekuensi_h1_mhz' => 'float',
        'level_h1_dbm' => 'float',
        'frekuensi_h2_mhz' => 'float',
        'level_h2_dbm' => 'float',
        'frekuensi_h3_mhz' => 'float',
        'level_h3_dbm' => 'float',
        'latitude' => 'float',
        'longitude' => 'float',
        'tanggal_pengukuran' => 'date',
        'foto_pengukuran' => 'array',
        'dokumen_pendukung' => 'array',
    ];

    /**
     * Get the data ISR associated with the pengukuran frekuensi.
     */
    public function data_isr(): BelongsTo
    {
        return $this->belongsTo(data_isr::class);
    }

    /**
     * Get the stasiun radio associated with the pengukuran frekuensi.
     */
    public function stasiun_radio(): BelongsTo
    {
        return $this->belongsTo(StasiunRadio::class);
    }

    /**
     * Get the lokasi pemancar associated with the pengukuran frekuensi.
     */
    public function lokasi_pemancar(): BelongsTo
    {
        return $this->belongsTo(LokasiPemancar::class);
    }

    /**
     * Get the perangkat pemancar associated with the pengukuran frekuensi.
     */
    public function perangkat_pemancar(): BelongsTo
    {
        return $this->belongsTo(PerangkatPemancar::class);
    }

    /**
     * Get the pengukuran studio associated with the pengukuran frekuensi.
     */
    public function pengukuran_studio(): BelongsTo
    {
        return $this->belongsTo(PengukuranStudio::class);
    }
    
}
