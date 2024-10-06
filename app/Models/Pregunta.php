<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'pre_pregunta';
    protected $primaryKey = 'pre_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'pregunta',
        'fecha_registro',
        'publicar',
        'estado'
    ];

    public function opciones() {
        return $this->hasMany(\App\Models\Opcion::class, 'pre_id', 'pre_id');
    }

    public function respuestas(){
        return $this->hasMany(\App\Models\Respuesta::class,'pre_id','pre_id');
    }

}
