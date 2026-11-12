<?php

namespace App\Filament\Pusat\Resources\UserResource\Pages;

use App\Filament\Pusat\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // 1. Tambahkan Tombol Close (X / Batal) di Kanan Atas Header
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('cancel')
                ->label('Tutup')
                ->icon('heroicon-o-x-mark')
                ->color('gray')
                ->url($this->getResource()::getUrl('index')),
        ];
    }


    // 2. Tambahkan Tombol Cancel di Bawah Samping Tombol "Save Changes"
    protected function getFormActions(): array
    {
        return [
            ...parent::getFormActions(),
            Actions\Action::make('close')
                ->label('Batal / Tutup')
                ->color('gray')
                ->url($this->getResource()::getUrl('index')),
        ];
    }
}
