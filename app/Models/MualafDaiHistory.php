<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MualafDaiHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'mualaf_id',
        'old_dai_id',
        'new_dai_id',
        'transferred_by',c
        'rason',
        'transferred_at',
    ];

    public function mualaf()
    {
        return $this->belongsTo(Mualaf::class);
    }

    public function oldDai()
    {
        return $this->belongsTo(User::class, 'old_dai_id');
    }

    public function newDai()
    {
        return $this->belongsTo(User::class, 'new_dai_id');
    }

    public function transferredBy()
    {
        return $this->belongsTo(User::class, 'transferred_by');
    }
}
