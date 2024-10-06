<?php


namespace App\Repositories;


use App\Models\Estadistica;

class EstadisticaRepository
{
    protected $estadistica;
    public function __construct(Estadistica $estadistica)
    {
        $this->estadistica = $estadistica;
    }

    public function getById($est_id)
    {
        return $this->estadistica->find($est_id);
    }

    public function getAllAc()
    {
        return $this->estadistica->where([
            ['estado','=','AC']
        ])->with('unidad')->get();
    }

    public function getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,$limit)
    {
        return $this->estadistica->where([
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->orderBy('fecha','desc')
            ->with('unidad')->paginate($limit);
    }

    public function save($data)
    {
        $nuevo = new $this->estadistica();
        $nuevo->slug = $data['slug'];
        $nuevo->und_id = $data['und_id'];
        $nuevo->usr_id = $data['usr_id'];
        $nuevo->titulo = $data['titulo'];
        $nuevo->imagen = $data['imagen'];
        $nuevo->descripcion = $data['descripcion'];
        $nuevo->fecha = $data['fecha'];
        $nuevo->autor = $data['autor'];
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
        $editar = $this->estadistica->find($data['est_id']);
        $editar->slug = $data['slug'];
        $editar->usr_id = $data['usr_id'];
        $editar->titulo = $data['titulo'];
        if (isset($data['imagen'])){
            $editar->imagen = $data['imagen'];
        }
        $editar->descripcion = $data['descripcion'];
        $editar->fecha = $data['fecha'];
        $editar->autor = $data['autor'];
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
        $editar = $this->estadistica->find($data['est_id']);
        $editar->publicar = $data['publicar'];
        $editar->usr_id = $data['usr_id'];
        $editar->fecha_modificacion = $data['fecha_modificacion'];
        $editar->save();
        return $editar->fresh();
    }

    public function delete($data)
    {
        $editar = $this->estadistica->find($data['est_id']);
        $editar->estado = $data['estado'];
        $editar->usr_id = $data['usr_id'];
        $editar->fecha_modificacion = $data['fecha_modificacion'];
        $editar->save();
        return $editar->fresh();
    }

    public function existeSlug($slug)
    {
        return $existe = $this->estadistica->where([
            ['slug','=',$slug]
        ])->first();
    }

    public function existeSlugById($est_id,$slug)
    {
        return $existe = $this->estadistica->where([
            ['slug','=',$slug],
            ['est_id','<>',$est_id]
        ])->first();
    }

    public function getEstadisticasPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search)
    {
        $ruta = asset('storage/uploads/');
        $campoOrden = 'titulo';
        $maneraOrden = 'asc';
        $whereRaw = ' true ';
        if (!empty($search)){
            $whereRaw = " UPPER(titulo) like '%".strtoupper($search)."%' ";
        }
        return $this->estadistica->whereRaw($whereRaw)->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->selectRaw("slug,titulo,autor")
            ->orderBy($campoOrden,$maneraOrden)
            ->orderBy('fecha','desc')
            ->paginate($limite);
    }

    public function getBySlug($slug)
    {
        return $estadistica = $this->estadistica->where([
            ['slug','=',$slug]
        ])->first();
    }

    public function tieneDatosThisUnidad($und_id)
    {
        $cantidad = $this->estadistica->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->count();
        return ($cantidad > 0);
    }

}
