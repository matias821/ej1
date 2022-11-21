<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;
    protected $table = "cotizaciones";

    public function comentarios()
    {
        return $this->hasMany('App\Models\Comentarios', 'cotizacion_id');
    }
}
