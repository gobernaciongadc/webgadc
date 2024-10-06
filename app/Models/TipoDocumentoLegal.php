<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TipoDocumentoLegal extends Model
{
    protected $table = 'tdl_tipo_documento_legal';
    protected $primaryKey = 'tdl_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'descripcion',
        'estado'
    ];

    public function documentolegales() {
        return $this->hasMany(\App\Models\DocumentoLegal::class, 'tdl_id', 'tdl_id');
    }

}
