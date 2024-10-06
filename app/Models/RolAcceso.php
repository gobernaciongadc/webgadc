<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolAcceso extends Model
{
    protected $table = 'rac_rol_acceso';
    protected $primaryKey = 'rac_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'estado',
        'acc_id',
        'rol_id'
    ];

    public function acceso()
    {
        return $this->belongsTo(\App\Models\Acceso::class,'acc_id','acc_id');
    }

    public function rol()
    {
        return $this->belongsTo(\App\Models\Rol::class,'rol_id','rol_id');
    }

}
