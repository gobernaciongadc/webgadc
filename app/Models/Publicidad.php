<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Publicidad extends Model
{
    protected $table = 'pub_publicidad';
    protected $primaryKey = 'pub_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'nombre',
        'solicitante',
        'fecha_desde',
        'fecha_hasta',
        'fecha_registro',
        'link_destino',
        'imagen',
        'publicar',
        'estado',
        'usr_id'
    ];

    public function usuario(){
        return $this->belongsTo(\App\User::class,'usr_id','id');
    }


}
