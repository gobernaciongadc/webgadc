<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\ProgramaService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProgramaControllerApi extends Controller
{
    protected $programaService;
    protected $unidadService;
    public function __construct(
        ProgramaService $programaService,
        UnidadService $unidadService
    )
    {
        $this->programaService = $programaService;
        $this->unidadService = $unidadService;
    }

    public function getProgramasPaginadoOfUnidad($und_id,Request $request)
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
            $comun->data = $this->programaService->getProgramasPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search);
            //$comun->data = $this->documentoService->getDocumentosPublicarSiAndAcOfUnidadPaginadoByTipoDocumento($und_id,$limite,$orden,$search,$tipo);
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
