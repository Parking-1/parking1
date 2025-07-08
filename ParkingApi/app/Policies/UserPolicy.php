<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // Solo administradores pueden listar todos los usuarios
        return $user->hasRole(User::ADMINISTRADOR_ROL);
    }

    public function view(User $user, User $model)
    {
        // Un usuario puede verse a sí mismo o un admin puede ver a cualquiera
        return $user->id === $model->id || $user->hasRole(User::ADMINISTRADOR_ROL);
    }

    public function create(User $user)
    {
        // Solo admin puede crear usuarios
        return $user->hasRole(User::ADMINISTRADOR_ROL);
    }

    public function update(User $user, User $model)
    {
        // Un usuario puede editarse a sí mismo o un admin puede editar a cualquiera
        return $user->id === $model->id || $user->hasRole(User::ADMINISTRADOR_ROL);
    }

    public function delete(User $user, User $model)
    {
        // Solo un admin puede eliminar usuarios, y no a sí mismo
        return $user->hasRole(User::ADMINISTRADOR_ROL) && $user->id !== $model->id;
    }

    public function restore(User $user, User $model)
    {
        // Solo admin puede restaurar usuarios
        return $user->hasRole(User::ADMINISTRADOR_ROL);
    }

    public function forceDelete(User $user, User $model)
    {
        // Solo admin puede eliminar permanentemente, y no a sí mismo
        return $user->hasRole(User::ADMINISTRADOR_ROL) && $user->id !== $model->id;
    }
}

