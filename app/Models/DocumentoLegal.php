<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class DocumentoLegal extends Model
{
    protected $table = 'dol_documento_legal';
    protected $primaryKey = 'dol_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'titulo',
        'resumen',
        'contenido',
        'archivo',
        'fecha_aprobacion',
        'fecha_promulgacion',
        'numero_documento',
        'fecha_modificacion',
        'fecha_registro',
        'estado',
        'publicar',
        'und_id',
        'usr_id',
        'tdl_id'
    ];

    public function tipoDocumentoLegal(){
        return $this->belongsTo(\App\Models\TipoDocumentoLegal::class,'tdl_id','tdl_id');
    }

    public function usuario(){
        return $this->belongsTo(\App\User::class,'usr_id','id');
    }

    public function unidad(){
        return $this->belongsTo(\App\Models\Unidad::class,'und_id','und_id');
    }


}
