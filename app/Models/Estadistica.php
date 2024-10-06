<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estadistica extends Model
{
    protected $table = 'est_estadistica';
    protected $primaryKey = 'est_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'slug',
        'titulo',
        'imagen',
        'descripcion',
        'fecha',
        'autor',
        'archivo',
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
