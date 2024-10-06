<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoSonido extends Model
{
    protected $table = 'vis_video_sonido';
    protected $primaryKey = 'vis_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'titulo',
        'descripcion',
        'link_descarga',
        'fecha',
        'publicar',
        'estado',
        'und_id'
    ];

    public function unidad(){
        return $this->belongsTo(\App\Models\Unidad::class,'und_id','und_id');
    }


}
