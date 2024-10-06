<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = 'ubi_ubicacion';
    protected $primaryKey = 'ubi_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'unidad',
        'lugar',
        'imagen',
        'direccion',
        'latitud',
        'longitud',
        'estado',
        'usr_id'
    ];

    public function usuario(){
        return $this->belongsTo(\App\User::class,'usr_id','id');
    }
    public function serviciosPublicos() {
        return $this->hasMany(\App\Models\Convocatoria::class, 'ubi_id', 'ubi_id');
    }

}
