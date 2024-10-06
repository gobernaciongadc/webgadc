<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoyHistoria extends Model
{
    protected $table = 'hoh_hoy_historia';
    protected $primaryKey = 'hoh_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'fecha',
        'titulo',
        'imagen',
        'acontecimiento',
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
