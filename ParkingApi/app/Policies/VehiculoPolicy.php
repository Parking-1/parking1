<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Vehiculo;
use App\Models\User;

class VehiculoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function view(User $user, Vehiculo $vehiculo = null)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function create(User $user)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function update(User $user, Vehiculo $vehiculo)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function delete(User $user, Vehiculo $vehiculo)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function restore(User $user, Vehiculo $vehiculo)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function forceDelete(User $user, Vehiculo $vehiculo)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }
}


