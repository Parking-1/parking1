<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TipoVehiculo;
use App\Models\Transaccion;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarifa extends Model
{
    use HasFactory;
    protected $table = "tarifa";
    protected $fillable = ["id_tipo_vehiculo", "tipo_tarifa", "precio_base"];
    protected $hidden = ["created_at", "updated_at"];

    public function tipoVehiculo() : BelongsTo {
        return $this->belongsTo(TipoVehiculo::class, "id_tipo_vehiculo");
    }

    public function transaccion() : HasMany {
        return $this->hasMany(Transaccion::class, "id_tarifa");
    }
}
