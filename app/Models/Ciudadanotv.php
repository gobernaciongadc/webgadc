<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudadanotv extends Model
{
    // Especifica la tabla que el modelo utiliza
    protected $table = 'ciudadanotv';

    // Definir los campos que pueden ser llenados masivamente
    protected $fillable = ['url_documento', 'descripcion', 'estado'];
}
