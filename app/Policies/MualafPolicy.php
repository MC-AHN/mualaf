<?php

namespace App\Policies;

use App\Models\Mualaf;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MualafPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Mualaf $mualaf): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin' && !is_null($user->tenant_id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Mualaf $mualaf): bool
    {
        if ($user->role !== 'admin' && $user->tenant_id !== $mualaf->tenant_id) {
            return false;
        }

        return in_array($mualaf->status, ['terdaftar', 'proses_bimbingan']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Mualaf $mualaf): bool
    {
        if ($user->role !== 'admin') {
            return false;
        }

        $isHotData = $mualaf->created_at && $mualaf->created_at->diffInDays(now()) <= 7;
        $isTerdaftar = $mualaf->status === 'terdaftar';

        return $isHotData && $isTerdaftar;
    }
}
