<?php


namespace App\Repositories;


use App\Models\Evento;

class EventoRepository
{
    protected $evento;
    public function __construct(Evento $evento)
    {
        $this->evento = $evento;
    }

    public function getById($eve_id)
    {
        return $this->evento->find($eve_id);
    }

    public function getAllAc()
    {
        return $this->evento->where([
            ['estado','=','AC']
        ])->with('unidad')->get();
    }

    public function getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,$limit)
    {
        return $this->evento->where([
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->orderBy('fecha_hora_inicio','desc')
            ->with('unidad')->paginate($limit);
    }

    public function save($data)
    {
        $nuevo = new $this->evento();
        $nuevo->slug = $data['slug'];
        $nuevo->und_id = $data['und_id'];
        $nuevo->usr_id = $data['usr_id'];
        $nuevo->nombre = $data['nombre'];
        $nuevo->descripcion = $data['descripcion'];
        $nuevo->publico = $data['publico'];
        $nuevo->imagen = $data['imagen'];
        $nuevo->fecha_hora_inicio = $data['fecha_hora_inicio'];
        $nuevo->fecha_hora_fin = $data['fecha_hora_fin'];
        $nuevo->lugar = $data['lugar'];
        $nuevo->direccion = $data['direccion'];
        $nuevo->latitud = $data['latitud'];
        $nuevo->longitud = $data['longitud'];
        $nuevo->imagen_direccion = $data['imagen_direccion'];
        $nuevo->publicar = $data['publicar'];
        $nuevo->fecha_registro = $data['fecha_registro'];
        $nuevo->fecha_modificacion = $data['fecha_modificacion'];
        $nuevo->estado = $data['estado'];
        $nuevo->save();
        return $nuevo->fresh();
    }

    public function update($data)
    {
        $editar = $this->evento->find($data['eve_id']);
        $editar->slug = $data['slug'];
        $editar->usr_id = $data['usr_id'];
        $editar->nombre = $data['nombre'];
        $editar->descripcion = $data['descripcion'];
        $editar->publico = $data['publico'];
        if (isset($data['imagen'])){
            $editar->imagen = $data['imagen'];
        }
        $editar->fecha_hora_inicio = $data['fecha_hora_inicio'];
        $editar->fecha_hora_fin = $data['fecha_hora_fin'];
        $editar->lugar = $data['lugar'];
        $editar->direccion = $data['direccion'];
        $editar->latitud = $data['latitud'];
        $editar->longitud = $data['longitud'];
        if (isset($data['imagen_direccion'])){
            $editar->imagen_direccion = $data['imagen_direccion'];
        }
        $editar->publicar = $data['publicar'];
        $editar->fecha_modificacion = $data['fecha_modificacion'];
        $editar->estado = $data['estado'];
        $editar->save();
        return $editar->fresh();
    }

    public function cambiarPublicar($data)
    {
        $editar = $this->evento->find($data['eve_id']);
        $editar->publicar = $data['publicar'];
        $editar->usr_id = $data['usr_id'];
        $editar->fecha_modificacion = $data['fecha_modificacion'];
        $editar->save();
        return $editar->fresh();
    }

    public function delete($data)
    {
        $editar = $this->evento->find($data['eve_id']);
        $editar->estado = $data['estado'];
        $editar->usr_id = $data['usr_id'];
        $editar->fecha_modificacion = $data['fecha_modificacion'];
        $editar->save();
        return $editar->fresh();
    }

    public function existeSlug($slug)
    {
        return $existe = $this->evento->where([
            ['slug','=',$slug]
        ])->first();
    }

    public function existeSlugById($eve_id,$slug)
    {
        return $existe = $this->evento->where([
            ['slug','=',$slug],
            ['eve_id','<>',$eve_id]
        ])->first();
    }

    public function getEventosPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search)
    {
        $ruta = asset('storage/uploads/');
        $campoOrden = 'nombre';
        $maneraOrden = 'asc';
        $whereRaw = ' true ';
        if (!empty($search)){
            $whereRaw = " UPPER(nombre) like '%".strtoupper($search)."%' ";
        }
        return $this->evento->whereRaw($whereRaw)->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->selectRaw("slug,nombre")
            ->orderBy($campoOrden,$maneraOrden)
            ->orderBy('fecha_hora_inicio','desc')
            ->paginate($limite);
    }

    public function getBySlug($slug)
    {
        return $this->evento->where([
            ['slug','=',$slug]
        ])->first();
    }

    public function tieneDatosThisUnidad($und_id)
    {
        $cantidad = $this->evento->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->count();
        return ($cantidad > 0);
    }

}
