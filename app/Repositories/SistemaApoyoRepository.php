<?php
namespace App\Repositories;

use App\Models\SistemaApoyo;

class SistemaApoyoRepository
{
    protected $sistemaApoyo;
    public function __construct(SistemaApoyo $sistemaApoyo)
    {
        $this->sistemaApoyo = $sistemaApoyo;
    }
    public function getAllPaginate($limit)
    {
        return $this->sistemaApoyo->where([
            ['estado','=','AC'],
        ])->paginate($limit);
    }

    public function save($data):?SistemaApoyo
    {
        $sistemaApoyo = new $this->sistemaApoyo;
        $sistemaApoyo->nombre = $data['nombre'];
        $sistemaApoyo->fecha = $data['fecha'];
        $sistemaApoyo->link_destino = $data['link_destino'];
        $sistemaApoyo->imagen = $data['imagen'];
        $sistemaApoyo->estado = 'AC';
        $sistemaApoyo->publicar = $data['publicar'];
        $sistemaApoyo->usr_id = $data['usr_id'];
        $sistemaApoyo->estado = 'AC';
        $sistemaApoyo->save();
        return $sistemaApoyo->fresh();
    }

    public function getById($sia_id):?SistemaApoyo
    {
        $sistemaApoyo = SistemaApoyo::find($sia_id);
        return $sistemaApoyo;
    }

    public function update($data):?SistemaApoyo
    {
        $sistemaApoyo = SistemaApoyo::find($data['sia_id']);
        $sistemaApoyo->nombre = $data['nombre'];
        $sistemaApoyo->fecha = $data['fecha'];
        $sistemaApoyo->link_destino = $data['link_destino'];
        if(isset($data['imagen'])){
            $sistemaApoyo->imagen = $data['imagen'];
        }
        //$sistemaApoyo->estado = $data['estado'];
        //$sistemaApoyo->publicar = $data['publicar'];
        $sistemaApoyo->usr_id = $data['usr_id'];
        //$sistemaApoyo->estado = 'AC';
        $sistemaApoyo->save();
        return $sistemaApoyo->fresh();
    }

    public function cambiarPublicar($data)
    {
        $sistemaApoyo = $this->sistemaApoyo->find($data['sia_id']);
        $sistemaApoyo->publicar = $data['publicar'];
        $sistemaApoyo->save();
        return $sistemaApoyo->fresh();
    }

    public function delete($data)
    {
        $sistemaApoyo = $this->sistemaApoyo->find($data['sia_id']);
        $sistemaApoyo->estado = 'EL';
        $sistemaApoyo->save();
        return $sistemaApoyo->fresh();
    }

    public function getAllSistemasAcAndPublicarSi()
    {
        return $this->sistemaApoyo->where([
            ['estado','=','AC'],
            ['publicar','=',1]
        ])->orderBy('nombre','asc')->get();
    }

}
