<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioRol extends Model
{
    protected $table = 'url_usuario_rol';
    protected $primaryKey = 'url_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'fecha',
        'estado',
        'usr_id',
        'rol_id'
    ];

    public function rol()
    {
        return $this->belongsTo(\App\Models\Rol::class,'rol_id','rol_id');
    }

    public function usuario(){
        return $this->belongsTo(\App\User::class,'usr_id','id');
    }

}
