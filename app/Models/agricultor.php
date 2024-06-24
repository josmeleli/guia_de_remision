<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agricultor extends Model
{
    use HasFactory;
    protected $fillable = [
        'ruc',
        'razon_social',
        'direccion',
        'apellidos',
        'nombres',
        'dni',
    ];

    // Definir la relación con el modelo GuiaRemision
    public function guias()
    {
        return $this->hasMany(Guia::class);
    }
}
