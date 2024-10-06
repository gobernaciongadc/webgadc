<?php
namespace App\Http\Controllers;

use App\Models\Biografia;
use App\Models\PreguntaFrecuente;
use App\Services\ParametricaService;
use App\Services\PreguntaFrecuenteService;
use Illuminate\Http\Request;
use App\Services\BiografiaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

class PreguntaFrecuenteController extends Controller
{
    protected $preguntaFrecuenteService;
    protected $parametricaService;
    public function __construct(
        PreguntaFrecuenteService $preguntaFrecuenteService,
        ParametricaService $parametricaService
    )
    {
        $this->preguntaFrecuenteService = $preguntaFrecuenteService;
        $this->parametricaService = $parametricaService;
        $this->middleware('auth');
    }

    public function index()
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $publicar = [0=>'NO',1=>'SI'];
        $lista = $this->preguntaFrecuenteService->getAllPaginateBySearchAndSort(10);
        return view('preguntafrecuente.index', compact('lista','searchtype','search','sort','publicar'));
    }

    public function create()
    {
        $preguntafrecuente = new PreguntaFrecuente();
        $preguntafrecuente->prf_id = 0;
        $preguntafrecuente->estado = 'AC';
        return view('preguntafrecuente.createedit', compact('preguntafrecuente'));
    }

    public function edit($prf_id)
    {
        $preguntafrecuente = $this->preguntaFrecuenteService->getById($prf_id);
        return view('preguntafrecuente.createedit', compact('preguntafrecuente'));

    }

    public  function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->except('_token');
        $data['usr_id'] = $user->id;
        $ruta = storage_path('app/public/uploads/');
        if($request->prf_id == 0 ) {
            $data['publicar'] = 1;
            $data['fecha_registro'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'pregunta.required' => 'El campo pregunta es requerido.',
                'respuesta.required' => 'El campo respuesta es requerido'
            ];
            $validator = Validator::make($data, [
                'pregunta' => 'required',
                'respuesta' => 'required'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            try {
                $preguntaFrecuente = $this->preguntaFrecuenteService->save($data);
                if (empty($preguntaFrecuente)) {
                    Toastr::warning('No se pudo guardar la pregunta frecuente',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/preguntafrecuente/');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar la pregunta frecuente',"");
                return back()->withInput();
            }
        }else{
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'pregunta.required' => 'El campo pregunta es requerido.',
                'respuesta.required' => 'El campo respuesta es requerido'
            ];
            $validator = Validator::make($data, [
                'pregunta' => 'required',
                'respuesta' => 'required'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            try {
                $preguntaFrecuente = $this->preguntaFrecuenteService->update($data);
                if (empty($preguntaFrecuente)) {
                    Toastr::warning('No se pudo editar la pregunta frecuente',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/preguntafrecuente/');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la pregunta frecuente',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $data = array();
            $data['prf_id'] = $request->prf_id;
            $data['estado'] = 'EL';
            $preguntaFrecuente = $this->preguntaFrecuenteService->delete($data);

            if (!empty($preguntaFrecuente)){
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
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'res' => true,
                'mensaje' => 'No se encontro el producto'
            ]);
        }
    }

    public function _cambiarPublicar(Request $request)
    {
        try {
            $data = array();
            $data['prf_id'] = $request->prf_id;
            $data['publicar'] = $request->publicar;
            $preguntaFrecuente = $this->preguntaFrecuenteService->cambiarPublicar($data);

            if (!empty($preguntaFrecuente)){
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
























}
