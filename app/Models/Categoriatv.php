<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoriatv extends Model
{
    // Especifica la tabla que el modelo utiliza
    protected $table = 'categoriatv';

    // Definir los campos que pueden ser llenados masivamente
    protected $fillable = ['nombre', 'descripcion', 'estado'];
}
