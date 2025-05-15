<?php

namespace App\Filament\Resources\GangguanResource\Pages;

use App\Filament\Resources\GangguanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGangguan extends EditRecord
{
    protected static string $resource = GangguanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
