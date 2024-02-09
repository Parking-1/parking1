<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Vehiculo;

class Transaccion extends Model
{
    use HasFactory;
    protected $table = "transaccion";
    protected $fillable = ["nit", "id_vehiculo", "fecha_entrada", "fecha_salida", "precio_total", "id_tarifa"];
    protected $hidden = ["created_at", "updated_at"];
    public function vehiculo() : BelongsTo{
        return $this->belongsTo(Vehiculo::class, "id_vehiculo");
    }
}
