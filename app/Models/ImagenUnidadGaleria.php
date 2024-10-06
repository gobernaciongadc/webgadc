<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenUnidadGaleria extends Model
{
    protected $table = 'iug_imagen_unidad_galeria';
    protected $primaryKey = 'iug_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'imagen',
        'alto',
        'ancho',
        'tipo',
        'publicar',
        'estado',
        'titulo',
        'descripcion',
        'fecha',
        'und_id',
    ];

    public function unidad(){
        return $this->belongsTo(\App\Models\Unidad::class,'und_id','und_id');
    }

}
