<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jakutv extends Model
{
    // Especifica la tabla que el modelo utiliza
    protected $table = 'jakutv';

    // Definir los campos que pueden ser llenados masivamente
    protected $fillable = ['nombre', 'imagen', 'descripcion', 'estado'];

    public function categoriaTv()
    {
        return $this->belongsTo(CategoriaTv::class, 'categoria_tv_id'); // Ajusta 'categoria_tv_id' si el nombre de la clave foránea es diferente.
    }
}
