<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'pla_plan';
    protected $primaryKey = 'pla_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'titulo',
        'periodo',
        'imagen',
        'link_descarga',
        'publicar',
        'estado',
        'usr_id'
    ];

    public function usuario(){
        return $this->belongsTo(\App\User::class,'usr_id','id');
    }


}