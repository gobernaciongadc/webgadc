<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicacionCientifica extends Model
{
    protected $table = 'puc_publicacion_cientifica';
    protected $primaryKey = 'puc_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'slug',
        'titulo',
        'autor',
        'resumen',
        'imagen',
        'fuente',
        'fecha',
        'publicar',
        'estado',
        'fecha_registro',
        'fecha_modificacion',
        'und_id',
        'usr_id',
        'archivo'
    ];

    public function unidad(){
        return $this->belongsTo(\App\Models\Unidad::class,'und_id','und_id');
    }

    public function usuario(){
        return $this->belongsTo(\App\User::class,'usr_id','id');
    }
}
