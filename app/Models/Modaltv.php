<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modaltv extends Model
{
    // Especifica la tabla que el modelo utiliza
    protected $table = 'modaltv';

    // Definir los campos que pueden ser llenados masivamente
    protected $fillable = ['url_documento', 'imagen', 'descripcion', 'estado'];
}
