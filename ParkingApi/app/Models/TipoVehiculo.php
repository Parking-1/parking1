<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\Vehiculo;
use App\Models\Tarifa;

class TipoVehiculo extends Model
{
    use HasFactory;

    protected $table = "tipo_vehiculo";

    protected $hidden = ["created_at", "updated_at"];

    public function vehiculo(): HasMany
    {
        return $this->hasMany(Vehiculo::class, "id_tipo_vehiculo");
    }

    public function tarifa(): HasOne
    {
        return $this->hasOne(Tarifa::class, "id_tipo_vehiculo");
    }
}


