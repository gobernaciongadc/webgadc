<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    protected $table = 'den_denuncia';
    protected $primaryKey = 'den_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'nombre',
        'correo',
        'denuncia',
        'fecha_hora',
        'estado_visto',
        'ip_terminal',
        'celular',
        'estado'
    ];

}
