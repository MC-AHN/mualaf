<?php

namespace App\Filament\Pusat\Resources\PusatApprovalResource\Pages;

use App\Filament\Pusat\Resources\PusatApprovalResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPusatApprovals extends ListRecords
{
    protected static string $resource = PusatApprovalResource::class;

    public function getTabs(): array
    {
        return [
            'semua' => Tab::make('Semua Pengajuan'),
            'lulus' => Tab::make('Pengajuan Lulus')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending_approval_lulus')),
            'dropout' => Tab::make('Pengajuan Dropout')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending_approval_dropout')),
        ];
    }
}