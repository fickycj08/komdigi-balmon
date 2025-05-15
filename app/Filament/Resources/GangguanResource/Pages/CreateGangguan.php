<?php

namespace App\Filament\Resources\GangguanResource\Pages;

use App\Filament\Resources\GangguanResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateGangguan extends CreateRecord
{
    protected static string $resource = GangguanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Anda bisa menambahkan header actions jika diperlukan
        ];
    }

    // Override method untuk menghapus tombol "Create & Create Another"
    protected function getCreateFormAction(): Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Create');
    }

    // Menghapus tombol "Create & Create Another"
    protected function getCreateAnotherFormAction(): Actions\Action
    {
        return parent::getCreateAnotherFormAction()
            ->hidden();
    }
}