<?php

namespace App\Filament\Pusat\Resources\PusatApprovalResource\Pages;

use App\Filament\Pusat\Resources\PusatApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPusatApproval extends EditRecord
{
    protected static string $resource = PusatApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
