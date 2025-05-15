<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gangguan extends Model
{
    use HasFactory;

    protected $table = 'gangguan';
    protected $fillable = [
        'location_id',
        'user_id',
        'waktu_kejadian',
        'jenis_gangguan',
        'severity',
        'nama_client',
        'frekuensi',
        'band_frekuensi',
        'service',
        'sub_service',
        'sifat_gangguan',
        'uraian_gangguan',
        'latitude',
        'longitude',
        'kecamatan',
        'no_st',       // Pastikan kolom ini ada
        'vic',         // Pastikan kolom ini ada
        'no_laporan',  // Pastikan kolom ini ada
        'file_path',   // Pastikan kolom ini ada
        
    ];
    protected $casts = [
        'waktu_kejadian' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function pengganggu()
    {
        return $this->hasMany(Pengganggu::class);
    }

}
