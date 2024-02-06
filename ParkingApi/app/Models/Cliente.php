<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Vehiculo;

class Cliente extends Model
{
    use HasFactory;
    protected $table = "cliente";
    public function vehiculo() : HasMany{
        return $this->HasMany(Vehiculo::class);
    }
}
