<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    protected $table = 'ops_opcion';
    protected $primaryKey = 'ops_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'texto_respuesta',
        'estado',
        'pre_id'
    ];

    public function pregunta(){
        return $this->belongsTo(\App\Models\Pregunta::class,'pre_id','pre_id');
    }

    public function respuestas(){
        return $this->hasMany(\App\Models\Respuesta::class,'ops_id','ops_id');
    }

}

