<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ServicioPublico extends Model
{
    protected $table = 'sep_servicio_publico';
    protected $primaryKey = 'sep_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'nombre',
        'descripcion',
        'horario_atencion',
        'costo_base',
        'publicar',
        'estado',
        'fecha_registro',
        'fecha_modificacion',
        'slug',
        'und_id',
        'ubi_id',
        'usr_id'
    ];

    public function usuario(){
        return $this->belongsTo(\App\User::class,'usr_id','id');
    }

    public function unidad(){
        return $this->belongsTo(\App\Models\Unidad::class,'und_id','und_id');
    }

    public function ubicacion(){
        return $this->belongsTo(\App\Models\Ubicacion::class,'ubi_id','ubi_id');
    }

    public function servicioImagenes(){
        return $this->hasMany(\App\Models\ServicioImagen::class,'sep_id','sep_id');
    }

}
