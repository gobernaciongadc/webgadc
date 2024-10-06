<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Repositories\ProductoRepository;
use App\Services\ProductoService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProductoControllerApi extends Controller
{
    protected $productoService;
    protected $unidadService;
    public function __construct(
        ProductoService $productoService,
        UnidadService $unidadService
    )
    {
        $this->productoService = $productoService;
        $this->unidadService = $unidadService;
    }

    public function getProductosPaginadoOfUnidad($und_id,Request $request)
    {
        try {
            $unidad = $this->unidadService->getById($und_id);
            $limite = 10;
            $orden = 1;
            $search = '';
            if ($request->has('limite')){
                $limite = $request->limite;
            }
            if ($request->has('orden')){
                $orden = $request->orden;
            }
            if ($request->has('search')){
                $search = $request->search;
            }
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = $unidad->nombre;
            $comun->data = new ComunDto();
            $comun->data = $this->productoService->getProductosPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search);
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

    public function getProductoBySlug($slug)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos del Producto';
            $comun->data = new ComunDto();
            $producto = $this->productoService->getBySlug($slug);
            $comun->data->slug = $producto->slug;
            $comun->data->nombre = $producto->nombre;
            $comun->data->descripcion = $producto->descripcion;
            //$comun->data->imagen = asset('storage/uploads/'.$producto->imagen);
            $imagenes = array();
            foreach ($producto->productoImagenes as $imagen){
                if ($imagen->estado == 'AC'){
                    $ima = array();
                    $ima['imagen'] = asset('storage/uploads').'/'.$imagen->imagen;
                    $ima['titulo'] = $imagen->titulo;
                    $ima['descripcion'] = $imagen->descripcion;
                    array_push($imagenes,$ima);
                }
            }
            $comun->data->imagenes = $imagenes;
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

}
