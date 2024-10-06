<?php
namespace App\Repositories;

use App\Models\Programa;

class ProgramaRepository
{
    protected $programa;

    public function __construct(Programa $programa)
    {
        $this->programa = $programa;
    }

    public function getAllPaginateBySearchAndSort($limit,$und_id)
    {
        return $this->programa->where([
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->orderBy('fecha_registro','desc')->paginate($limit);
    }

    public function save($data):?Programa
    {
        $programa = new $this->programa;
        $programa->nombre = $data['nombre'];
        $programa->sector = $data['sector'];
        $programa->objetivo = $data['objetivo'];
        $programa->responsable = $data['responsable'];
        $programa->presupuesto = $data['presupuesto'];
        $programa->benificiarios = $data['benificiarios'];
        $programa->estado = 'AC';
        $programa->fecha_registro = $data['fecha_registro'];
        $programa->fecha_modificacion = $data['fecha_registro'];
        $programa->publicar = $data['publicar'];
        $programa->usr_id = $data['usr_id'];
        $programa->und_id = $data['und_id'];
        $programa->metas = $data['metas'];
        $programa->metas_alcanzadas = $data['metas_alcanzadas'];
        $programa->save();
        $programa->fresh();
        return $programa;
    }

    public function getById($prg_id):?Programa
    {
        $programa = Programa::find($prg_id);
        return $programa;
    }

    public function update($data)
    {
        $programa = Programa::find($data['prg_id']);
        $programa->nombre = $data['nombre'];
        $programa->sector = $data['sector'];
        $programa->objetivo = $data['objetivo'];
        $programa->responsable = $data['responsable'];
        $programa->presupuesto = $data['presupuesto'];
        $programa->benificiarios = $data['benificiarios'];
        $programa->estado = 'AC';
        //$programa->fecha_registro = $data['fecha_registro'];
        $programa->fecha_modificacion = $data['fecha_modificacion'];
        $programa->usr_id = $data['usr_id'];
        $programa->und_id = $data['und_id'];
        $programa->metas = $data['metas'];
        $programa->metas_alcanzadas = $data['metas_alcanzadas'];
        $programa->save();
        $programa->fresh();
        return $programa;
    }

    public function cambiarPublicar($data)
    {
        $programa = $this->programa->find($data['prg_id']);
        $programa->publicar = $data['publicar'];
        $programa->save();
        return $programa->fresh();
    }

    public function delete($data)
    {
        $programa = $this->programa->find($data['prg_id']);
        $programa->estado = $data['estado'];
        $programa->save();
        return $programa->fresh();
    }

    public function getProgramasPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search)
    {
        $ruta = asset('storage/uploads/');
        $campoOrden = 'nombre';
        $maneraOrden = 'asc';
        $whereRaw = ' true ';
        if (!empty($search)){
            $whereRaw = " UPPER(nombre) like '%".strtoupper($search)."%' ";
        }
        return $this->programa->whereRaw($whereRaw)->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->selectRaw("nombre,sector,objetivo,responsable,presupuesto,benificiarios as beneficiarios,metas,metas_alcanzadas")
            ->orderBy($campoOrden,$maneraOrden)->paginate($limite);
    }

    public function tieneDatosThisUnidad($und_id)
    {
        $cantidad = $this->programa->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->count();
        return ($cantidad > 0);
    }

}
