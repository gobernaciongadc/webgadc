<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\AgendaOficialService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AgendaOficialControllerApi extends Controller
{
    protected $agendaOficialService;
    public function __construct(AgendaOficialService $agendaOficialService)
    {
        $this->agendaOficialService = $agendaOficialService;
    }

    public function agendaOficial(Request $request)
    {
        try {
            $fechaActual = date('Y-m-d');
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Agenda Oficial';
            $comun->data = new ComunDto();
            $agenda = $this->agendaOficialService->getAgendaOficialAcAndPublicarSiByFecha($fechaActual);
            if (!empty($agenda)){
                $comun->data->fecha = $agenda->fecha;
                $comun->data->archivo = asset('storage/uploads/'.$agenda->archivo);
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
