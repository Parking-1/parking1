<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Cliente;
use App\Models\User;

class ClientePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Cliente $cliente)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function create(User $user)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function update(User $user, Cliente $cliente)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function delete(User $user, Cliente $cliente)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function restore(User $user, Cliente $cliente)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function forceDelete(User $user, Cliente $cliente)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }
}



