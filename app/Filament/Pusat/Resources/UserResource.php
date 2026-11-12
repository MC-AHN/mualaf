<?php

namespace App\Filament\Pusat\Resources;

use App\Filament\Pusat\Resources\UserResource\Pages;
use App\Models\User;
use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Kelola Pengguna';
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?string $pluralModelLabel = 'Data Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required(),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(User::class, 'email', ignoreRecord: true),

                        Forms\Components\Select::make('role')
                            ->label('Role Akses')
                            ->options([
                                'superadmin' => 'Super Admin (Pusat)',
                                'admin' => 'Admin Cabang',
                                'dai' => 'Da\'i Pembimbing',
                                'staf' => 'Staf Auditor / Viewer',
                            ])
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state === 'superadmin') {
                                    $set('tenant_id', null);
                                }
                            }),

                        Forms\Components\Select::make('tenant_id')
                            ->label('Penempatan Kemenag Daerah')
                            ->options(Tenant::pluck('name', 'id'))
                            ->searchable()
                            ->nullable()
                            ->dehydrated(true)
                            ->hidden(fn($get) => $get('role') === 'superadmin')
                            ->required(fn($get) => $get('role') !== 'superadmin')
                            ->helperText('Pilih instansi daerah untuk Admin Cabang & Da\'i.'),

                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'superadmin' => 'danger',
                        'admin' => 'warning',
                        'dai' => 'success',
                        'staf' => 'info',
                        default => 'secondary',
                    }),

                Tables\Columns\TextColumn::make('tenant.name')
                    ->label('Kemenag Daerah')
                    ->placeholder('Pusat / Nasional'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('toggleActive')
                    ->label(fn(User $record): string => $record->is_active ? 'Non-aktifkan' : 'Aktifkan')
                    ->icon(fn(User $record): string => $record->is_active ? 'heroicon-o-x-mark' : 'heroicon-o-check')
                    ->color(fn(User $record): string => $record->is_active ? 'warning' : 'success')
                    ->requiresConfirmation()
                    ->modalHeading(fn(User $record): string => $record->is_active ? 'Non-aktifkan Akun' : 'Aktifkan Akun')
                    ->modalDescription(fn(User $record): string => $record->is_active
                        ? "Apakah Anda yakin ingin menonaktifkan akun {$record->name}? Akun ini tidak akan bisa login lagi."
                        : "Apakah Anda yakin ingin mengaktifkan kembali akun {$record->name}?")
                    ->visible(fn(User $record): bool => in_array($record->role, ['dai', 'staf']))
                    ->action(function (User $record) {
                        $record->update(['is_active' => !$record->is_active]);

                        Notification::make()
                            ->title($record->is_active ? 'Akun berhasil diaktifkan' : 'Akun berhasil dinonaktifkan')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\DeleteAction::make()
                    ->visible(function (User $record): bool {
                        if (!in_array($record->role, ['dai', 'staf'])) {
                            return false;
                        }

                        $hasRelatedMualaf = \App\Models\Mualaf::where('dai_id', $record->id)->exists();

                        return !$hasRelatedMualaf;

                    })
                    ->tooltip('Pengguna ini tidak dapat dihapus karena memiliki riwayat data mualaf, Guanakan fitur Non-Aktifkan.'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}