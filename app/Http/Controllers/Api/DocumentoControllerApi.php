<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use App\Models\ModelsDto\ComunDto;
use App\Services\DocumentoService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DocumentoControllerApi extends Controller
{
    protected $documentoService;
    protected $unidadService;
    public function __construct(
        DocumentoService $documentoService,
        UnidadService $unidadService
    ) {
        $this->documentoService = $documentoService;
        $this->unidadService = $unidadService;
    }

    public function getTodosDocumentosOfUnidadPaginado($und_id, Request $request)
    {
        try {
            $unidad = $this->unidadService->getById($und_id);
            $limite = 10;
            $orden = 1;
            $search = '';
            $tipo = 'Reglamentos';
            if ($request->has('limite')) {
                $limite = $request->limite;
            }
            if ($request->has('orden')) {
                $orden = $request->orden;
            }
            if ($request->has('search')) {
                $search = $request->search;
            }
            if ($request->has('tipo')) {
                $tipo = $request->tipo;
            }
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = $unidad->nombre;
            $comun->data = new ComunDto();
            $comun->data = $this->documentoService->getDocumentosPublicarSiAndAcOfUnidadPaginadoByTipoDocumento($und_id, $limite, $orden, $search, $tipo);
            return response()->json($comun->toArray(), 200);
        } catch (\Exception $e) {
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(), 200);
        }
    }

    // Codigo  por David Salinas Poma-UGE
    public function getDocumentosOfUnidadPaginado($und_id, Request $request)
    {
        $unidad = $this->unidadService->getById($und_id);
        // 1.-Saca Todas las reuniones sin ecepxion
        // $documento = Documento::orderBy('doc_id', 'DESC')->paginate(10);
        // $data = array(
        //     'code' => 200,
        //     'status' => 'success',
        //     'documento' => $documento
        // );
        // return response()->json($data, $data['code']);

        $comun = new ComunDto();
        $comun->status = true;
        $comun->message = $unidad->nombre;
        $comun->data = new ComunDto();
        $comun->data = Documento::orderBy('doc_id', 'DESC')->paginate(10);
        return response()->json($comun->toArray(), 200);
    }
    // Codigo  por David Salinas Poma-UGE
}
