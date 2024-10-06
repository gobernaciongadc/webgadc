<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biografia extends Model
{
    protected $table = 'bio_biografia';
    protected $primaryKey = 'bio_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'nombres',
        'apellidos',
        'imagen_foto',
        'profesion',
        'resenia',
        'estado'
    ];

    public function unidades() {
        return $this->hasMany(\App\Models\Unidad::class, 'bio_id', 'bio_id');
    }

}
