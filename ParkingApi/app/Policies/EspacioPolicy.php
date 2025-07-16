<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Espacio;
use App\Models\User;

class EspacioPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Espacio $espacio)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function create(User $user)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function update(User $user, Espacio $espacio)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function delete(User $user, Espacio $espacio)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function restore(User $user, Espacio $espacio)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function forceDelete(User $user, Espacio $espacio)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }
}

