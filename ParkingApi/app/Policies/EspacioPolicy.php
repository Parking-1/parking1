<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Espacio;
use App\Models\User;

class EspacioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Espacio  $espacio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Espacio $espacio)
    {
        return $user->isGranted(USER::EMPLEADO_ROL || USER::ADMINISTRADOR_ROL, $user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isGranted(USER::EMPLEADO_ROL || USER::ADMINISTRADOR_ROL, $user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Espacio  $espacio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Espacio $espacio)
    {
        return $user->isGranted(USER::EMPLEADO_ROL || USER::ADMINISTRADOR_ROL, $user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Espacio  $espacio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Espacio $espacio)
    {
        return $user->isGranted( USER::ADMINISTRADOR_ROL, $user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Espacio  $espacio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Espacio $espacio)
    {
        return $user->isGranted( USER::ADMINISTRADOR_ROL, $user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Espacio  $espacio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Espacio $espacio)
    {
        return $user->isGranted( USER::ADMINISTRADOR_ROL, $user);
    }
}
