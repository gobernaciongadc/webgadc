<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'und_unidad';
    protected $primaryKey = 'und_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'nombre',
        'mision',
        'vision',
        'objetivo',
        'historia',
        'organigrama',
        'mapa_organigrama',
        'imagen_icono',
        'estado',
        'celular_wp',
        'telefonos',
        'email',
        'link_facebook',
        'link_instagram',
        'link_twiter',
        'link_youtube',
        'lugar',
        'direccion',
        'latitud',
        'longitud',
        'imagen_direccion',
        'bio_id',
        'und_padre_id',
        'tiu_id'
    ];

    public function usuarios() {
        return $this->hasMany(\App\User::class, 'und_id', 'und_id');
    }

    public function unidadPadre(){
        return $this->belongsTo(\App\Models\Unidad::class,'und_padre_id','und_id');
    }

    public function unidadesHijo(){
        return $this->hasMany(\App\Models\Unidad::class,'und_padre_id','und_id');
    }

    public function tipoUnidad(){
        return $this->belongsTo(\App\Models\TipoUnidad::class,'tiu_id','tiu_id');
    }

    public function biografia(){
        return $this->belongsTo(\App\Models\Biografia::class,'bio_id','bio_id');
    }

    public function imagenUnidades() {
        return $this->hasMany(\App\Models\ImagenUnidad::class, 'und_id', 'und_id');
    }

    public function imagenUnidadGalerias() {
        return $this->hasMany(\App\Models\ImagenUnidadGaleria::class, 'und_id', 'und_id');
    }

    public function convocatorias() {
        return $this->hasMany(\App\Models\Convocatoria::class, 'und_id', 'und_id');
    }

    public function videoSonidos() {
        return $this->hasMany(\App\Models\VideoSonido::class, 'und_id', 'und_id');
    }

    public function documentoLegales() {
        return $this->hasMany(\App\Models\DocumentoLegal::class, 'und_id', 'und_id');
    }
    public function serviciosPublicos() {
        return $this->hasMany(\App\Models\Convocatoria::class, 'und_id', 'und_id');
    }

    public function programas() {
        return $this->hasMany(\App\Models\Programa::class, 'und_id', 'und_id');
    }

    public function productos() {
        return $this->hasMany(\App\Models\Producto::class, 'und_id', 'und_id');
    }

    public function rendicionCuentas() {
        return $this->hasMany(\App\Models\RendicionCuenta::class, 'und_id', 'und_id');
    }

    public function proyectos() {
        return $this->hasMany(\App\Models\Proyecto::class, 'und_id', 'und_id');
    }


}
