<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ImgSemanario extends Model
{

    protected $table = 'img_semanarios';
    protected $fillable = ['semanario_id', 'imagen'];


    // Relaciones
    public function semanario()
    {
        return $this->belongsTo(ConSemanario::class, 'semanario_id');  // recibe a semanario
    }
}
