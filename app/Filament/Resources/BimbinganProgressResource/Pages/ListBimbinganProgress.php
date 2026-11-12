<?php

namespace App\Filament\Resources\BimbinganProgressResource\Pages;

use App\Filament\Resources\BimbinganProgressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBimbinganProgress extends ListRecords
{
    protected static string $resource = BimbinganProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
