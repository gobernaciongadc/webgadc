<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    protected $table = 'acc_acceso';
    protected $primaryKey = 'acc_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'descripcion',
        'estado',
        'operacion',
        'codigo',
        'orden',
        'mod_id'
    ];

    public function modulo()
    {
        return $this->belongsTo(\App\Models\Modulo::class,'mod_id','mod_id');
    }

    public function rolesAcceso()
    {
        return $this->hasMany(\App\Models\RolAcceso::class,'acc_id','acc_id');
    }

}
