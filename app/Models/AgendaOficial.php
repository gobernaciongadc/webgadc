<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AgendaOficial extends Model
{
    protected $table = 'ago_agenda_oficial';
    protected $primaryKey = 'ago_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'fecha',
        'archivo',
        'fecha_registro',
        'fecha_modificacion',
        'estado',
        'usr_id'
    ];

    public function usuario(){
        return $this->belongsTo(\App\User::class,'usr_id','id');
    }


}
