<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelsDto\ComunDto;
use App\Services\PreguntaService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EncuestaControllerApi extends Controller
{
    protected $preguntaService;
    public function __construct(
        PreguntaService $preguntaService
    )
    {
        $this->preguntaService = $preguntaService;
    }

    public function getEncuesta(Request $request)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Get Encuesta';
            $comun->data = new ComunDto();
            $comun->data->respuestas = new Collection();
            //primero obtenemos un identificador unico para el usuario
            $identificadorUsuario = $request->ip().''.$request->header('User-Agent');
            //ahora buscamos la pregunta actual
            $pregunta = $this->preguntaService->getUltimaPregunta();

            if(!empty($pregunta)){
                $opciones = $this->preguntaService->getOpcionesByPreguntaOrdenado($pregunta->pre_id);
                if(!empty($opciones)){
                    //ahora debemos buscar si el usuario ya respondio  a la pregunta
                    $respuesta = $this->preguntaService->getRespuestaCliente($identificadorUsuario,$pregunta->pre_id);
                    $editar = false;
                    $ops_id_res = 0;
                    if (!empty($respuesta)){
                        $editar = true;
                        $ops_id_res = $respuesta->ops_id;
                    }
                    $comun->data->preId = $pregunta->pre_id;
                    $comun->data->pregunta = $pregunta->pregunta;
                    $comun->data->editar = $editar;
                    foreach ($opciones as $key=>$opcion){
                        $ops = new ComunDto();
                        $ops->opsId = $opcion->ops_id;
                        $ops->texto = $opcion->texto_respuesta;
                        $ops->respuesta = $opcion->ops_id == $ops_id_res?true:false;
                        $comun->data->respuestas->push($ops);
                    }
                }
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

    public function getResultadosEncuesta(Request $request)
    {
        try {
            $comun = new ComunDto();
            $comun->status = true;
            $comun->message = 'Get Resultados Encuesta';
            $comun->data = new ComunDto();
            $comun->data->respuestas = new Collection();

            $pregunta = $this->preguntaService->getUltimaPregunta();
            if (!empty($pregunta)){
                $opciones = $this->preguntaService->getOpcionesByPreguntaOrdenado($pregunta->pre_id);
                $respuestas = $this->preguntaService->getRespuestasByPreguntaId($pregunta->pre_id);
                if (!empty($opciones) && !empty($respuestas)){
                    $cantidadRespuestas = count($respuestas);
                    $comun->data->preId = $pregunta->pre_id;
                    $comun->data->pregunta = $pregunta->pregunta;
                    foreach ($opciones as $key=>$opcion){
                        $ops = new ComunDto();
                        $ops->opsId = $opcion->ops_id;
                        $ops->texto = $opcion->texto_respuesta;
                        $cantidad = $this->getCantidadRespuestasThisOpcion($respuestas,$opcion->ops_id);
                        $porcentaje = 0;
                        if ($cantidad>0 && $cantidadRespuestas>0){
                            $porcentaje = round((($cantidad/$cantidadRespuestas)*100),2);
                        }
                        $ops->cantidad = $cantidad;
                        $ops->porcentaje = $porcentaje;
                        $comun->data->respuestas->push($ops);
                    }
                }
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

    private function getCantidadRespuestasThisOpcion($respuestas,$ops_id)
    {
        $res = 0;
        foreach ($respuestas as $k=>$respuesta){
            if ($respuesta->ops_id == $ops_id){
                $res++;
            }
        }
        return $res;
    }

    public function storeEncuesta(Request $request)
    {
        try {
            $comun = new ComunDto();
            //primero obtenemos un identificador unico para el usuario
            $identificadorUsuario = $request->ip().''.$request->header('User-Agent');
            $respuesta = $this->preguntaService->getRespuestaCliente($identificadorUsuario,$request->preId);
            $respuestaGuardada = null;
            if (empty($respuesta)){
                $data = array(
                    'ip_terminal'=>$identificadorUsuario,
                    'fecha'=>date('Y-m-d'),
                    'estado'=>'AC',
                    'pre_id'=>$request->preId,
                    'ops_id'=>$request->opsId
                );
                $respuestaGuardada = $this->preguntaService->storeRespuesta($data);
            }else{
                $respuesta->fecha = date('Y-m-d');
                $respuesta->pre_id = $request->preId;
                $respuesta->ops_id = $request->opsId;
                $respuestaGuardada = $this->preguntaService->updateRespuesta($respuesta);
            }
            if (empty($respuestaGuardada)){
                $comun->status = false;
                $comun->message = 'No se pudo guardar la encuesta';
                $comun->data = new ComunDto();
                return response()->json($comun->toArray(),200);
            }else{
                $comun->status = true;
                $comun->message = 'Encuesta Guardada Correctamente';
                $comun->data = new ComunDto();
                return response()->json($comun->toArray(),200);
            }
        }catch (\Exception $e){
            $comun = new ComunDto();
            $comun->status = false;
            $comun->message = $e->getMessage();
            $comun->data = new Collection();
            return response()->json($comun->toArray(),200);
        }
    }

}
