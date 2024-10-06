<?php
namespace App\Http\Controllers;

use App\Services\UnidadService;
use App\Services\VideoSonidoService;
use App\Models\VideoSonido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

class VideoSonidoController extends Controller
{
    protected $videoSonidoService;
    protected $unidadService;
    public function __construct(
        VideoSonidoService $videoSonidoService,
        UnidadService $unidadService)
    {
        $this->videoSonidoService = $videoSonidoService;
        $this->unidadService = $unidadService;
        $this->middleware('auth');
    }

    public function index($und_id)
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $publicar = [0=>'NO',1=>'SI'];
        $unidad = $this->unidadService->getById($und_id);
        $titulo = $unidad->nombre;
        $lista = $this->videoSonidoService->getAllPaginateBySearchAndSort(10,$und_id);
        return view('videosonido.index', compact('lista', 'titulo','und_id','publicar','searchtype', 'search','sort','unidad'));
    }

    public function create($und_id)
    {
        $videoSonido = new VideoSonido();
        $videoSonido->vis_id = 0;
        $videoSonido->estado = 'AC';
        return view('videosonido.createedit',compact('videoSonido','und_id'));
    }

    public function edit($vis_id,$und_id)
    {
        $videoSonido = $this->videoSonidoService->getById($vis_id);
        return view('videosonido.createedit',compact('videoSonido','und_id','vis_id'));
    }

    public  function store(Request $request)
    {
        $data = $request->except('_token');
        if($request->vis_id == 0 ) {
          $data['publicar'] = 1;
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'descripcion.required' => 'El campo descripcion es requerido',
                'link_descarga.required' => 'El campo link_descarga es requerido',
                'link_descarga.url' => 'El formato de la Url(Link descarga) no es el correcto.'
            ];
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'descripcion' => 'required',
                'link_descarga' => 'required|url'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            $fecha_a = str_replace('/','-',$request->fecha);
            $data['fecha'] = date('Y-m-d', strtotime($fecha_a));
            try {
                $videoSonido = $this->videoSonidoService->save($data);
                if (empty($videoSonido)) {
                    Toastr::warning('No se pudo guardar el video sonido',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/videosonido/'.$data['und_id']);

                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar el video sonido',"");
                return back()->withInput();
            }
        }else{
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'descripcion.required' => 'El campo descripcion es requerido',
                'link_descarga.required' => 'El campo link_descarga es requerido',
                'link_descarga.url' => 'El formato de la Url(Link descarga) no es el correcto.'
            ];
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'descripcion' => 'required',
                'link_descarga' => 'required',
                'link_descarga' => 'required|url'
            ], $messages);

            $fecha_a = str_replace('/','-',$request->fecha);
            $data['fecha'] = date('Y-m-d', strtotime($fecha_a));
            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            try {
                $videoSonido = $this->videoSonidoService->update($data);
                if (empty($videoSonido)) {
                    Toastr::warning('No se pudo editar el video sonido',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/videosonido/'.$data['und_id']);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar el video sonido',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $data = array();
            $data['vis_id'] = $request->vis_id;
            $data['estado'] = 'EL';
            $videosonido = $this->videoSonidoService->delete($data);

            if (!empty($videosonido)){
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
                'mensaje' => 'No se encontro el video o sonido'
            ]);
        }
    }

    public function _cambiarPublicar(Request $request)
    {
        try {
            $data = array();
            $data['vis_id'] = $request->vis_id;
            $data['publicar'] = $request->publicar;
            $videoSonido = $this->videoSonidoService->cambiarPublicar($data);

            if (!empty($videoSonido)){
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
