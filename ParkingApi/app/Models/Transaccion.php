<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Vehiculo;
use App\Models\Tarifa;
use App\Models\Espacio;

class Transaccion extends Model
{
    use HasFactory;

    protected $table = "transaccion";

    // Agrega todos los campos que se van a llenar masivamente
    protected $fillable = [
        "nit",
        "id_vehiculo",
        "id_tarifa",
        "id_espacio",       // <- agregar si lo estás usando
        "fecha_entrada",
        "fecha_salida",
        "precio_total",
        "lavado"            // <- ¡importante!
    ];

    protected $hidden = ["created_at", "updated_at"];

    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculo::class, "id_vehiculo");
    }

    public function tarifa(): BelongsTo
    {
        return $this->belongsTo(Tarifa::class, "id_tarifa");
    }

    public function espacio(): BelongsTo
    {
        return $this->belongsTo(Espacio::class, "id_espacio");
    }
}
