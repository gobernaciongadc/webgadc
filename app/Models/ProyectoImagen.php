<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoImagen extends Model
{
    protected $table = 'poi_proyecto_imagen';
    protected $primaryKey = 'poi_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'publicar',
        'estado',
        'tipo_imagen',
        'ancho',
        'alto',
        'pro_id'
    ];

    public function proyecto(){
        return $this->belongsTo(\App\Models\Proyecto::class,'pro_id','pro_id');
    }
}
