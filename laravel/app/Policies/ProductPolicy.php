<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     * Admin can view all (via Gate::before)
     * Manager can view products they created
     * Staff cannot view individual products (no assignment model)
     */
    public function view(User $user, Product $product): bool
    {
        // Manager can view products they created
        if ($user->hasRole('manager')) {
            return $product->created_by === $user->id;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     * Only managers can create products
     */
    public function create(User $user): bool
    {
        return $user->hasRole('manager');
    }

    /**
     * Determine whether the user can update the model.
     * Only the creator (manager) can update
     */
    public function update(User $user, Product $product): bool
    {
        return $user->hasRole('manager') && $product->created_by === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     * Only the creator (manager) can delete
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->hasRole('manager') && $product->created_by === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return false;
    }
}
