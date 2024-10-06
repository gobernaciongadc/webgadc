<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{

    protected $table = 'tid_tipo_documento';
    protected $primaryKey = 'tid_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'descripcion',
        'estado'
    ];

    public function documentos() {
        return $this->hasMany(\App\Models\Documento::class, 'tid_id', 'tid_id');
    }
}
