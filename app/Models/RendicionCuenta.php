<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class RendicionCuenta extends Model
{
    protected $table = 'rec_rendicion_cuenta';
    protected $primaryKey = 'rec_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'titulo',
        'descripcion',
        'archivo',
        'publicar',
        'estado',
        'fecha_registro',
        'fecha_modificacion',
        'usr_id',
        'und_id'
    ];

    public function usuario(){
        return $this->belongsTo(\App\User::class,'usr_id','id');
    }

    public function unidad(){
        return $this->belongsTo(\App\Models\Unidad::class,'und_id','und_id');
    }
}
