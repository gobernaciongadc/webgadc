<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gestionjakutv extends Model
{
    // Especifica la tabla que el modelo utiliza
    protected $table = 'gestionjakutv';

    // Definir los campos que pueden ser llenados masivamente
    protected $fillable = ['nombre', 'archivo', 'imagen_portada', 'estado', 'categoriatv_id'];

    // app/Models/Gobernaciontv.php
    public function categoriaTv()
    {
        return $this->belongsTo(Jakutv::class, 'categoriatv_id');
    }
}
