<?php
namespace App\Repositories;


use App\Models\HoyHistoria;

class HoyHistoriaRepository
{

    protected $hoyHistoria;
    public function __construct(HoyHistoria $hoyHistoria)
    {
        $this->hoyHistoria = $hoyHistoria;
    }

    public function getAllPaginateBySearchAndSort($limit)
    {
        return $this->hoyHistoria->where([
            ['estado','=','AC']
        ])->paginate($limit);
    }

    public function save($data):?HoyHistoria
    {
        $hoyHistoria = new $this->hoyHistoria;
        $hoyHistoria->fecha = $data['fecha'];
        $hoyHistoria->imagen = $data['imagen'];
        $hoyHistoria->titulo = $data['titulo'];
        $hoyHistoria->acontecimiento = $data['acontecimiento'];
        $hoyHistoria->fecha_registro = $data['fecha_registro'];
        $hoyHistoria->fecha_modificacion = $data['fecha_registro'];
        $hoyHistoria->publicar = $data['publicar'];
        $hoyHistoria->usr_id = $data['usr_id'];
        $hoyHistoria->estado = 'AC';
        $hoyHistoria->save();
        return $hoyHistoria->fresh();
    }

    public function getById($hoh_id):?HoyHistoria
    {
        $hoyHistoria = HoyHistoria::find($hoh_id);
        return $hoyHistoria;
    }

    public function update($data)
    {
        $hoyHistoria = HoyHistoria::find($data['hoh_id']);
        if(isset($data['imagen'])){
            $hoyHistoria->imagen = $data['imagen'];
        }
        $hoyHistoria->fecha = $data['fecha'];
        $hoyHistoria->titulo = $data['titulo'];
        $hoyHistoria->acontecimiento = $data['acontecimiento'];
        //$hoyHistoria->fecha_registro = $data['fecha_registro'];
        $hoyHistoria->fecha_modificacion = $data['fecha_modificacion'];
        //$hoyHistoria->publicar = $data['publicar'];
        $hoyHistoria->usr_id = $data['usr_id'];
        $hoyHistoria->estado = 'AC';
        $hoyHistoria->save();
        return $hoyHistoria->fresh();

    }

    public function delete($data)
    {
        $hoyHistoria = $this->hoyHistoria->find($data['hoh_id']);
        $hoyHistoria->estado = $data['estado'];
        $hoyHistoria->save();
        return $hoyHistoria->fresh();
    }

    public function cambiarPublicar($data)
    {
        $hoyHistoria = $this->hoyHistoria->find($data['hoh_id']);
        $hoyHistoria->publicar = $data['publicar'];
        $hoyHistoria->save();
        return $hoyHistoria->fresh();
    }

    public function getAllHistoriasAcAndPublicarSiByFecha($fecha)
    {
        return $this->hoyHistoria->where([
            ['estado','=','AC'],
            ['publicar','=',1],
            ['fecha','=',$fecha]
        ])->get();
    }

}
