<?php

namespace App\Policies;

use App\Models\BimbinganProgress;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BimbinganProgressPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['dai', 'staf', 'superadmin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BimbinganProgress $bimbinganProgress): bool
    {
        return in_array($user->role, ['dai', 'staf', 'superadmin']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'dai';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BimbinganProgress $progress): bool
    {
        if ($user->role !== 'dai' || $progress->created_by !== $user->id) {
            return false;
        }

        $mualaf = $progress->mualaf;

        if ($mualaf && !empty($mualaf->rekomendasi_dai) && $mualaf->rekomendasi_dai !== 'none') {
            return false;
        }

        return $mualaf && $mualaf->status === 'proses_bimbingan';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BimbinganProgress $progress): bool
    {
        if ($user->role !== 'dai') {
            return false;
        }

        return $progress->mualaf && $progress->mualaf->dai_id === $user->id && $progress->mualaf->status === 'proses_bimbingan';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BimbinganProgress $bimbinganProgress): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BimbinganProgress $bimbinganProgress): bool
    {
        return false;
    }
}
