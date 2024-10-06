<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\DocumentoLegalService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DocumentoLegalControllerApi extends Controller
{
    protected $documentoLegalService;
    protected $unidadService;
    public function __construct(
        DocumentoLegalService $documentoLegalService,
        UnidadService $unidadService
    )
    {
        $this->documentoLegalService = $documentoLegalService;
        $this->unidadService = $unidadService;
    }

    public function getLeyesDecretos()
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Datos Leyes Decretos';
            $comun->data = new Collection();
            $limite = 8;
            //$guias = $this->guiaTramiteService->getGuiasTramitesPublicarSiAndAcByLimitOfDespacho($limite);
            $documentos = $this->documentoLegalService->getDocumentosLegalesPublicarSiAndAcByLimitOfDespacho($limite);
            foreach ($documentos as $key=>$documento){
                $docu = new ComunDto();
                $docu->titulo = $documento->titulo;
                $docu->resumen = $documento->resumen;
                $docu->contenido = $documento->contenido;
                $docu->tipo = $documento->tipoDocumentoLegal->descripcion;
                $docu->fechaAprobacion = $documento->fecha_aprobacion;
                $docu->fechaPromulgacion = $documento->fecha_promulgacion;
                $docu->numeroDocumento = $documento->numero_documento;
                $docu->archivo = asset('storage/uploads/'.$documento->archivo);
                $comun->data->push($docu);
            }
            return response()->json($comun->toArray(),200);

        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

    public function getLeyesDecretosInicio()
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = '3 Leyes y 3 Decretos';
            $comun->data = new ComunDto();
            $comun->data->leyes = new Collection();
            $comun->data->decretos = new Collection();
            $limite = 3;
            $leyes = $this->documentoLegalService->getDocumentosLegalesPublicarSiAndAcByLimitOfDespachoByTipoDocumentoLiteral($limite,'Leyes');
            foreach ($leyes as $key=>$ley){
                $docu = new ComunDto();
                $docu->titulo = $ley->titulo;
                $docu->resumen = $ley->resumen;
                $docu->contenido = $ley->contenido;
                $docu->tipo = $ley->tipoDocumentoLegal->descripcion;
                $docu->fechaAprobacion = $ley->fecha_aprobacion;
                $docu->fechaPromulgacion = $ley->fecha_promulgacion;
                $docu->numeroDocumento = $ley->numero_documento;
                $docu->archivo = asset('storage/uploads/'.$ley->archivo);
                $comun->data->leyes->push($docu);
            }
            $decretos = $this->documentoLegalService->getDocumentosLegalesPublicarSiAndAcByLimitOfDespachoByTipoDocumentoLiteral($limite,'Decretos');
            foreach ($decretos as $key=>$decreto){
                $docu = new ComunDto();
                $docu->titulo = $decreto->titulo;
                $docu->resumen = $decreto->resumen;
                $docu->contenido = $decreto->contenido;
                $docu->tipo = $decreto->tipoDocumentoLegal->descripcion;
                $docu->fechaAprobacion = $decreto->fecha_aprobacion;
                $docu->fechaPromulgacion = $decreto->fecha_promulgacion;
                $docu->numeroDocumento = $decreto->numero_documento;
                $docu->archivo = asset('storage/uploads/'.$decreto->archivo);
                $comun->data->decretos->push($docu);
            }
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

    public function getTodosDocumentosLegalesDespachoPaginado(Request $request)
    {
        try {
            $limite = 10;
            $orden = 1;
            $search = '';
            $tipo = 'Leyes';
            if ($request->has('limite')){
                $limite = $request->limite;
            }
            if ($request->has('orden')){
                $orden = $request->orden;
            }
            if ($request->has('search')){
                $search = $request->search;
            }
            if ($request->has('tipo')){
                $tipo = $request->tipo;
            }
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Leyes y Decretos Paginados';
            $comun->data = new ComunDto();
            $comun->data = $this->documentoLegalService->getDocumentosLegalesPublicarSiAndAcOfDespachoPaginadoByTipoDocumento($limite,$orden,$search,$tipo);
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

    public function getTodosDocumentosLegalesOfUnidadPaginado($und_id,Request $request)
    {
        try {
            $unidad = $this->unidadService->getById($und_id);
            $limite = 10;
            $orden = 1;
            $search = '';
            $tipo = 'Leyes';
            if ($request->has('limite')){
                $limite = $request->limite;
            }
            if ($request->has('orden')){
                $orden = $request->orden;
            }
            if ($request->has('search')){
                $search = $request->search;
            }
            if ($request->has('tipo')){
                $tipo = $request->tipo;
            }
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = $unidad->nombre;
            $comun->data = new ComunDto();
            $comun->data = $this->documentoLegalService->getDocumentosLegalesPublicarSiAndAcOfUnidadPaginadoByTipoDocumento($und_id,$limite,$orden,$search,$tipo);
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
