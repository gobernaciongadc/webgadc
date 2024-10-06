<?php
namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\Opcion;
use App\Services\ParametricaService;
use App\Services\OpcionService;
use App\Services\PreguntaService;
use App\Services\PublicidadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Image;
use Notification;
use Toastr;

class PreguntaController extends Controller
{
    private $preguntaService;
    private $opcionService;
    public function __construct(PreguntaService $preguntaService,OpcionService $opcionService)
    {
        $this->preguntaService = $preguntaService;
        $this->opcionService = $opcionService;
        $this->middleware('auth');
    }

    public function index()
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $publicar = [0=>'NO',1=>'SI'];
        $lista = $this->preguntaService->getAllPaginate(10);
        return view('pregunta.index', compact('lista','searchtype','search','sort','publicar'));
    }

    public function resultado($pre_id)
    {
        $resultado = '';
        $Pregunta = $this->preguntaService->getById($pre_id);
        $opciones = new Collection();
        $opciones2 = $this->preguntaService->getOpcionesByPreguntaOrdenado($pre_id);
        $respuestas = $this->preguntaService->getRespuestasByPreguntaId($pre_id);
        $cantidadRespuestas = count($respuestas);

        foreach ($opciones2 as $key=>$opcion){
                $ops = new Opcion();
                $ops->opsId = $opcion->ops_id;
                $ops->texto = $opcion->texto_respuesta;
                $cantidad = $this->getCantidadRespuestasThisOpcion($respuestas,$opcion->ops_id);
                $porcentaje = 0;
                if ($cantidad>0 && $cantidadRespuestas>0){
                    $porcentaje = round((($cantidad/$cantidadRespuestas)*100),2);
                }
                $ops->cantidad = $cantidad;
                $ops->porcentaje = $porcentaje;
                $opciones->push($ops);
        }
        return view('pregunta.resultado', compact('resultado','Pregunta','opciones','cantidadRespuestas'));
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

    public function create()
    {
        $Pregunta = new Pregunta();
        $Pregunta->pre_id = 0;
        $Pregunta->estado = 'AC';
        $pre_id = 0;
        $opciones = array();
        return view('pregunta.createedit',compact('Pregunta','pre_id','opciones'));
    }

    public function edit($pre_id)
    {
        $Pregunta = $this->preguntaService->getById($pre_id);
        $opciones = $this->opcionService->getLista($pre_id);
        return view('pregunta.createedit',compact('Pregunta','pre_id','opciones'));
    }

    public  function store(Request $request)
    {
        $data = $request->except('_token');
        if($request->pre_id == 0 ) {
            $data['publicar'] = 1;
            $data['fecha_registro'] = date('Y-m-d H:i:s');
                $listaNomImagenes = null;
                $i = 0;
                $variable1 = $request->texto_respuesta1;
                $variable2 = $request->texto_respuesta2;
                $variable3 = $request->texto_respuesta3;
                $variable4 = $request->texto_respuesta4;
                $variable5 = $request->texto_respuesta5;
                $variable6 = $request->texto_respuesta6;
                $listaNomImagenes = $variable1.','.$variable2.','.$variable3.','.$variable4.','.$variable5.','.$variable6;
                $data['listaRespuestas'] = $listaNomImagenes;
            try {
                $pregunta = $this->preguntaService->savePreguntaAndOpciones($data);
                if (empty($pregunta)) {
                    Toastr::warning('No se pudo guardar la pregunta',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/pregunta/');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar la pregunta',"");
                return back()->withInput();
            }
        }else{
                $variable1 = $request->texto_respuesta1;
                $variable2 = $request->texto_respuesta2;
                $variable3 = $request->texto_respuesta3;
                $variable4 = $request->texto_respuesta4;
                $variable5 = $request->texto_respuesta5;
                $variable6 = $request->texto_respuesta6;
                $listarespuesta = $variable1.','.$variable2.','.$variable3.','.$variable4.','.$variable5.','.$variable6;
                $data['listaRespuestas'] = $listarespuesta;
                $ops_id1 = $request->ops_id1;
                $ops_id2 = $request->ops_id2;
                $ops_id3 = $request->ops_id3;
                $ops_id4 = $request->ops_id4;
                $ops_id5 = $request->ops_id5;
                $ops_id6 = $request->ops_id6;
                $listOps = $ops_id1.','.$ops_id2.','.$ops_id3.','.$ops_id4.','.$ops_id5.','.$ops_id6;
                $data['listaOpciones'] = $listOps;//dd($data);
            try {
                $pregunta = $this->preguntaService->update($data);
                if (empty($pregunta)) {
                    Toastr::warning('No se pudo guardar la pregunta',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/pregunta/');
                }
            }catch (Exception $e){
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar la pregunta',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
            $pregunta = $this->preguntaService->getById($request->pre_id);
            if (!empty($pregunta)) {
                if($this->preguntaService->delete($pregunta)){
                return response()->json([
                    'res' => true
                ]);
                }else{
                    return response()->json([
                        'res' => false,
                        'mensaje' => 'No se encontro la pregunta'
                    ]);
                }
            }
            return response()->json([
                'res' => false,
                'mensaje' => 'No se encontro la pregunta'
            ]);
    }

    public function _cambiarPublicar(Request $request)
    {
        try {
            $data = array();
            $data['pre_id'] = $request->pre_id;
            $data['publicar'] = $request->publicar;
            $pregunta = $this->preguntaService->cambiarPublicar($data);

            if (!empty($pregunta)){
                return response()->json([
                    'res'=>true,
                    'mensaje'=>'Operación completada'
                ]);
            }else{
                return response()->json([
                    'res'=>false,
                    'mensaje'=>'No se pudo modificar'
                ]);
            }

        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'res'=>false,
                'mensaje'=>'No se pudo modificar'
            ]);
        }
    }

    public function _eliminaropcion(Request $request)
    {
        $Pregunta = $this->preguntaService->getById($request->pre_id);
        $opcion = Opcion::find($request->ops_id);
        $opcion->estado = 'EL';
        $opcion->save();
        $opcion->fresh();
        $opciones = $this->opcionService->getLista($request->pre_id);
        return view('pregunta._tablaopciones',compact('Pregunta','opciones'));
    }




}
