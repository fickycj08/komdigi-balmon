<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiPemancar extends Model
{
    use HasFactory;

    protected $table = 'lokasi_pemancar';

    protected $fillable = [
        'latitude',
        'longitude',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kota_madya',
        'telp_fax',
        'tinggi_lokasi_mdpl',
        'tinggi_gedung_m',
        'tinggi_menara_m',
        'location_id ',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'tinggi_lokasi_mdpl' => 'float',
        'tinggi_gedung_m' => 'float',
        'tinggi_menara_m' => 'float',
    ];
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    
}
