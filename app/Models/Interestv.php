<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interestv extends Model
{
    // Especifica la tabla que el modelo utiliza
    protected $table = 'interestv';

    // Definir los campos que pueden ser llenados masivamente
    protected $fillable = ['imagen', 'descripcion', 'estado'];
}
