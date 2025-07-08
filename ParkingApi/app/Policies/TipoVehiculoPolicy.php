<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\TipoVehiculo;
use App\Models\User;

class TipoVehiculoPolicy
{
    use HandlesAuthorization;

    public function view(User $user, TipoVehiculo $tipoVehiculo)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function create(User $user)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function update(User $user, TipoVehiculo $tipoVehiculo)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function delete(User $user, TipoVehiculo $tipoVehiculo)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function restore(User $user, TipoVehiculo $tipoVehiculo)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function forceDelete(User $user, TipoVehiculo $tipoVehiculo)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }
}



