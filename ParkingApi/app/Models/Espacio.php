<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Espacio extends Model
{
    use HasFactory;
    protected $table = "espacio";
    protected $fillable = ["descripcion"];
    protected $hidden = ["created_at", "updated_at"];
    public function vehiculo () : BelongsToMany{
        return $this->belongsToMany(Vehiculo::class);
    }
}
