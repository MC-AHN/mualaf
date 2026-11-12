<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BimbinganProgress extends Model
{
    protected $table = 'bimbingan_progress';
    protected $guarded = [];

    protected $casts = [
        'materi_selesai' => 'array',
        'tanggal_bimbingan' => 'date',
    ];

    public static function canEdit($record): bool
    {
        return $record->mualaf->status !== 'lulus';
    }

    public function mualaf(): BelongsTo
    {
        return $this->belongsTo(Mualaf::class);
    }

    public function tenant(): HasOneThrough
    {
        return $this->hasOneThrough(
            Tenant::class,
            Mualaf::class,
            'id',
            'id',
            'mualaf_id',
            'tenant_id',
        );
    }
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
