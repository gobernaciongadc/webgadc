<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\PublicacionCientificaService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PublicacionCientificaControllerApi extends Controller
{
    protected $publicacionCientificaService;
    protected $unidadService;
    public function __construct(
        PublicacionCientificaService $publicacionCientificaService,
        UnidadService $unidadService
    )
    {
        $this->publicacionCientificaService = $publicacionCientificaService;
        $this->unidadService = $unidadService;
    }

    public function getPublicacionesPaginadoOfUnidad($und_id,Request $request)
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
            $comun->data = $this->publicacionCientificaService->getPublicacionesPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search);
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

    public function getPublicacion($slug)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos de la Publicación Científica';
            $comun->data = new ComunDto();
            $publicacion = $this->publicacionCientificaService->getBySlug($slug);
            $comun->data->slug = $publicacion->slug;
            $comun->data->titulo = $publicacion->titulo;
            $comun->data->autor = $publicacion->autor;
            $comun->data->fechapublicacion = $publicacion->fecha;
            $comun->data->resumen = $publicacion->resumen;
            $comun->data->fuente = $publicacion->fuente;
            $comun->data->imagen = asset('storage/uploads/'.$publicacion->imagen);
            $comun->data->archivo = asset('storage/uploads/'.$publicacion->archivo);
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
