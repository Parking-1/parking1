<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Vehiculo;

class Cliente extends Model
{
    use HasFactory;
    protected $table = "cliente";
    protected $fillable = ["nombre", "apellido", "cedula", "telefono"];
    protected $hidden = ["created_at", "updated_at"];
    public function vehiculo() : HasMany{
        return $this->hasMany(Vehiculo::class, "id_cliente");
    }
}
