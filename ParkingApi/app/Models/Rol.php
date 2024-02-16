<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Rol extends Model
{
    use HasFactory;
    protected $table = "rol";
    protected $hidden = ["created_at", "updated_at"];
    function user() : BelongsToMany{
        return $this->belongsToMany(Rol::class, "user_rol", "id_rol", "id_user");
    }
}
