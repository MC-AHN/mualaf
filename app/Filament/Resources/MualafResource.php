<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MualafResource\Pages;
use App\Filament\Resources\MualafResource\RelationManagers;
use App\Models\BimbinganProgress;
use App\Services\MateriBimbingan;
use App\Models\User;
use App\Models\Mualaf;
use App\Models\MualafDropout;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Filament\Facades\Filament;
use App\Models\MualafDaiHistory;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\ActionGroup;

class MualafResource extends Resource
{
    protected static ?string $model = Mualaf::class;

    protected static ?string $tenantRelationshipName = 'mualaf';

    // Mengubah tulisan di sidebar navigasi
    protected static ?string $navigationLabel = 'Pendataan Mualaf';
    // mengubah label judul tunggal & jamak di UI
    protected static ?string $modelLabel = 'Mualaf';
    protected static ?string $pluralModelLabel = 'Data Mualaf';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $isNonAdmin = auth()->user()?->role !== 'admin';

        return $form
            ->disabled($isNonAdmin)
            ->schema([
                Forms\Components\Section::make('Identitas Mualaf')
                    ->schema([
                        Forms\Components\TextInput::make('nomor_registrasi')
                            ->required()
                            ->default(fn() => 'MLF-' . date('Ymd') . '-' . rand(100, 999))
                            ->label('No. Registrasi'),

                        Forms\Components\TextInput::make('nik_paspor')
                            ->required()
                            ->label('NIK / No. Paspor')
                            ->live(onBlur: true)
                            ->unique(
                                table: 'mualaf',
                                column: 'nik_paspor',
                                ignoreRecord: true,
                                modifyRuleUsing: function (\Illuminate\Validation\Rules\Unique $rule) {
                                    return $rule->where('tenant_id', Filament::getTenant()->id);
                                }
                            )
                            ->validationMessages([
                                'unique' => 'NIK / Nomor Paspor ini sudah terdaftar. Silahkan periksa kembali data input.'
                            ])
                            ->afterStateUpdated(function ($state, callable $set) {
                                if (!$state) {
                                    $set('is_has_dropout_history', false);
                                    $set('dropout_count', 0);
                                    return;
                                }

                                $historyCount = MualafDropout::where('nik_paspor', $state)->count();

                                if ($historyCount > 0) {
                                    $set('is_has_dropout_history', true);
                                    $set('dropout_count', $historyCount);
                                } else {
                                    $set('is_has_dropout_history', false);
                                    $set('dropout_count', 0);
                                }
                            }),

                        Placeholder::make('warning_dropout')
                            ->label('')
                            ->content(function ($get) {
                                $count = $get('dropout_count');
                                return new HtmlString("
                                    <div class='p-3 bg-warning-500/10 border border-warning-500/20 text-warning-400 rounded-lg text-sm'>
                                        <strong>⚠️ Perhatian:</strong> NIK ini tercatat memiliki <strong>{$count} kali riwayat Dropout</strong>.
                                        Pendaftaran ini memerlukan <strong>Persetujuan Super Admin (Pusat)</strong> sebelum bimbingan dimulai.
                                    </div>
                                ");
                            })
                            ->visible(fn($get) => (bool) $get('is_has_dropout_history'))
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('nama_lengkap')
                            ->required()
                            ->label('Nama Lengkap'),

                        Forms\Components\TextInput::make('nama_hijrah')
                            ->label('Nama Hijrah'),

                        Forms\Components\TextInput::make('tempat_lahir')
                            ->required()
                            ->label('Tempat Lahir'),

                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->required()
                            ->label('Tanggal Lahir'),

                        Forms\Components\Select::make('gender')
                            ->options([
                                'male' => 'Laki-laki',
                                'female' => 'perempuan',
                            ])
                            ->required()
                            ->label('Jenis Kelamin'),

                        Forms\Components\TextInput::make('pekerjaan')
                            ->label('Pekerjaan'),

                        Forms\Components\TextInput::make('telepon')
                            ->tel()
                            ->required()
                            ->label('No. Telepon / WA'),

                        Forms\Components\Textarea::make('alamat_domisili')
                            ->required()
                            ->columnSpanFull()
                            ->label('Alamat Domisili'),

                        Forms\Components\FileUpload::make('file_identitas')
                            ->label('Scan KTP / Paspor')
                            ->directory('mualaf/identitas')
                            ->visibility('public')
                            ->image()
                            ->maxSize(2048)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Informasi Keislaman')
                    ->schema([
                        Forms\Components\TextInput::make('agama_asal')
                            ->required()
                            ->label('Agama Asal'),

                        Forms\Components\DatePicker::make('tanggal_syahadat')
                            ->required()
                            ->default(now())
                            ->label('Tanggal Syahadat'),

                        Forms\Components\Select::make('dai_id')
                            ->label('Penetapan Da\'i / Pembimbing')
                            ->options(
                                fn() => User::where('role', 'dai')
                                    ->where('tenant_id', auth()->user()->tenant_id)
                                    ->where('is_active', true)
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->nullable()
                            ->disabled(fn ($record) => $record && $record->status !== 'terdaftar')
                            ->dehydrated(fn ($state, $record) => !$record || $record->status === 'terdaftar')
                            ->helperText('Jika Da\'i ditetapkan, status mualaf otomatis berubah menjadi "Proses Bimbingan".'),

                        Placeholder::make('status_info')
                            ->label('Status Program (Otomatis)')
                            ->content(
                                fn($record) => $record
                                    ? new HtmlString("<span class='px-3 py-1 text-xs font-semibold rounded-full bg-primary-500/10 text-primary-400'>" . str_replace('_', ' ', strtoupper($record->status)) . "</span>")
                                    : 'Terdaftar (Otomatis setelah disimpen)'
                            ),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_registrasi')->label('No. Registrasi'),
                Tables\Columns\TextColumn::make('nama_lengkap')->label('Nama Lengkap'),
                Tables\Columns\TextColumn::make('tenant.name')->label('Kemenag Daerah'),
                Tables\Columns\TextColumn::make('telepon')->label('No. Telepon / WA'),
                Tables\Columns\TextColumn::make('tanggal_syahadat')->date()->sortable()->label('Tgl Syahadat'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'terdaftar' => 'info',
                        'proses_bimbingan' => 'warning',
                        'pending_approval_lulus', 'pending_approval_dropout', 'pending_approval_pendaftaran' => 'gray',
                        'lulus' => 'success',
                        'drop_out' => 'danger',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('rekomendasi_dai')
                    ->label('Rekomendasi Da\'i')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'lulus' => 'success',
                        'dropout' => 'danger',
                        default => 'secondary',
                    }),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->visible(fn(): bool => auth()->user()->role === 'admin'),

                    // ----------------------------------------------------
                    // ACTION FOR DA'I: BERIKAN REKOMENDASI (LULUS / DROPOUT)
                    // ----------------------------------------------------
                    Tables\Actions\Action::make('berikan_rekomendasi')
                        ->label('Beri Rekomendasi')
                        ->icon('heroicon-o-chat-bubble-bottom-center-text')
                        ->color('primary')
                        ->form(function (Mualaf $record) {
                            $mualafId = $record->id;
                            $allProgresses = BimbinganProgress::where('mualaf_id', $mualafId)->get();

                            $completedList = [];
                            foreach ($allProgresses as $progress) {
                                if (\is_array($progress->materi_selesai)) {
                                    $completedList = \array_unique(\array_merge($completedList, $progress->materi_selesai));
                                }
                            }

                            $totalMaster = count(MateriBimbingan::list());
                            $countCompleted = count($completedList);

                            $isAllCompleted = ($countCompleted == $totalMaster) && $totalMaster > 0;

                            // 2. Susun opsi rekomendasi berdasarkan kelengkapan materi
                            $options = [];
                            if ($isAllCompleted) {
                                $options['lulus'] = "Rekomendasi Lulus ({$countCompleted}/{$totalMaster} Materi Tuntas)";
                            }
                            $options['dropout'] = "Rekomendasi Dropout";

                            return [
                                // Tampilkan info status materi jika belum selesai
                                Forms\Components\Placeholder::make('info_materi')
                                    ->label('Status Kurikulum Mualaf')
                                    ->content(function () use ($countCompleted, $totalMaster, $isAllCompleted) {
                                        if ($isAllCompleted) {
                                            return new \Illuminate\Support\HtmlString("<span class='text-success-600 font-bold'>✓ Seluruh materi ({$countCompleted}/{$totalMaster}) telah tuntas.</span>");
                                        }
                                        return new \Illuminate\Support\HtmlString("<span class='text-danger-500 font-bold'>⚠️ Materi belum tuntas ({$countCompleted}/{$totalMaster}). Mualaf belum dapat direkomendasikan Lulus.</span>");
                                    }),

                                Forms\Components\Select::make('rekomendasi_dai')
                                    ->label('Jenis Rekomendasi')
                                    ->options($options)
                                    ->default($isAllCompleted ? 'lulus' : 'dropout')
                                    ->required(),

                                Forms\Components\Textarea::make('catatan_rekomendasi_dai')
                                    ->label('Catatan Bimbingan / Alasan')
                                    ->required(),
                            ];
                        })
                        ->visible(
                            fn(Mualaf $record): bool =>
                                auth()->user()->role === 'dai' &&
                                (empty($record->rekomendasi_dai) || $record->rekomendasi_dai === 'none') &&
                                $record->status === 'proses_bimbingan'
                        )
                        ->action(function (Mualaf $record, array $data) {
                            $record->update([
                                'rekomendasi_dai' => $data['rekomendasi_dai'],
                                'catatan_rekomendasi_dai' => $data['catatan_rekomendasi_dai'],
                                'rekomendasi_dai_at' => now(),
                            ]);

                            Notification::make()
                                ->title('Rekomendasi Berhasil Dikirim')
                                ->body('Status mualaf otomatis berubah menjadi pendding approval untuk ditinjau admin cabang & pusat.')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\Action::make('batalkan_rekomendasi')
                        ->label('Batalkan Rekomendasi')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->visible(
                            fn(Mualaf $record): bool =>
                                auth()->user()->role === 'dai' &&
                                !empty($record->rekomendasi_dai) &&
                                $record->rekomendasi_dai !== 'none' &&
                                $record->status === 'proses_bimbingan'
                        )
                        ->requiresConfirmation()
                        ->modalHeading('Batalkan Rekomendasi?')
                        ->modalDescription('Apakah Anda yakin ingin menarik kembali rekomendasi untuk mualaf ini?')
                        ->action(function (Mualaf $record) {
                            $record->update([
                                'rekomendasi_dai' => 'none',
                                'catatan_rekomendasi_dai' => null,
                                'rekomendasi_dai_at' => null,
                            ]);

                            Notification::make()
                                ->title('Rekomendasi Dibatalkan')
                                ->body('Rekomendasi berhasil ditarik kembali.')
                                ->warning()
                                ->send();
                        }),

                    // =========================================================================
// 1. ACTION ADMIN CABANG: SETUJUI REKOMENDASI (LULUS / DROPOUT)
// =========================================================================
                    Tables\Actions\Action::make('setujui_rekomendasi')
                        ->label(
                            fn(Mualaf $record): string =>
                                $record->rekomendasi_dai === 'dropout' ? 'Setujui Dropout' : 'Setujui Kelulusan'
                        )
                        ->icon(
                            fn(Mualaf $record): string =>
                                $record->rekomendasi_dai === 'dropout' ? 'heroicon-o-user-minus' : 'heroicon-o-check-badge'
                        )
                        ->color(
                            fn(Mualaf $record): string =>
                                $record->rekomendasi_dai === 'dropout' ? 'danger' : 'success'
                        )
                        ->visible(
                            fn(Mualaf $record): bool =>
                                auth()->user()->role === 'admin' &&
                                !empty($record->rekomendasi_dai) &&
                                $record->rekomendasi_dai !== 'none' &&
                                $record->status === 'proses_bimbingan'
                        )
                        ->requiresConfirmation()
                        ->modalHeading(
                            fn(Mualaf $record): string =>
                                $record->rekomendasi_dai === 'dropout' ? 'Konfirmasi Setujui Dropout' : 'Konfirmasi Setujui Kelulusan'
                        )
                        ->modalDescription(
                            fn(Mualaf $record): string =>
                                $record->rekomendasi_dai === 'dropout'
                                ? 'Apakah Anda yakin ingin menyetujui rekomendasi Dropout untuk mualaf ini?'
                                : 'Apakah Anda yakin ingin menyetujui kelulusan dan menerbitkan status lulus mualaf ini?'
                        )
                        ->action(function (Mualaf $record) {
                            // Tentukan status akhir sesuai enum di database ('lulus' atau 'drop_out')
                            $statusAkhir = ($record->rekomendasi_dai === 'dropout') ? 'drop_out' : 'lulus';

                            $record->update([
                                'status' => $statusAkhir,
                            ]);

                            $labelNotif = ($statusAkhir === 'drop_out') ? 'Dropout' : 'Kelulusan';

                            Notification::make()
                                ->title("Status {$labelNotif} Disetujui")
                                ->body("Data mualaf telah resmi berstatus {$statusAkhir}.")
                                ->success()
                                ->send();
                        }),

                    // =========================================================================
// 2. ACTION ADMIN CABANG: BATALKAN PERSETUJUAN (KEMBALI KE PROSES BIMBINGAN)
// =========================================================================
                    Tables\Actions\Action::make('batalkan_persetujuan_admin')
                        ->label(
                            fn(Mualaf $record): string =>
                                $record->rekomendasi_dai === 'dropout' ? 'Batalkan Dropout' : 'Batalkan Kelulusan'
                        )->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->visible(
                            fn(Mualaf $record): bool =>
                                auth()->user()->role === 'admin' &&
                                in_array($record->status, ['lulus', 'drop_out'])
                        )
                        ->requiresConfirmation()
                        ->modalHeading('Batalkan Keputusan?')
                        ->modalDescription('Keputusan status akan dibatalkan dan mualaf dikembalikan ke status proses bimbingan.')
                        ->action(function (Mualaf $record) {
                            $record->update([
                                'status' => 'proses_bimbingan',
                            ]);

                            Notification::make()
                                ->title('Keputusan Dibatalkan')
                                ->body('Status mualaf dikembalikan ke Proses Bimbingan.')
                                ->warning()
                                ->send();
                        }),

                    Tables\Actions\Action::make('cetak_sertifikat')
                        ->label('Cetak Sertifikat')
                        ->icon('heroicon-o-printer')
                        ->color('info')
                        ->openUrlInNewTab()
                        ->url(fn(Mualaf $record): string => route('mualaf.cetak-sertifikat', $record))
                        ->visible(
                            fn(Mualaf $record): bool =>
                                auth()->user()->role === 'admin' &&
                                ($record->status === 'lulus')
                        ),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('reassignDai')
                        ->label('Alihkan ke Da\'i Lain (Darurat)')
                        ->icon('heroicon-o-arrows-right-left')
                        ->color('warning')
                        ->form([
                            Forms\Components\Select::make('new_dai_id')
                                ->label('Pilih Da\'i Pengganti')
                                ->options(function () {
                                    return User::query()
                                        ->where('tenant_id', Filament::getTenant()?->id)
                                        ->where('role', 'dai')
                                        ->where('is_active', true)
                                        ->pluck('name', 'id');
                                })
                                ->required(),

                            Forms\Components\Textarea::make('reason')
                                ->label('Alasan Pengalihan (Audit Trail)')
                                ->placeholder('Contoh: Da\'i utama sakit/kecelakaan, bimbingan dialihkan sementara.')
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $currentAdminId = auth()->id();
                            $now = now();

                            $validRecords = $records->filter(fn($mualaf) => $mualaf->status === 'proses_bimbingan');
                            $skippedCount = $records->count() - $validRecords->count();

                            if ($validRecords->isEmpty()) {
                                Notification::make()
                                    ->title('Pengalihan Dibatalkan')
                                    ->body('Tidak ada data mualaf terpilih yang berstatus "Proses Bimbingan". Status terdaftar, lulus, atau dropout tidak dapat dialihkan.')
                                    ->warning()
                                    ->send();
                                return;
                            }

                            $validRecords->each(function ($mualaf) use ($data, $currentAdminId, $now) {
                                $oldDaiId = $mualaf->dai_id;

                                if ($oldDaiId != $data['new_dai_id']) {
                                    MualafDaiHistory::create([
                                        'mualaf_id' => $mualaf->id,
                                        'old_dai_id' => $oldDaiId,
                                        'new_dai_id' => $data['new_dai_id'],
                                        'transferred_by' => $currentAdminId,
                                        'reason' => $data['reason'],
                                        'transferred_at' => $now,
                                    ]);

                                    $mualaf->update([
                                        'dai_id' => $data['new_dai_id'],
                                    ]);
                                }
                            });

                            $msg = 'Data mualaf berhasil dipindahkan dan riwayat pengalihan telah dicatat.';
                            if ($skippedCount > 0) {
                                $msg .= " ({$skippedCount} data diabaikan karena bukan berstatus Proses Bimbingan).";
                            }

                            Notification::make()
                                ->title('Pengalihan Da\'i Berhasil')
                                ->body($msg)
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMualafs::route('/'),
            'create' => Pages\CreateMualaf::route('/create'),
            'edit' => Pages\EditMualaf::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (!$user) {
            return $query->whereRaw('1 = 0');
        }

        if ($user->role === 'superadmin' || ($user->role === 'staf' && is_null($user->tenant_id))) {
            return $query;
        }

        if ($user->role === 'admin' || ($user->role === 'staf' && !is_null($user->tenant_id))) {
            return $query->where('tenant_id', $user->tenant_id);
        }

        if ($user->role === 'dai') {
            return $query->where('tenant_id', $user->tenant_id)
                ->where('dai_id', $user->id);
        }

        return $query->whereRaw('1 = 0');

    }
}
