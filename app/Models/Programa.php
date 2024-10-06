<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    protected $table = 'prg_programa';
    protected $primaryKey = 'prg_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'sector',
        'objetivo',
        'responsable',
        'presupuesto',
        'benificiarios',
        'publicar',
        'estado',
        'fecha_registro',
        'fecha_modificacion',
        'usr_id',
        'und_id',
        'metas',
        'metas_alcanzadas'
    ];

    public function usuario(){
        return $this->belongsTo(\App\User::class,'usr_id','id');
    }

    public function unidad(){
        return $this->belongsTo(\App\Models\Unidad::class,'und_id','und_id');
    }

}
