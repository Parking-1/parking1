<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Rol extends Model
{
    use HasFactory;
    // app/Models/Rol.php
    protected $table = 'roles'; // Nombre real en la base de datos

    protected $hidden = ["created_at", "updated_at"];

    public function users(): BelongsToMany {
    return $this->belongsToMany(User::class, "user_rol", "id_rol", "id_user");
}

}
