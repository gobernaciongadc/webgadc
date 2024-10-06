<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ImagenUnidad extends Model
{
    protected $table = 'imu_imagen_unidad';
    protected $primaryKey = 'imu_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'imagen',
        'alto',
        'ancho',
        'tipo',
        'und_id',
        'estado',
    ];

    public function unidad(){
        return $this->belongsTo(\App\Models\Unidad::class,'und_id','und_id');
    }

}
