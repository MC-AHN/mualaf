<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mualaf extends Model
{
    use SoftDeletes;

    protected $table = 'mualaf';
    protected $guarded = [];

    protected static function booted():void
    {
        static::creating(function ($model) {
            $model->created_by = auth()->id();
            $model->updated_by = auth()->id();
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function bimbinganProgresses(): HasMany
    {
        return $this->hasMany(BimbinganProgress::class);
    }

    public function dropouts()
    {
        return $this->hasMany(MualafDropout::class, 'nik_paspor', 'nik_paspor');
    }

    public function daiHistories()
    {
        return $this->hasMany(MualafDaiHistory::class)->latest('transferred_at');
    }
}
