<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    use HasFactory;
    protected $table = "transaccion";
    protected $fillable = ["nit", "id_vehiculo", "fecha_entrada", "fecha_salida", "precio_total", "id_tarifa"];
    protected $hidden = ["created_at", "updated_at"];

}
