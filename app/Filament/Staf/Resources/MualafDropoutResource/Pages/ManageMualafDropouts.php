<?php

namespace App\Filament\Staf\Resources\MualafDropoutResource\Pages;

use App\Filament\Staf\Resources\MualafDropoutResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMualafDropouts extends ManageRecords
{
    protected static string $resource = MualafDropoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
