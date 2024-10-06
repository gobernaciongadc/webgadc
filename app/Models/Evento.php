<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eve_evento';
    protected $primaryKey = 'eve_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'slug',
        'nombre',
        'descripcion',
        'publico',
        'imagen',
        'fecha_hora_inicio',
        'fecha_hora_fin',
        'lugar',
        'direccion',
        'latitud',
        'longitud',
        'imagen_direccion',
        'publicar',
        'estado',
        'fecha_registro',
        'fecha_modificacion',
        'und_id',
        'usr_id'
    ];

    public function unidad(){
        return $this->belongsTo(\App\Models\Unidad::class,'und_id','und_id');
    }

    public function usuario(){
        return $this->belongsTo(\App\User::class,'usr_id','id');
    }
}
