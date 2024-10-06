<?php
namespace App\Repositories;

use App\Models\TipoUnidad;
use App\Repositories\ImagenUnidadRepository;
use App\Repositories\UnidadRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TipoUnidadRepository
{
    protected $tipoUnidad;
    public function __construct(TipoUnidad $tipoUnidad)
    {
        $this->tipoUnidad = $tipoUnidad;
    }

    public function save($data):?TipoUnidad
    {
        $tipoUnidad = new $this->tipoUnidad;
        $tipoUnidad->tipo = $data['tipo'];
        $tipoUnidad->descripcion = $data['descripcion'];
        $tipoUnidad->estado = $data['estado'];
        $tipoUnidad->save();
        return $tipoUnidad->fresh();
    }

    public function getById($tiu_id):?TipoUnidad
    {
        $tipoUnidad = TipoUnidad::find($tiu_id);
        return $tipoUnidad;
    }

    public function update($data):?TipoUnidad
    {
        $tipoUnidad = TipoUnidad::find($data['tiu_id']);
        $tipoUnidad->tipo = $data['tipo'];
        $tipoUnidad->descripcion = $data['descripcion'];
        $tipoUnidad->estado = $data['estado'];
        $tipoUnidad->save();
        return $tipoUnidad->fresh();
    }

    public function delete($data,$texto):?TipoUnidad
    {
        $tipoUnidad = TipoUnidad::find($data['$tiu_id']);
        if($texto == 'inhabilitar') {
            $tipoUnidad->estado = 'EL';
            $tipoUnidad->save();
            return $tipoUnidad->fresh();
        }
        if($texto == 'habilitar'){
            $tipoUnidad->estado = 'AC';
            $tipoUnidad->save();
            return $tipoUnidad->fresh();
        }
    }


    public function getTipoUnidadByTipo($tipo)
    {
        return $this->tipoUnidad->where([
            ['tipo','=',$tipo],
            ['estado','=','AC']
        ])->first();
    }



}
