<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SugerenciaReclamo extends Model
{
    protected $table = 'sur_sugerencia_reclamo';
    protected $primaryKey = 'sur_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'sugerencia',
        'estado_visto',
        'estado',
        'fecha',
        'ip_terminal'

    ];

}
