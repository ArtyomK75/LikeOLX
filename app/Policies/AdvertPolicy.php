<?php

namespace App\Policies;

use App\Models\Advert;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdvertPolicy
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
    public function view(User $user, Advert $advert): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Advert $advert): bool
    {
        return $user->id === $advert->user_id || $user->role->name === 'moderator';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Advert $advert): bool
    {
        return $user->id === $advert->user_id
            || $user->role->name === 'admin'
            || $user->role->name === 'moderator';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Advert $advert): bool
    {
        return $user->id === $advert->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Advert $advert): bool
    {
        return $user->role->name === 'admin'
            || $user->role->name === 'moderator';
    }
}
