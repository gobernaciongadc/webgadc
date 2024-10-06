<?php


namespace App\Repositories;

use App\Models\Productor;
use App\Models\Parametrica;

class ParametricaRepository
{
    protected $parametrica;
    public function __construct(Parametrica $parametrica)
    {
        $this->parametrica = $parametrica;
    }
    public function getParametricaByTipoAndCodigo($codigo):?Parametrica
    {
        return Parametrica::where('codigo','=',$codigo)->first();
    }

    public function getAllPaginate($limit)
    {
        return $this->parametrica->where([
        ])->orderBy('par_id','asc')->paginate($limit);
    }

    public function getById($par_id):?Parametrica
    {
        $parametrica = Parametrica::find($par_id);
        return $parametrica;
    }

    public function update($data):?Parametrica
    {
        $parametrica = Parametrica::find($data['par_id']);
        $parametrica->codigo = $data['codigo'];
        $parametrica->valor1 = $data['valor1'];
        $parametrica->valor2 = $data['valor2'];
        $parametrica->valor3 = $data['valor3'];
        $parametrica->valor4 = $data['valor4'];
        $parametrica->valor5 = $data['valor5'];

        $parametrica->save();
        return $parametrica->fresh();
    }

}
