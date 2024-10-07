<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\ImagenUnidadGaleriaService;
use App\Services\UnidadService;
use App\Services\VideoSonidoService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SemanarioControllerApi extends Controller
{

    protected $videoSonidoService;
    protected $imagenUnidadGaleriaService;
    protected $unidadService;
    public function __construct(
        VideoSonidoService $videoSonidoService
    ) {
        $this->videoSonidoService = $videoSonidoService;
    }

    public function getSemanariosPaginado(Request $request)
    {
        try {
            $limite = 10;
            $orden = 1;
            if ($request->has('limite')) {
                $limite = $request->limite;
            }
            if ($request->has('orden')) {
                $orden = $request->orden;
            }
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Seminarios paginado';
            $comun->bgImage = asset('storage/uploads/');
            $comun->data = new ComunDto();
            $comun->data = $this->videoSonidoService->getAllSemanariosPaginateAndSort($limite, $orden);
            return response()->json($comun->toArray(), 200);
        } catch (\Exception $e) {
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(), 200);
        }
    }
}
