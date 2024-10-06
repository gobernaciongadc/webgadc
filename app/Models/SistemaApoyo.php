<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SistemaApoyo extends Model
{
    protected $table = 'sia_sistema_apoyo';
    protected $primaryKey = 'sia_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'nombre',
        'fecha',
        'link_destino',
        'imagen',
        'estado',
        'publicar',
        'usr_id'
    ];




}

