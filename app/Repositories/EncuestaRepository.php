<?php
namespace App\Repositories;

use App\Models\Encuesta;

class EncuestaRepository
{
    protected $encuesta;
    public function __construct(Encuesta $encuesta)
    {
        $this->encuesta = $encuesta;
    }

    public function getAllPaginate($limit)
    {
        return $this->encuesta->where([
        ])->orderBy('estado','asc')->paginate($limit);
    }


}
