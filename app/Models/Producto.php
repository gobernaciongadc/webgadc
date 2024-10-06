<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'pro_producto';
    protected $primaryKey = 'pro_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'nombre',
        'descripcion',
        'publicar',
        'estado',
        'fecha_registro',
        'fecha_modificacion',
        'slug',
        'usr_id',
        'und_id'
    ];

    public function usuario(){
        return $this->belongsTo(\App\User::class,'usr_id','id');
    }

    public function unidad(){
        return $this->belongsTo(\App\Models\Unidad::class,'und_id','und_id');
    }

    public function productoImagenes(){
        return $this->hasMany(\App\Models\ProductoImagen::class,'pro_id','pro_id');
    }

}
