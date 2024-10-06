<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\HoyHistoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class HoyHistoriaControllerApi extends Controller
{
    protected $hoyHistoriaService;
    public function __construct(HoyHistoriaService $hoyHistoriaService)
    {
        $this->hoyHistoriaService = $hoyHistoriaService;
    }

    public function hoyHistoria(Request $request)
    {
        try {
            $fechaActual = date('Y-m-d');
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Hoy en la Historia';
            $comun->data = new Collection();
            $historias = $this->hoyHistoriaService->getAllHistoriasAcAndPublicarSiByFecha($fechaActual);
            foreach ($historias as $key=>$historia){
                $histo = new ComunDto();
                $histo->fecha = $historia->fecha;
                $histo->titulo = $historia->titulo;
                $histo->imagen = asset('storage/uploads/'.$historia->imagen);
                $histo->acontecimiento = $historia->acontecimiento;
                $comun->data->push($histo);
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

}
