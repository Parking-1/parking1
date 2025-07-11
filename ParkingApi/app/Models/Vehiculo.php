<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Cliente;
use App\Models\Transaccion;
use App\Models\TipoVehiculo;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = "vehiculo";

    protected $fillable = ["placa", "id_cliente", "id_tipo_vehiculo"];

    protected $hidden = ["created_at", "updated_at", "id_tipo_vehiculo", "id_cliente"];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, "id_cliente");
    }

    public function tipoVehiculo(): BelongsTo
    {
        return $this->belongsTo(TipoVehiculo::class, "id_tipo_vehiculo");
    }

    public function transacciones(): HasMany
    {
        return $this->hasMany(Transaccion::class, "id_vehiculo");
    }
}

