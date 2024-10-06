<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PlanesControllerApi extends Controller
{
    protected $planService;
    public function __construct(
        PlanService $planService
    )
    {
        $this->planService = $planService;
    }

    public function planes(Request $request)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Todos los Planes';
            $comun->data = new Collection();
            $planes = $this->planService->getAllPlanesAcPublicarSi();
            foreach($planes as $key=>$plane){
                $plan = new ComunDto();
                $plan->titulo = $plane->titulo;
                $plan->periodo = $plane->periodo;
                $plan->imagen = asset('storage/uploads/'.$plane->imagen);
                $plan->archivo = asset('storage/uploads/'.$plane->link_descarga);
                $comun->data->push($plan);
            }
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = null;
            return response()->json($comun->toArray(),200);
        }
    }

}
