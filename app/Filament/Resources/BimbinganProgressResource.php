<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BimbinganProgressResource\Pages;
use App\Filament\Resources\BimbinganProgressResource\RelationManagers;
use App\Models\BimbinganProgress;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Mualaf;
use App\Services\MateriBimbingan;
use Filament\Notifications\Notification;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;

class BimbinganProgressResource extends Resource
{
    protected static ?string $model = BimbinganProgress::class;

    protected static ?string $tenantOwnershipRelationshipName = 'tenant';
    protected static ?string $tenantRelationshipName = 'bimbinganProgresses';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Jurnal Bimbingan';
    protected static ?string $modelLabel = 'Jurnal Bimbingan';
    protected static ?string $puralModelLabel = 'Jurnal Bimbingan Mualaf';

    public static function canViewAny(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['dai', 'staf']);
    }

    public static function form(Form $form): Form
    {
        $isNonDai = auth()->user()?->role !== 'dai';

        return $form
            ->disabled($isNonDai)
            ->schema([
                Section::make('Informasi Peserta & Sesi')
                    ->schema([
                        Select::make('mualaf_id')
                            ->label('Nama Mualaf')
                            ->options(function () {
                                $user = auth()->user();
                                $query = Mualaf::where('status', '!=', 'lulus');

                                if ($user->role === 'dai') {
                                    $query->where('dai_id', $user->id);
                                }

                                return $query->pluck('nama_lengkap', 'id');
                            })
                            ->searchable()
                            ->required(),

                        DatePicker::make('tanggal_bimbingan')
                            ->label('Tanggal Sesi')
                            ->default(now())
                            ->required(),
                    ])->columns(2),

                Section::make('Checklist Kelengkapan Materi (Kurikulum)')
                    ->description('Centang materi yang telah dikuasai/dituntaskan oleh mualaf.')
                    ->schema([
                        CheckboxList::make('materi_selesai')
                            ->label('Daftar Materi Kurikulum')
                            ->options(MateriBimbingan::list())
                            ->columns(2)
                            ->bulkToggleable(), // Menambahkan fitur Centang Semua / Hapus Semua
                    ]),

                Section::make('Catatan Pertemuan Hari Ini')
                    ->schema([
                        Textarea::make('catatan')
                            ->label('Jurnal / Progress Harian')
                            ->placeholder('Contoh: Sesi hari ini fokus latihan wudhu & hafalan Al-Fatihah ayat 1-4. Catatan: Lafal tajwid sudah membaik.')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_bimbingan')
                    ->label('Tgl Sesi')
                    ->date("d M Y")
                    ->sortable(),

                Tables\Columns\TextColumn::make('mualaf.nama_lengkap')
                    ->label('Nama Mualaf')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Pembimbing')
                    ->placeholder('-')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('materi_selesai')
                    ->label('Total Materi Tuntas')
                    ->badge()
                    ->color('info')
                    ->state(function (BimbinganProgress $record): string {
                        $mualaf = $record->mualaf;
                        if (!$mualaf)
                            return '0 / 0 Materi';

                        $allProgresses = BimbinganProgress::where('mualaf_id', $record->mualaf_id)->get();

                        $completedList = [];
                        foreach ($allProgresses as $progress) {
                            if (\is_array($progress->materi_selesai)) {
                                $completedList = \array_unique(\array_merge($completedList, $progress->materi_selesai));
                            }
                        }

                        $totalMaster = count(MateriBimbingan::list());
                        $countCompleted = count($completedList);

                        return "{$countCompleted} / {$totalMaster} Materi";
                    }),

                Tables\Columns\TextColumn::make('catatan')
                    ->label('Catatan')
                    ->limit(30),
            ])
            ->filters([])
            ->defaultSort('tanggal_bimbingan', 'desc')
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(
                        fn(BimbinganProgress $record): bool =>
                            auth()->user()->role === 'dai' &&
                            (empty($record->mualaf->rekomendasi_dai) || $record->mualaf->rekomendasi_dai === 'none') &&
                            $record->mualaf->status === 'proses_bimbingan'
                    ),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBimbinganProgress::route('/'),
            'create' => Pages\CreateBimbinganProgress::route('/create'),
            'edit' => Pages\EditBimbinganProgress::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (!$user) {
            return $query->whereRaw('1 = 0');
        }

        // Superadmin & Staf Pusat: Semua data
        if ($user->role === 'superadmin' || ($user->role === 'staf' && is_null($user->tenant_id))) {
            return $query;
        }

        // DA'I: Tampilkan jurnal dari mualaf yang diasuh oleh Da'i ini (dai_id) ATAU yang dibuat oleh Da'i ini
        if ($user->role === 'dai') {
            return $query->where(function (Builder $q) use ($user) {
                $q->where('created_by', $user->id)
                    ->orWhereHas('mualaf', function (Builder $mq) use ($user) {
                        $mq->where('dai_id', $user->id);
                    });
            });
        }

        // Staf Cabang: Lihat jurnal se-cabang
        if ($user->role === 'staf' && !is_null($user->tenant_id)) {
            return $query->whereHas('mualaf', function (Builder $q) use ($user) {
                $q->where('tenant_id', $user->tenant_id);
            });
        }

        return $query->whereRaw('1 = 0');
    }

    // Di app/Models/BimbinganProgress.php

}
