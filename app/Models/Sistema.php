<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sistema extends Model
{
    protected $table = 'sis_sistema';
    protected $primaryKey = 'sis_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'descripcion',
        'estado',
        'orden'
    ];

    public function modulos()
    {
        return $this->hasMany(\App\Models\Modulo::class,'sis_id','sis_id');
    }
}
