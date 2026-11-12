<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Tenant extends Model
{
    protected $guarded = [];

    public function mualafDropouts()
    {
        return $this->hasMany(MualafDropout::class);
    }

    public function mualaf(): HasMany
    {
        return $this->hasMany(Mualaf::class);
    }

    public function bimbinganProgresses(): HasManyThrough
    {
        return $this->hasManyThrough(
            BimbinganProgress::class,
            Mualaf::class,
            'tenant_id',
            'mualaf_id',
            'id',
            'id',
        );
    }
}
