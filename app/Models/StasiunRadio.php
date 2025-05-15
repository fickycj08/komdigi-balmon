<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StasiunRadio extends Model
{
    use HasFactory;

    protected $table = 'stasiun_radio';

    protected $fillable = [
        'nama_penyelenggara',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kota_madya',
        'telp_fax',
        'email',
    ];
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
