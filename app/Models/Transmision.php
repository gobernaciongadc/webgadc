<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transmision extends Model
{

    protected $table = 'transmisiones';
    protected $fillable = ['programa', 'horario', 'descripcion', 'url_youtube', 'url_facebook', 'plataforma', 'estado'];
}
