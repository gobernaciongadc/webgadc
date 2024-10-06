<?php
namespace App\Repositories;


use App\Models\Plan;

class PlanRepository
{
    protected $plan;
    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }
    public function getAllPaginate($limit)
    {
        return $this->plan->where([
            ['estado','=','AC']
        ])->paginate($limit);
    }

    public function save($data):?Plan
    {
        $plan = new $this->plan;
        $plan->titulo = $data['titulo'];
        $plan->periodo = $data['periodo'];
        $plan->link_descarga = $data['link_descarga'];
        $plan->imagen = $data['imagen'];
        $plan->publicar = $data['publicar'];
        $plan->usr_id = $data['usr_id'];
        $plan->estado = 'AC';
        $plan->save();
        return $plan->fresh();
    }

    public function getById($pla_id):?Plan
    {
        $plan = Plan::find($pla_id);
        return $plan;
    }

    public function update($data):?Plan
    {
        $plan = Plan::find($data['pla_id']);
        $plan->titulo = $data['titulo'];
        $plan->periodo = $data['periodo'];
        if(isset($data['link_descarga'])){
               $plan->link_descarga = $data['link_descarga'];
        }
        if(isset($data['imagen'])){
               $plan->imagen = $data['imagen'];
        }
        $plan->usr_id = $data['usr_id'];
        $plan->estado = 'AC';
        $plan->save();
        return $plan->fresh();
    }

    public function cambiarPublicar($data)
    {
        $plan = $this->plan->find($data['pla_id']);
        $plan->publicar = $data['publicar'];
        $plan->save();
        return $nlan->fresh();
    }

    public function delete($data)
    {
        $plan = $this->plan->find($data['pla_id']);
        $plan->estado ='EL';
        $plan->save();
        return $plan->fresh();
    }

    public function getAllPlanesAcPublicarSi()
    {
        return $this->plan->where([
            ['estado','=','AC'],
            ['publicar','=',1]
        ])->orderBy('titulo','asc')->get();
    }

}
