<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $table = 'not_noticia';
    protected $primaryKey = 'not_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'slug',
        'antetitulo',
        'titulo',
        'resumen',
        'contenido',
        'imagen',
        'link_video',
        'categorias',
        'palabras_clave',
        'publicar',
        'fecha',
        'fuente',
        'prioridad',
        'fecha_registro',
        'fecha_modificacion',
        'estado',
        'und_id',
        'usr_id'
    ];

    public function unidad(){
        return $this->belongsTo(\App\Models\Unidad::class,'und_id','und_id');
    }

    public function imagenesNoticia(){
        return $this->hasMany(\App\Models\ImagenNoticia::class,'not_id','not_id');
    }

    public function usuario(){
        return $this->belongsTo(\App\User::class,'usr_id','id');
    }

}
