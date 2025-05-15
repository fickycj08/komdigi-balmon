<?php

namespace App\Filament\Resources\PengukuranResource\Pages;

use App\Filament\Resources\PengukuranResource;
use App\Models\data_isr;
use App\Models\Pengukuran;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePengukuran extends CreateRecord
{
    protected static string $resource = PengukuranResource::class;

   
}
