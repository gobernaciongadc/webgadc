<?php


namespace App\Repositories;


use App\Models\GuiaTramite;

class GuiaTramiteRepository
{
    protected $guiaTramite;
    public function __construct(GuiaTramite $guiaTramite)
    {
        $this->guiaTramite = $guiaTramite;
    }

    public function getById($gut_id)
    {
        return $this->guiaTramite->find($gut_id);
    }

    public function getAllAc()
    {
        return $this->guiaTramite->where([
            ['estado','=','AC']
        ])->with('unidad')->get();
    }

    public function getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,$limit)
    {
        return $this->guiaTramite->where([
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->orderBy('fecha_registro','desc')
            ->with('unidad')->paginate($limit);
    }

    public function save($data)
    {
        $nuevo = new $this->guiaTramite();
        $nuevo->und_id = $data['und_id'];
        $nuevo->usr_id = $data['usr_id'];
        $nuevo->titulo = $data['titulo'];
        $nuevo->descripcion = $data['descripcion'];
        $nuevo->archivo = $data['archivo'];
        $nuevo->publicar = $data['publicar'];
        $nuevo->fecha_registro = $data['fecha_registro'];
        $nuevo->fecha_modificacion = $data['fecha_modificacion'];
        $nuevo->estado = $data['estado'];
        $nuevo->save();
        return $nuevo->fresh();
    }

    public function update($data)
    {
        $editar = $this->guiaTramite->find($data['gut_id']);
        $editar->usr_id = $data['usr_id'];
        $editar->titulo = $data['titulo'];
        $editar->descripcion = $data['descripcion'];
        if (isset($data['archivo'])){
            $editar->archivo = $data['archivo'];
        }
        $editar->publicar = $data['publicar'];
        $editar->fecha_modificacion = $data['fecha_modificacion'];
        $editar->estado = $data['estado'];
        $editar->save();
        return $editar->fresh();
    }

    public function cambiarPublicar($data)
    {
        $editar = $this->guiaTramite->find($data['gut_id']);
        $editar->publicar = $data['publicar'];
        $editar->usr_id = $data['usr_id'];
        $editar->fecha_modificacion = $data['fecha_modificacion'];
        $editar->save();
        return $editar->fresh();
    }

    public function delete($data)
    {
        $editar = $this->guiaTramite->find($data['gut_id']);
        $editar->estado = $data['estado'];
        $editar->usr_id = $data['usr_id'];
        $editar->fecha_modificacion = $data['fecha_modificacion'];
        $editar->save();
        return $editar->fresh();
    }

    public function getGuiasTramitesPublicarSiAndAcByLimitOfDespacho($limit)
    {
        return $this->guiaTramite->where([
            ['publicar','=',1],
            ['estado','=','AC']
        ])->whereHas('unidad', function ($query) {
            $query->where([
                ['estado','=','AC']
            ])->whereHas('tipoUnidad', function ($query2) {
                $query2->where('tipo', '=', 0);
            });
        })->orderBy('fecha_registro','desc')->limit($limit)->get();
    }

    public function getGuiasTramitesPublicarSiAndAcByLimitOfUnidad($und_id,$limit)
    {
        return $this->guiaTramite->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->orderBy('fecha_registro','desc')->limit($limit)->get();
    }

}
