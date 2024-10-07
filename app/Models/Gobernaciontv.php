<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gobernaciontv extends Model
{
    // Especifica la tabla que el modelo utiliza
    protected $table = 'gobernaciontvs';

    // Definir los campos que pueden ser llenados masivamente
    protected $fillable = ['programa', 'imagen', 'descripcion', 'url_youtube', 'url_facebook', 'plataforma', 'estado', 'categoriatv_id'];

    // app/Models/Gobernaciontv.php
    public function categoriaTv()
    {
        return $this->belongsTo(CategoriaTv::class, 'categoriatv_id');
    }
}
