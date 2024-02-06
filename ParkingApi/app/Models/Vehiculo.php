<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehiculo extends Model
{
    use HasFactory;
    protected $table = "vehiculo";
    protected $fillable = ["placa", "id_cliente", "id_tipo_vehiculo"];
    public function cliente() : BelongsTo
    {
        return $this->BelongsTo(Cliente::class);
    }
    public function TipoVehiculo() : BelongsTo
    {
        return $this->BelongsTo(TipoVehiculo::class);
    }
}
