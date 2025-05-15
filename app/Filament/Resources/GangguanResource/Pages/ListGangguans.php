<?php

namespace App\Filament\Resources\GangguanResource\Pages;

use App\Filament\Resources\GangguanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGangguans extends ListRecords
{
    protected static string $resource = GangguanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
