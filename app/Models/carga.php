<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carga extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_conductor',
        'total_carga_bruta',
        'total_carga_neta',
        'total_material_extrano',
        'km_origen',
        'km_de_destino',
        'fecha_carga',
        'fecha_de_descarga',
    ];

    public function conductor()
    {
        return $this->belongsTo(Chofer::class, 'id_conductor');
    }
}
