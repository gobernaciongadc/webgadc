<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\PreguntaFrecuenteService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PreguntasFrecuentesControllerApi extends Controller
{
    protected $preguntaFrecuenteService;
    public function __construct(
        PreguntaFrecuenteService $preguntaFrecuenteService
    )
    {
        $this->preguntaFrecuenteService = $preguntaFrecuenteService;
    }

    public function getAllPreguntas()
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Todas las Preguntas Frecuentes';
            $comun->data = new Collection();
            $preguntas = $this->preguntaFrecuenteService->getAllPreguntasAcAndPublicarSi();
            foreach ($preguntas as $key=>$pregunta){
                $pre = new ComunDto();
                $pre->pregunta = $pregunta->pregunta;
                $pre->respuesta = $pregunta->respuesta;
                $comun->data->push($pre);
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
