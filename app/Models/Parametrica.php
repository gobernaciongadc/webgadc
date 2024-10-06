<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Parametrica extends Model
{
    protected $table = 'par_parametrica';
    protected $primaryKey = 'par_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'codigo',
        'valor1',
        'valor2',
        'valor3',
        'valor4',
        'valor5',
        'estado'
    ];

}

