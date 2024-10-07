<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Radiotv extends Model
{
    // Especifica la tabla que el modelo utiliza
    protected $table = 'radiotv';

    // Definir los campos que pueden ser llenados masivamente
    protected $fillable = ['url_radio', 'descripcion', 'estado'];
}
