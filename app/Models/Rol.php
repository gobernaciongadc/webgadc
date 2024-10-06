<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol_rol';
    protected $primaryKey = 'rol_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'descripcion',
        'estado'
    ];

    public function rolesAcceso()
    {
        return $this->hasMany(\App\Models\RolAcceso::class,'rol_id','rol_id');
    }

    public function usuarioRoles()
    {
        return $this->hasMany(\App\Models\UsuarioRol::class,'rol_id','rol_id');
    }

}
