<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'pro_proyecto';
    protected $primaryKey = 'pro_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'nombre',
        'descripcion',
        'inversion',
        'fuente_financiamiento',
        'estado_proyecto',
        'ejecucion_fisica',
        'publicar',
        'estado',
        'fecha_registro',
        'fecha_modificacion',
        'usr_id',
        'und_id'
    ];

    public function unidad(){
        return $this->belongsTo(\App\Models\Unidad::class,'und_id','und_id');
    }

    public function proyectoImagenes(){
        return $this->hasMany(\App\Models\ProyectoImagen::class,'pro_id','pro_id');
    }

}
