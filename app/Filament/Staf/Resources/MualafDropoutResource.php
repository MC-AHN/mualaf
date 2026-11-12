<?php

namespace App\Filament\Staf\Resources;

use App\Filament\Staf\Resources\MualafDropoutResource\Pages;
use App\Models\MualafDropout;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MualafDropoutResource extends Resource
{
    protected static ?string $model = MualafDropout::class;

    // Matikan auto-scoping bawaan Filament
    protected static bool $isScopedToTenant = false;

    protected static ?string $navigationLabel = 'Riwayat Dropout';
    protected static ?string $modelLabel = 'Riwayat Dropout';
    protected static ?string $pluralModelLabel = 'Daftar Riwayat Dropout';
    protected static ?string $navigationIcon = 'heroicon-o-user-minus';
    protected static ?int $navigationSort = 3;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->role, ['superadmin', 'admin', 'staf']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nik_paspor')->label('NIK / No. Paspor'),
                Forms\Components\TextInput::make('nama_lengkap')->label('Nama Lengkap'),
                Forms\Components\Textarea::make('alasan_dropout')->label('Alasan / Catatan Dropout')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik_paspor')
                    ->label('NIK / No. Paspor')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable(),

                // Tampilkan kolom Cabang jika sedang membuka panel Pusat
                Tables\Columns\TextColumn::make('tenant.name')
                    ->label('Kemenag Daerah')
                    ->badge()
                    ->color('gray')
                    ->visible(fn () => Filament::getTenant()?->slug === 'pusat' || is_null(auth()->user()?->tenant_id)),

                Tables\Columns\TextColumn::make('alasan_dropout')
                    ->label('Alasan Dropout')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->alasan_dropout),

                Tables\Columns\TextColumn::make('dropped_at')
                    ->label('Tanggal Dropout')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('dropped_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMualafDropouts::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();
        $currentTenant = Filament::getTenant();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        // Jika Superadmin atau sedang mengakses tenant Pusat -> Tampilkan Semua (Nasional)
        if ($user->role === 'superadmin' || $currentTenant?->slug === 'pusat' || is_null($user->tenant_id)) {
            return $query;
        }

        // Jika Admin Cabang atau Staf Cabang -> Filter sesuai tenant cabang aktif
        return $query->where('tenant_id', $currentTenant?->id ?? $user->tenant_id);
    }
}