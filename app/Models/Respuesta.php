<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    protected $table = 'res_respuesta';
    protected $primaryKey = 'res_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'ip_terminal',
        'fecha',
        'estado',
        'pre_id',
        'ops_id'
    ];

    public function pregunta(){
        return $this->belongsTo(\App\Models\Pregunta::class,'pre_id','pre_id');
    }

    public function opcion(){
        return $this->belongsTo(\App\Models\Opcion::class,'ops_id','ops_id');
    }

}
