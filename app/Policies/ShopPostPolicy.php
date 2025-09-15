<?php

namespace App\Policies;

use App\Models\AclUser;
use App\Models\ShopPost;
use Illuminate\Auth\Access\Response;

class ShopPostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(AclUser $aclUser): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(AclUser $aclUser, ShopPost $shopPost): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(AclUser $aclUser): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(AclUser $aclUser, ShopPost $shopPost): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(AclUser $aclUser, ShopPost $shopPost): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(AclUser $aclUser, ShopPost $shopPost): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(AclUser $aclUser, ShopPost $shopPost): bool
    {
        return false;
    }
}
