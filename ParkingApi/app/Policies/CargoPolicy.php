<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Cargo;
use App\Models\User;

class CargoPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Cargo $cargo)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function create(User $user)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function update(User $user, Cargo $cargo)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function delete(User $user, Cargo $cargo)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function restore(User $user, Cargo $cargo)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function forceDelete(User $user, Cargo $cargo)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }
}



