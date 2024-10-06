<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PreguntaFrecuente extends Model
{
    protected $table = 'prf_pregunta_frecuente';
    protected $primaryKey = 'prf_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'pregunta',
        'respuesta',
        'publicar',
        'fecha_registro',
        'fecha_modificacion',
        'estado',
        'usr_id'
    ];

    public function usuario(){
        return $this->belongsTo(\App\User::class,'usr_id','id');
    }



}
