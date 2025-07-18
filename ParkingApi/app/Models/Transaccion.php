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

    protected $fillable = [
        "nit",
        "id_vehiculo",
        "id_tarifa",
        "id_espacio",
        "fecha_entrada",
        "fecha_salida",
        "precio_total",
        "lavado"
    ];

    protected $hidden = ["created_at", "updated_at"];

    // ✅ Esto es lo que faltaba
    protected $casts = [
        'fecha_entrada' => 'datetime',
        'fecha_salida' => 'datetime',
    ];

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

