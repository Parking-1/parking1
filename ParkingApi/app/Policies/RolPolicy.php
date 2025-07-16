<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Rol;
use App\Models\User;

class RolPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Rol $rol)
    {
        return $user->isGranted(User::ADMIN_ROL);
    }

    public function create(User $user)
    {
        return $user->isGranted(User::ADMIN_ROL);
    }

    public function update(User $user, Rol $rol)
    {
        return $user->isGranted(User::ADMIN_ROL);
    }

    public function delete(User $user, Rol $rol)
    {
        return $user->isGranted(User::ADMIN_ROL);
    }

    public function restore(User $user, Rol $rol)
    {
        return $user->isGranted(User::ADMIN_ROL);
    }

    public function forceDelete(User $user, Rol $rol)
    {
        return $user->isGranted(User::ADMIN_ROL);
    }
}



