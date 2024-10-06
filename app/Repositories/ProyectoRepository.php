<?php


namespace App\Repositories;
use App\Models\Proyecto;
use App\Models\ProyectoImagen;
use App\Models\Unidad;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProyectoRepository
{
    protected $proyecto;

    public function __construct(Proyecto $proyecto)
    {
        $this->proyecto = $proyecto;
    }

    public function getAllPaginateBySearchAndSort($limit,$und_id)
    {
        return $this->proyecto->where([
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->orderBy('fecha_registro','desc')->paginate($limit);
    }

    public function save($data):?Proyecto
    {
        $proyecto = new $this->proyecto;
        $proyecto->nombre = $data['nombre'];
        $proyecto->descripcion = $data['descripcion'];
        $proyecto->inversion = $data['inversion'];
        $proyecto->fuente_financiamiento = $data['fuente_financiamiento'];
        $proyecto->estado_proyecto = $data['estado_proyecto'];
        $proyecto->ejecucion_fisica = $data['ejecucion_fisica'];
        $proyecto->publicar = $data['publicar'];
        $proyecto->fecha_registro = $data['fecha_registro'];
        $proyecto->fecha_modificacion = $data['fecha_registro'];
        $proyecto->estado = 'AC';
        $proyecto->usr_id = $data['usr_id'];
        $proyecto->und_id = $data['und_id'];
        $proyecto->save();
        $proyecto->fresh();
        if(isset($data['imagenes'])){
            $imagenes = $data['imagenes'];
            if(count($imagenes) > 0){
                foreach ($imagenes as $imagen){
                    $ima = new ProyectoImagen();
                    $ima->titulo = $imagen['titulo'];
                    $ima->descripcion = $imagen['descripcion'];
                    $ima->imagen = $imagen['imagen'];
                    $ima->publicar = $imagen['publicar'];
                    $ima->estado = $imagen['estado'];
                    $ima->tipo_imagen = $imagen['tipo_imagen'];
                    $ima->ancho = $imagen['ancho'];
                    $ima->alto = $imagen['alto'];
                    $ima->pro_id = $proyecto->pro_id;
                    $ima->save();
                }
            }
        }
        return $proyecto;
    }
    public function getById($pro_id):?Proyecto
    {
        $proyecto = Proyecto::find($pro_id);
        return $proyecto;
    }

    public function update($data):?Proyecto
    {
        $proyecto = Proyecto::find($data['pro_id']);
        $proyecto->nombre = $data['nombre'];
        $proyecto->descripcion = $data['descripcion'];
        $proyecto->inversion = $data['inversion'];
        $proyecto->fuente_financiamiento = $data['fuente_financiamiento'];
        $proyecto->estado_proyecto = $data['estado_proyecto'];
        $proyecto->ejecucion_fisica = $data['ejecucion_fisica'];
        //$proyecto->publicar = $data['publicar'];
        //$proyecto->fecha_registro = $data['fecha_registro'];
        $proyecto->fecha_modificacion = $data['fecha_modificacion'];
        //$proyecto->estado = 'AC';
        //$proyecto->usr_id = $data['usr_id'];
        //$proyecto->und_id = $data['und_id'];
        $proyecto->save();
        $proyecto->fresh();
        if(isset($data['imagenes'])){
            $imagenes = $data['imagenes'];
            if(count($imagenes) > 0){
                foreach ($imagenes as $imagen){
                    $ima = new ProyectoImagen();
                    $ima->titulo = $imagen['titulo'];
                    $ima->descripcion = $imagen['descripcion'];
                    $ima->imagen = $imagen['imagen'];
                    $ima->publicar = $imagen['publicar'];
                    $ima->estado = $imagen['estado'];
                    $ima->tipo_imagen = $imagen['tipo_imagen'];
                    $ima->ancho = $imagen['ancho'];
                    $ima->alto = $imagen['alto'];
                    $ima->pro_id = $proyecto->pro_id;
                    $ima->save();
                }
            }
        }
        return $proyecto;
    }

    public function delete($data)
    {
        $proyecto = $this->proyecto->find($data['pro_id']);
        $proyecto->estado = $data['estado'];
        $proyecto->save();
        return $proyecto->fresh();
    }

    public function cambiarPublicar($data)
    {
        $proyecto = $this->proyecto->find($data['pro_id']);
        $proyecto->publicar = $data['publicar'];
        $proyecto->save();
        return $proyecto->fresh();
    }

    public function getProyectosPublicarSiAndAcOfAllPaginadoOfUnidad($und_id,$limite,$orden,$search)
    {
        $ruta = asset('storage/uploads/');
        $campoOrden = 'nombre';
        $maneraOrden = 'asc';
        $whereRaw = ' true ';
        if (!empty($search)){
            $whereRaw = " UPPER(nombre) like '%".strtoupper($search)."%' ";
        }
        return $this->proyecto->whereRaw($whereRaw)->where([
            ['estado','=','AC'],
            ['publicar','=',1],
            ['und_id','=',$und_id]
        ])
            /*->selectRaw("nombre,descripcion,inversion,fuente_financiamiento as fuentefinanciamento,estado_proyecto as estadoproyecto,ejecucion_fisica as ejecucionfisica,
                        (select CONCAT('$ruta','/',COALESCE(ima.imagen,'')) from poi_proyecto_imagen as ima where ima.pro_id = pro_proyecto.pro_id and ima.estado = 'AC' limit 1) as imagen")*/
            ->selectRaw("pro_id,nombre,descripcion,inversion,fuente_financiamiento as fuentefinanciamento,estado_proyecto as estadoproyecto,ejecucion_fisica as ejecucionfisica")
            ->orderBy($campoOrden,$maneraOrden)
            //->with('proyectoImagenes')
            ->with(['proyectoImagenes'=>function($query) use($ruta){
                $query->where([
                    ['estado','=','AC']
                ])->selectRaw("poi_id,pro_id,titulo,descripcion,CONCAT('$ruta','/',COALESCE(imagen,'')) as imagen");
            }])
            ->paginate($limite);
    }

    public function tieneDatosThisUnidad($und_id)
    {
        $cantidad = $this->proyecto->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->count();
        return ($cantidad > 0);
    }

    public function eliminarProyectoImagen($data)
    {
        $imagen = ProyectoImagen::find($data['poi_id']);
        $imagen->estado = $data['estado'];
        $imagen->save();
        return $imagen->fresh();
    }

}
