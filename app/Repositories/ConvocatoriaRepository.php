<?php
namespace App\Repositories;


use App\Models\Convocatoria;

class ConvocatoriaRepository
{
    protected $convocatoria;
    public function __construct(Convocatoria $convocatoria)
    {
        $this->convocatoria = $convocatoria;
    }
    public function getAllPaginateBySearchAndSort($limit,$und_id)
    {
        return $this->convocatoria->where([
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->orderBy('fecha_publicacion','desc')->paginate($limit);
    }

    public function save($data):?Convocatoria
    {
        $convocatoria = new $this->convocatoria;
        $convocatoria->titulo = $data['titulo'];
        $convocatoria->resumen = $data['resumen'];
        $convocatoria->contenido = $data['contenido'];
        $convocatoria->archivo = $data['archivo'];
        $convocatoria->imagen = $data['imagen'];
        $convocatoria->fecha_publicacion = $data['fecha_publicacion'];
        $convocatoria->convocante = $data['convocante'];
        $convocatoria->fecha_modificacion = $data['fecha_publicacion'];
        $convocatoria->fecha_registro = $data['fecha_registro'];
        $convocatoria->publicar = $data['publicar'];
        $convocatoria->und_id = $data['und_id'];
        $convocatoria->usr_id = $data['usr_id'];
        $convocatoria->estado = 'AC';
        $convocatoria->save();
        return $convocatoria->fresh();
    }

    public function getById($con_id):?Convocatoria
    {
        $convocatoria = Convocatoria::find($con_id);
        return $convocatoria;
    }

    public function update($data):?Convocatoria
    {
        $convocatoria = Convocatoria::find($data['con_id']);
        $convocatoria->titulo = $data['titulo'];
        $convocatoria->resumen = $data['resumen'];
        $convocatoria->contenido = $data['contenido'];

        if(isset($data['archivo'])){
            $convocatoria->archivo = $data['archivo'];
        }
        if(isset($data['imagen'])){
            $convocatoria->imagen = $data['imagen'];
        }
        $convocatoria->fecha_publicacion = $data['fecha_publicacion'];
        $convocatoria->convocante = $data['convocante'];
        $convocatoria->fecha_modificacion = $data['fecha_modificacion'];
        if(isset($data['fecha_registro'])){
            $convocatoria->fecha_registro = $data['fecha_registro'];
        }
        if(isset($data['publicar'])){
            $convocatoria->publicar = $data['publicar'];
        }
        $convocatoria->usr_id = $data['usr_id'];
        $convocatoria->und_id = $data['und_id'];
        $convocatoria->estado = 'AC';
        $convocatoria->save();
        return $convocatoria->fresh();
    }

    public function cambiarPublicar($data)
    {
        $convocatoria = $this->convocatoria->find($data['con_id']);
        $convocatoria->publicar = $data['publicar'];
        $convocatoria->save();
        return $convocatoria->fresh();
    }

    public function delete($data)
    {
        $convocatoria = $this->convocatoria->find($data['con_id']);
        $convocatoria->estado = $data['estado'];
        $convocatoria->save();
        return $convocatoria->fresh();
    }

    public function getConvocatoriasPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search)
    {
        $ruta = asset('storage/uploads/');
        $campoOrden = 'titulo';
        $maneraOrden = 'asc';
        $whereRaw = ' true ';
        if (!empty($search)){
            $whereRaw = " UPPER(titulo) like '%".strtoupper($search)."%' ";
        }
        return $this->convocatoria->whereRaw($whereRaw)->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->selectRaw("con_id as conId,titulo,resumen,CONCAT('$ruta','/',COALESCE(imagen,'')) as imagen,fecha_publicacion as fechaPublicacion")
            ->orderBy($campoOrden,$maneraOrden)
            ->orderBy('fecha_publicacion','desc')
            ->paginate($limite);
    }

}
