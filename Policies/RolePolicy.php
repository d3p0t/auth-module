<?php

namespace Modules\Auth\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Auth\Entities\Role;
use Modules\Auth\Entities\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function update(User $user, Role $role): Response
    {
        if ($role->name === 'Super Admin') {
            return Response::denyWithStatus(403, 'Cannot change `Super Admin` role');
        }

        if ($role->is_internal) {
            return Response::denyWithStatus(403, 'Cannot change internal role');
        }

        return Response::allow();

    }
}
