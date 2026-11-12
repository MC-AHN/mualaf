<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Kelola Pengguna Cabang';
    protected static ?string $modelLabel = 'Pengguna Cabang';

    // 1. QUERY LOCK: Hanya tampilkan user di tenant saat ini & sembunyikan superadmin
    public static function getEloquentQuery(): Builder
    {
        $tenant = Filament::getTenant();

        return parent::getEloquentQuery()
            ->where('tenant_id', $tenant?->id)
            ->where('role', '!=', 'superadmin');
    }

    // 2. FORM CREATE & EDIT
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun Cabang')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required(),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(User::class, 'email', ignoreRecord: true),

                        // Restriksi Opsi Role HANYA Da'i dan Staf
                        Forms\Components\Select::make('role')
                            ->label('Role Akses')
                            ->options([
                                'dai' => 'Da\'i Pembimbing',
                                'staf' => 'Staf Auditor / Viewer',
                            ])
                            ->required(),

                        // Tenant ID dikunci otomatis dari konteks Filament Tenant saat ini
                        Forms\Components\Hidden::make('tenant_id')
                            ->default(fn() => Filament::getTenant()?->id)
                            ->dehydrated(true),

                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create'),
                    ])->columns(2),
            ]);
    }

    // 3. TABEL DAFTAR PENGGUNA & RESTRIKSI ACTION EDIT/DELETE
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
                        'admin' => 'warning',
                        'dai' => 'success',
                        'staf' => 'info',
                        default => 'secondary',
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    // Tombol Edit HANYA MUNCUL untuk role 'dai' dan 'staf' (Admin lain hanya bisa READ)
                    Tables\Actions\EditAction::make()
                        ->visible(fn(User $record): bool => in_array($record->role, ['dai', 'staf'])),

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
                ])
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