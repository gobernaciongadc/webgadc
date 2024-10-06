<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioImagen extends Model
{
    protected $table = 'sei_servicio_imagen';
    protected $primaryKey = 'sei_id';
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
        'sep_id'
    ];

    public function serviciopublico(){
        return $this->belongsTo(\App\Models\ServicioPublico::class,'sep_id','sep_id');
    }
}
