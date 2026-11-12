<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements HasTenants
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'tenant_id',
        'is_active',
    ];

    // realasi ke table pivot tenant_user
    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class);
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        if (isset($this->is_active) && !$this->is_active) {
            return false;
        }

        if ($panel->getId() === 'pusat') {
            return in_array($this->role, ['superadmin', 'staf']) && is_null($this->tenant_id);
        }

        if ($panel->getId() === 'admin') {
            return in_array($this->role, ['admin', 'dai', 'staf']) && !is_null($this->tenant_id);
        }

        return false;
    }

    public function getTenants(Panel $panel): array|Collection
    {
        // Mengembalikan tenant tempat user bertugas
        return $this->tenant ? collect([$this->tenant]) : collect([]);
    }

    public function canAccessTenant(Model $tenant): bool
    {
        // Hanya bisa akses tenant yang sesuai dengan tenant_id user
        return (int) $this->tenant_id === (int) $tenant->id;
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
