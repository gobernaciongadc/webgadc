<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoUnidad extends Model
{
    protected $table = 'tiu_tipo_unidad';
    protected $primaryKey = 'tiu_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'tipo',
        'descripcion',
        'estado'
    ];

    public function unidades(){
        return $this->hasMany(\App\Models\Unidad::class,'tiu_id','tiu_id');
    }

}
