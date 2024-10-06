<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'mod_modulo';
    protected $primaryKey = 'mod_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'descripcion',
        'estado',
        'orden',
        'sis_id'
    ];

    public function sistema()
    {
        return $this->belongsTo(\App\Models\Sistema::class,'sis_id','sis_id');
    }

    public function accesos()
    {
        return $this->hasMany(\App\Models\Acceso::class,'mod_id','mod_id');
    }
}
