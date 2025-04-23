<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wedding;
use Illuminate\Auth\Access\HandlesAuthorization;

class WeddingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any weddings.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view their weddings
    }

    /**
     * Determine whether the user can view the wedding.
     */
    public function view(User $user, Wedding $wedding): bool
    {
        return $user->id === $wedding->user_id;
    }

    /**
     * Determine whether the user can create weddings.
     */
    public function create(User $user): bool
    {
        return true; // All authenticated users can create weddings
    }

    /**
     * Determine whether the user can update the wedding.
     */
    public function update(User $user, Wedding $wedding): bool
    {
        return $user->id === $wedding->user_id;
    }

    /**
     * Determine whether the user can delete the wedding.
     */
    public function delete(User $user, Wedding $wedding): bool
    {
        return $user->id === $wedding->user_id;
    }

    /**
     * Determine whether the user can restore the wedding.
     */
    public function restore(User $user, Wedding $wedding): bool
    {
        return $user->id === $wedding->user_id;
    }

    /**
     * Determine whether the user can permanently delete the wedding.
     */
    public function forceDelete(User $user, Wedding $wedding): bool
    {
        return $user->id === $wedding->user_id;
    }

    public function createVendor(User $user, Wedding $wedding)
    {
        return $user->id === $wedding->user_id; // or any other relevant logic
    }
}
