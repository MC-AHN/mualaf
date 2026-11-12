<?php

namespace App\Filament\Staf\Widgets;

use App\Models\Mualaf;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MualafOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $tenant = Filament::getTenant();
        $query = Mualaf::query();

        $isPusat = $tenant && $tenant->slug === 'pusat';

        if (!$isPusat && $tenant) {
            $query->where('tenant_id', $tenant->id);
        }

        $totalTerdaftar = (clone $query)->where('status', 'terdaftar')->count();
        $totalProses = (clone $query)->where('status', 'proses_bimbingan')->count();
        $totalLulus = (clone $query)->where('status', 'lulus')->count();
        $totalDropout = (clone $query)->where('status', 'drop_out')->count();

        $labelScope = $isPusat ? 'Nasional' : 'Cabang';

        return [
            Stat::make('Dalam Bimbingan', $totalProses)
                ->description("Mualaf Aktif ({$labelScope})")
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('warning'),

            Stat::make('Total Lulusan', $totalLulus)
                ->description("Telah Meluluskan ({$labelScope})")
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Total Dropout', $totalDropout)
                ->description("Berhenti / Non-Aktif ({$labelScope}")
                ->descriptionIcon('heroicon-m-user-minus')
                ->color('danger'),

            Stat::make('Pendaftar Baru', $totalTerdaftar)
                ->description("Belum penetapan Da'i ({$labelScope})")
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('info'),
        ];
    }
}
