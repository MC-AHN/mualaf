<?php

namespace App\Filament\Resources\MualafResource\Pages;

use App\Filament\Resources\MualafResource;
use App\Models\MualafDropout;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMualaf extends CreateRecord
{
    protected static string $resource = MualafResource::class;

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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $hasHistory = MualafDropout::where('nik_paspor', $data['nik_paspor'])->exists();

        if ($hasHistory) {
            $data['status'] = 'pending_approval_pendaftaran';
        } else {
            $data['status'] = !empty($data['dai_id']) ? 'proses_bimbingan' : 'terdaftar';
        }

        return $data;
    }
}
