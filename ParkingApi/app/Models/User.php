<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'id_cargo', // mantenlo si tu tabla users lo incluye
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relación con roles (muchos a muchos)
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'user_rol', 'id_user', 'id_rol');
    }

    // Verifica si el usuario tiene un rol específico
    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('nombre', $roleName)->exists();
    }

    // JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            // Puedes incluir roles si lo deseas
        ];
    }
}


