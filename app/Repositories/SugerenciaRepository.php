<?php
namespace App\Repositories;
use App\Models\SugerenciaReclamo;

class SugerenciaRepository
{
    protected $sugerenciaReclamo;
    public function __construct(SugerenciaReclamo $sugerenciaReclamo)
    {
        $this->sugerenciaReclamo = $sugerenciaReclamo;
    }
    public function getAllPaginate($limit)
    {
        return $this->sugerenciaReclamo->where([
            ['estado','=','AC']
        ])->orderBy('fecha','desc')->paginate($limit);
    }

    public function getById($sur_id):?SugerenciaReclamo
    {
        $sugerenciaReclamo = SugerenciaReclamo::find($sur_id);
        return $sugerenciaReclamo;
    }

    public function save($data)
    {
        $sugerencia = new $this->sugerenciaReclamo();
        $sugerencia->sugerencia = $data['sugerencia'];
        $sugerencia->fecha = $data['fecha'];
        $sugerencia->estado_visto = $data['estado_visto'];
        $sugerencia->ip_terminal = $data['ip_terminal'];
        $sugerencia->estado = $data['estado'];
        $sugerencia->save();
        return $sugerencia->fresh();
    }

}
