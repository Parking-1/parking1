<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Transaccion;
use App\Models\User;

class TransaccionPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Transaccion $transaccion)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function create(User $user)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function update(User $user, Transaccion $transaccion)
    {
        return $user->isGranted([User::EMPLEADO_ROL, User::ADMINISTRADOR_ROL]);
    }

    public function delete(User $user, Transaccion $transaccion)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function restore(User $user, Transaccion $transaccion)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }

    public function forceDelete(User $user, Transaccion $transaccion)
    {
        return $user->isGranted(User::ADMINISTRADOR_ROL);
    }
}


