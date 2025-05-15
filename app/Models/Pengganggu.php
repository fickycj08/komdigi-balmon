<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengganggu extends Model
{
    use HasFactory;

    protected $table = 'pengganggu';

    protected $fillable = [
        'gangguan_id',
        'nama',
        'jenis_organisasi',
        'kontak',
        'frekuensi',
        'band_frekuensi',
        'status_pelanggaran',
        'service',
        'sub_service',
        'kecamatan',
        'latitude',
        'longitude',
        'location_id',
        'jalan',
        'alamat_lengkap',
    ];

    public function gangguan()
    {
        return $this->belongsTo(Gangguan::class);
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
