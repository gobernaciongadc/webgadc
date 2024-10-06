<?php


namespace App\Repositories;


use App\Models\PublicacionCientifica;

class PublicacionCientificaRepository
{
    protected $publicacionCientifica;
    public function __construct(PublicacionCientifica $publicacionCientifica)
    {
        $this->publicacionCientifica = $publicacionCientifica;
    }

    public function getById($puc_id)
    {
        return $this->publicacionCientifica->find($puc_id);
    }

    public function getAllAc()
    {
        return $this->publicacionCientifica->where([
            ['estado','=','AC']
        ])->with('unidad')->get();
    }

    public function getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,$limit)
    {
        return $this->publicacionCientifica->where([
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->orderBy('fecha','desc')
            ->with('unidad')->paginate($limit);
    }

    public function save($data)
    {
        $nuevo = new $this->publicacionCientifica();
        $nuevo->slug = $data['slug'];
        $nuevo->und_id = $data['und_id'];
        $nuevo->usr_id = $data['usr_id'];
        $nuevo->titulo = $data['titulo'];
        $nuevo->autor = $data['autor'];
        $nuevo->resumen = $data['resumen'];
        $nuevo->imagen = $data['imagen'];
        $nuevo->fuente = $data['fuente'];
        $nuevo->fecha = $data['fecha'];
        $nuevo->publicar = $data['publicar'];
        $nuevo->fecha_registro = $data['fecha_registro'];
        $nuevo->fecha_modificacion = $data['fecha_modificacion'];
        $nuevo->estado = $data['estado'];
        $nuevo->archivo = $data['archivo'];
        $nuevo->save();
        return $nuevo->fresh();
    }

    public function update($data)
    {
        $editar = $this->publicacionCientifica->find($data['puc_id']);
        $editar->slug = $data['slug'];
        $editar->usr_id = $data['usr_id'];
        $editar->titulo = $data['titulo'];
        $editar->autor = $data['autor'];
        $editar->resumen = $data['resumen'];
        if (isset($data['imagen'])){
            $editar->imagen = $data['imagen'];
        }
        if (isset($data['archivo'])){
            $editar->archivo = $data['archivo'];
        }
        $editar->fuente = $data['fuente'];
        $editar->fecha = $data['fecha'];
        $editar->publicar = $data['publicar'];
        $editar->fecha_modificacion = $data['fecha_modificacion'];
        $editar->estado = $data['estado'];
        $editar->save();
        return $editar->fresh();
    }

    public function cambiarPublicar($data)
    {
        $editar = $this->publicacionCientifica->find($data['puc_id']);
        $editar->publicar = $data['publicar'];
        $editar->usr_id = $data['usr_id'];
        $editar->fecha_modificacion = $data['fecha_modificacion'];
        $editar->save();
        return $editar->fresh();
    }

    public function delete($data)
    {
        $editar = $this->publicacionCientifica->find($data['puc_id']);
        $editar->estado = $data['estado'];
        $editar->usr_id = $data['usr_id'];
        $editar->fecha_modificacion = $data['fecha_modificacion'];
        $editar->save();
        return $editar->fresh();
    }

    public function existeSlug($slug)
    {
        return $existe = $this->publicacionCientifica->where([
            ['slug','=',$slug]
        ])->first();
    }

    public function existeSlugById($puc_id,$slug)
    {
        return $existe = $this->publicacionCientifica->where([
            ['slug','=',$slug],
            ['puc_id','<>',$puc_id]
        ])->first();
    }

    public function getPublicacionesPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search)
    {
        $ruta = asset('storage/uploads/');
        $campoOrden = 'titulo';
        $maneraOrden = 'asc';
        $whereRaw = ' true ';
        if (!empty($search)){
            $whereRaw = " UPPER(titulo) like '%".strtoupper($search)."%' ";
        }
        return $this->publicacionCientifica->whereRaw($whereRaw)->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->selectRaw("slug,titulo,autor")
            ->orderBy($campoOrden,$maneraOrden)->paginate($limite);
    }

    public function getBySlug($slug)
    {
        return $publicacion = $this->publicacionCientifica->where([
            ['slug','=',$slug]
        ])->first();
    }

    public function tieneDatosThisUnidad($und_id)
    {
        $cantidad = $this->publicacionCientifica->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->count();
        return ($cantidad > 0);
    }

}
