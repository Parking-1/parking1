<?php

namespace App\Models;
use App\Models\Vehiculo;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanAbonado extends Model
{
    use HasFactory;

    protected $table = "plan_abonado";

    protected $fillable = [
        'cliente_id',
        'tipo_plan',
        'duracion',
        'monto',
        'total',
        'fecha_inicio'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function vehiculo()
{
    return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
}
}
