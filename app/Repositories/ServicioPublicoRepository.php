<?php


namespace App\Repositories;


use App\Models\Biografia;
use App\Models\ServicioImagen;
use App\Models\ServicioPublico;

class ServicioPublicoRepository
{
    protected $servicioPublico;

    public function __construct(ServicioPublico $servicioPublico)
    {
        $this->servicioPublico = $servicioPublico;
    }

    public function getAllPaginateBySearchAndSort($limit,$und_id)
    {
        return $this->servicioPublico->where([
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->orderBy('fecha_registro','desc')->paginate($limit);
    }

    public function save($data):?ServicioPublico
    {
        $servicioPublico = new $this->servicioPublico;
        $servicioPublico->slug = $data['slug'];
        $servicioPublico->nombre = $data['nombre'];
        $servicioPublico->descripcion = $data['descripcion'];
        $servicioPublico->horario_atencion = $data['horario_atencion'];
        $servicioPublico->costo_base = $data['costo_base'];
        $servicioPublico->fecha_registro = $data['fecha_registro'];
        $servicioPublico->fecha_modificacion = $data['fecha_registro'];
        $servicioPublico->publicar = $data['publicar'];
        //$servicioPublico->imagen = $data['imagen'];
        $servicioPublico->estado = 'AC';
        $servicioPublico->und_id = $data['und_id'];
        $servicioPublico->ubi_id = $data['ubi_id'];
        $servicioPublico->usr_id = $data['usr_id'];
        $servicioPublico->save();
        $servicioPublico->fresh();
        if(isset($data['imagenes'])){
            $imagenes = $data['imagenes'];
            if(count($imagenes) > 0){
                foreach ($imagenes as $imagen){
                    $ima = new ServicioImagen();
                    $ima->titulo = $imagen['titulo'];
                    $ima->descripcion = $imagen['descripcion'];
                    $ima->imagen = $imagen['imagen'];
                    $ima->publicar = $imagen['publicar'];
                    $ima->estado = $imagen['estado'];
                    $ima->tipo_imagen = $imagen['tipo_imagen'];
                    $ima->ancho = $imagen['ancho'];
                    $ima->alto = $imagen['alto'];
                    $ima->sep_id = $servicioPublico->sep_id;
                    $ima->save();
                }
            }
        }
        return $servicioPublico;
    }

    public function getById($und_id):?ServicioPublico
    {
        $biografia = ServicioPublico::find($und_id);
        return $biografia;
    }

    public function update($data)
    {
        $servicioPublico = ServicioPublico::find($data['sep_id']);
        $servicioPublico->slug = $data['slug'];
        $servicioPublico->nombre = $data['nombre'];
        $servicioPublico->descripcion = $data['descripcion'];
        $servicioPublico->horario_atencion = $data['horario_atencion'];
        $servicioPublico->costo_base = $data['costo_base'];
        //$servicioPublico->fecha_registro = $data['fecha_registro'];
        $servicioPublico->fecha_modificacion = $data['fecha_modificacion'];
        //$servicioPublico->publicar = $data['publicar'];
        /*if(isset($data['imagen'])){
            $servicioPublico->imagen = $data['imagen'];
        }*/
        $servicioPublico->estado = 'AC';
        $servicioPublico->und_id = $data['und_id'];
        $servicioPublico->ubi_id = $data['ubi_id'];
        $servicioPublico->usr_id = $data['usr_id'];
        $servicioPublico->save();
        $servicioPublico->fresh();
        if(isset($data['imagenes'])){
            $imagenes = $data['imagenes'];
            if(count($imagenes) > 0){
                foreach ($imagenes as $imagen){
                    $ima = new ServicioImagen();
                    $ima->titulo = $imagen['titulo'];
                    $ima->descripcion = $imagen['descripcion'];
                    $ima->imagen = $imagen['imagen'];
                    $ima->publicar = $imagen['publicar'];
                    $ima->estado = $imagen['estado'];
                    $ima->tipo_imagen = $imagen['tipo_imagen'];
                    $ima->ancho = $imagen['ancho'];
                    $ima->alto = $imagen['alto'];
                    $ima->sep_id = $servicioPublico->sep_id;
                    $ima->save();
                }
            }
        }
        return $servicioPublico;
    }

    public function cambiarPublicar($data)
    {
        $servicioPublico = $this->servicioPublico->find($data['sep_id']);
        $servicioPublico->publicar = $data['publicar'];
        $servicioPublico->save();
        return $servicioPublico->fresh();
    }

    public function delete($data)
    {
        $servicioPublico = $this->servicioPublico->find($data['sep_id']);
        $servicioPublico->estado = $data['estado'];
        $servicioPublico->save();
        return $servicioPublico->fresh();
    }

    public function existeSlug($slug)
    {
        return $existe = $this->servicioPublico->where([
            ['slug','=',$slug]
        ])->first();
    }

    public function existeSlugById($sep_id,$slug)
    {
        return $existe = $this->servicioPublico->where([
            ['slug','=',$slug],
            ['sep_id','<>',$sep_id]
        ])->first();
    }

    public function getServiciosPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search)
    {
        $ruta = asset('storage/uploads/');
        $campoOrden = 'nombre';
        $maneraOrden = 'asc';
        $whereRaw = ' true ';
        if (!empty($search)){
            $whereRaw = " UPPER(nombre) like '%".strtoupper($search)."%' ";
        }
        return $this->servicioPublico->whereRaw($whereRaw)->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->selectRaw("slug,nombre")
            ->orderBy($campoOrden,$maneraOrden)
            ->paginate($limite);
    }

    public function getBySlug($slug)
    {
        return $this->servicioPublico->where([
            ['slug','=',$slug]
        ])->first();
    }

    public function tieneDatosThisUnidad($und_id)
    {
        $cantidad = $this->servicioPublico->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->count();
        return ($cantidad > 0);
    }

    public function eliminarServicioImagen($data)
    {
        $imagen = ServicioImagen::find($data['sei_id']);
        $imagen->estado = $data['estado'];
        $imagen->save();
        return $imagen->fresh();
    }

}
