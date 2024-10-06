<?php


namespace App\Repositories;


use App\Models\Publicidad;

class PublicidadRepository
{
    protected $publicidad;
    public function __construct(Publicidad $publicidad)
    {
        $this->publicidad = $publicidad;
    }

    public function getAllPaginate($limit)
    {
        return $this->publicidad->where([
        ])->orderBy('fecha_desde','asc')->paginate($limit);
    }

    public function save($data):?Publicidad
    {

        $publicidad = new $this->publicidad;
        $publicidad->nombre = $data['nombre'];
        if(isset($data['solicitante'])){
            $publicidad->solicitante = $data['solicitante'];
        }else{
            $publicidad->solicitante = null;
        }
        $publicidad->fecha_desde = $data['fecha_desde'];
        $publicidad->fecha_hasta = $data['fecha_hasta'];
        $publicidad->fecha_registro = $data['fecha_registro'];
        $publicidad->link_destino = $data['link_destino'];
        $publicidad->imagen = $data['imagen'];
        $publicidad->publicar = $data['publicar'];
        $publicidad->estado = 'AC';
        $publicidad->usr_id = $data['usr_id'];
        $publicidad->save();
        return $publicidad->fresh();
    }

    public function getById($pub_id):?Publicidad
    {
        $publicidad = Publicidad::find($pub_id);
        return $publicidad;
    }

    public function update($data):?Publicidad
    {
        $publicidad = Publicidad::find($data['pub_id']);
        $publicidad->nombre = $data['nombre'];
        if(isset($data['solicitante'])){
            $publicidad->solicitante = $data['solicitante'];
        }else{
            $publicidad->solicitante = null;
        }
        $publicidad->fecha_desde = $data['fecha_desde'];
        $publicidad->fecha_hasta = $data['fecha_hasta'];
       // $publicidad->fecha_registro = $data['fecha_registro'];
        $publicidad->link_destino = $data['link_destino'];
        if(isset($data['imagen'])){
            $publicidad->imagen = $data['imagen'];
        }
        //$publicidad->estado = 'AC';
        //$publicidad->usr_id = $data['usr_id'];
        $publicidad->save();
        return $publicidad->fresh();
    }


    public function delete($data,$texto):?Publicidad
    {
        $publicidad = Publicidad::find($data['pub_id']);
        if($texto == 'inhabilitar') {
            $publicidad->estado = 'EL';
            $publicidad->save();
            return $publicidad->fresh();
        }
        if($texto == 'habilitar'){
            $publicidad->estado = 'AC';
            $publicidad->save();
            return $publicidad->fresh();
        }

    }

    public function cambiarPublicar($data)
    {
        $publicidad = $this->publicidad->find($data['pub_id']);
        $publicidad->publicar = $data['publicar'];
        $publicidad->save();
        return $publicidad->fresh();
    }

    public function getAllPublicidadAcAndPublicarSiActivas()
    {
        $fechaActual = date('Y-m-d');
        $ruta = asset('storage/uploads/');
        return $this->publicidad->where([
            ['estado','=','AC'],
            ['publicar','=',1],
            ['fecha_desde','<=',$fechaActual],
            ['fecha_hasta','>=',$fechaActual]
        ])->selectRaw("nombre as nombre ,CONCAT('$ruta','/',COALESCE(imagen,'')) as imagen, link_destino as link ")
            ->inRandomOrder()->get();
    }

}
