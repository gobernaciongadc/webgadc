<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoImagen extends Model
{
    protected $table = 'pri_producto_imagen';
    protected $primaryKey = 'pri_id';
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

    public function producto(){
        return $this->belongsTo(\App\Models\Producto::class,'pro_id','pro_id');
    }
}
