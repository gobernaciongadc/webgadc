<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'doc_documento';
    protected $primaryKey = 'doc_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'titulo',
        'resumen',
        'archivo',
        'fecha_publicacion',
        'fecha_modificacion',
        'fecha_registro',
        'estado',
        'publicar',
        'und_id',
        'usr_id',
        'tid_id'
    ];

    public function tipoDocumento(){
        return $this->belongsTo(\App\Models\TipoDocumento::class,'tid_id','tid_id');
    }
    public function usuario(){
        return $this->belongsTo(\App\User::class,'usr_id','id');
    }
    public function unidad(){
        return $this->belongsTo(\App\Models\Unidad::class,'und_id','und_id');
    }
    public function documentos() {
        return $this->hasMany(\App\Models\Documento::class, 'und_id', 'und_id');
    }

}
