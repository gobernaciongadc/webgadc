<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenNoticia extends Model
{
    protected $table = 'imn_imagen_noticia';
    protected $primaryKey = 'imn_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'titulo',
        'descripcion',
        'fecha',
        'imagen',
        'publicar',
        'estado',
        'tipo_imagen',
        'ancho',
        'alto',
        'not_id'
    ];

    public function noticia(){
        return $this->belongsTo(\App\Models\Noticia::class,'not_id','not_id');
    }

}
