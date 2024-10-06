<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convocatoria extends Model
{
    protected $table = 'con_convocatoria';
    protected $primaryKey = 'con_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'titulo',
        'resumen',
        'contenido',
        'archivo',
        'imagen',
        'fecha_publicacion',
        'convocante',
        'fecha_modificacion',
        'fecha_registro',
        'estado',
        'publicar',
        'und_id'
    ];

    public function unidad(){
        return $this->belongsTo(\App\Models\Unidad::class,'und_id','und_id');
    }






}
