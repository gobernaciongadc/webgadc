<?php
namespace App\Repositories;

use App\Models\AgendaOficial;

class AgendaOficialRepository
{
    protected $agendaOficial;
    public function __construct(AgendaOficial $agendaOficial)
    {
        $this->agendaOficial = $agendaOficial;
    }

    public function getAllPaginateBySearchAndSort($limit)
    {
        return $this->agendaOficial->where([
            ['estado','=','AC']
        ])->paginate($limit);
    }

    public function save($data):?AgendaOficial
    {
        $agendaOficial = new $this->agendaOficial;
        $agendaOficial->fecha = $data['fecha'];
        $agendaOficial->archivo = $data['archivo'];
        $agendaOficial->fecha_registro = $data['fecha_registro'];
        $agendaOficial->fecha_modificacion = $data['fecha_registro'];
        $agendaOficial->publicar = $data['publicar'];
        $agendaOficial->usr_id = $data['usr_id'];
        $agendaOficial->estado = 'AC';
        $agendaOficial->save();
        return $agendaOficial->fresh();
    }

    public function getById($ago_id):?AgendaOficial
    {
        $agendaOficial = AgendaOficial::find($ago_id);
        return $agendaOficial;
    }

    public function update($data)
    {
        $agendaOficial = AgendaOficial::find($data['ago_id']);
        if(isset($data['archivo'])){
            $agendaOficial->archivo = $data['archivo'];
        }
        $agendaOficial->fecha = $data['fecha'];
        //$agendaOficial->fecha_registro = $data['fecha_registro'];
        $agendaOficial->fecha_modificacion = $data['fecha_modificacion'];
        //$agendaOficial->publicar = $data['publicar'];
        $agendaOficial->usr_id = $data['usr_id'];
        $agendaOficial->estado = 'AC';
        $agendaOficial->save();
        return $agendaOficial->fresh();
    }

    public function delete($data)
    {
        $agendaOficial = $this->agendaOficial->find($data['ago_id']);
        $agendaOficial->estado = $data['estado'];
        $agendaOficial->save();
        return $agendaOficial->fresh();
    }

    public function cambiarPublicar($data)
    {
        $agendaOficial = $this->agendaOficial->find($data['ago_id']);
        $agendaOficial->publicar = $data['publicar'];
        $agendaOficial->save();
        return $agendaOficial->fresh();
    }

    public function getAgendaOficialAcAndPublicarSiByFecha($fecha)
    {
        return $this->agendaOficial->where([
            ['estado','=','AC'],
            ['publicar','=',1],
            ['fecha','=',$fecha]
        ])->first();
    }


}
