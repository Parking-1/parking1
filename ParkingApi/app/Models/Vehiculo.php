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
    protected $hidden = ["created_at", "updated_at"];

    public function cliente() : BelongsTo
    {
        return $this->belongsTo(Cliente::class, "id_cliente");
    }
    public function TipoVehiculo() : BelongsTo
    {
        return $this->belongsTo(TipoVehiculo::class, 'id_tipo_vehiculo');
    }
}
