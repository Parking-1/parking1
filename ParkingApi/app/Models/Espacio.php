<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Espacio extends Model
{
    use HasFactory;

    protected $table = "espacio";

    protected $fillable = ["descripcion", "estado"]; // Asegúrate de incluir `estado` si lo usas

    protected $hidden = ["created_at", "updated_at"];

    public function transacciones(): HasMany
    {
        return $this->hasMany(Transaccion::class, 'id_espacio');
    }
}

