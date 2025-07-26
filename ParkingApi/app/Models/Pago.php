<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'monto',
        'dias_pagados',
        'fecha_inicio',
        'fecha_vencimiento',
        'tipo_vehiculo',
        'placa',
    ];

    protected $dates = ['fecha_inicio', 'fecha_vencimiento'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}

