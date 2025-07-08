<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Tarifa;
use App\Models\User;

class TarifaPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Tarifa $tarifa)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function create(User $user)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function update(User $user, Tarifa $tarifa)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function delete(User $user, Tarifa $tarifa)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function restore(User $user, Tarifa $tarifa)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }
}



