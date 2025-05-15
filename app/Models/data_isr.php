<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_isr extends Model
{
    use HasFactory;

    protected $table = 'data_isr';

    protected $fillable = [
        'no_isr',
        'tanggal',
        'location_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
    public function location()
{
    return $this->belongsTo(Location::class);
}

    
}