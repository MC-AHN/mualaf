<?php

namespace App\Filament\Resources\MualafResource\Pages;

use App\Filament\Resources\MualafResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMualafs extends ListRecords
{
    protected static string $resource = MualafResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
