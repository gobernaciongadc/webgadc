<?php
namespace App\Http\Controllers;

use App\Models\HoyHistoria;
use App\Services\HoyHistoriaService;
use App\Services\ParametricaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Image;
use Notification;
use Toastr;

class HoyHistoriaController extends Controller
{
    protected $biografiaService;
    protected $parametricaService;
    public function __construct(
        HoyHistoriaService $hoyHistoriaService,
        ParametricaService $parametricaService
    )
    {
        $this->hoyHistoriaService = $hoyHistoriaService;
        $this->parametricaService = $parametricaService;
        $this->middleware('auth');
    }
    public function index()
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $publicar = [0=>'NO',1=>'SI'];
        $lista = $this->hoyHistoriaService->getAllPaginateBySearchAndSort(10);
        return view('hoyhistoria.index', compact('lista','searchtype','search','sort','publicar'));
    }

    public function create()
    {
        $hoyHistoria = new HoyHistoria();
        $hoyHistoria->hoh_id = 0;
        $hoyHistoria->estado = 'AC';
        return view('hoyhistoria.createedit', compact('hoyHistoria'));
    }

    public function edit($hoh_id)
    {
        $hoyHistoria = $this->hoyHistoriaService->getById($hoh_id);
        return view('hoyhistoria.createedit', compact('hoyHistoria'));
    }

    public  function store(Request $request)
    {
        $tamImagen = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-8");
        $x = $tamImagen->valor2;
        $y = $tamImagen->valor3;
        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        $user = Auth::user();
        if($request->hoh_id == 0 ) {
            $data['fecha_registro'] = date('Y-m-d H:i:s');
            $data['publicar'] = 1;
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'acontecimiento.required' => 'El campo acontecimiento es requerido',
                'fecha.required' => 'El campo fecha es requerido',
                'imagen.max' => 'El peso de la imagen no debe ser mayor a 4000 kilobytes'
            ];
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'acontecimiento' => 'required',
                'fecha' => 'required',
                'imagen' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            if ($request->hasFile('imagen')) {
                $file = $request->imagen;
                $extencionImagen = $file->extension();
                $nombreUno = time().''.uniqid().'.'.$extencionImagen;   
                $data['imagen'] = $nombreUno;
                $imagenUno =Image::make($file);
                $imagenUno->resize($x,$y);
                $imagenUno->save($ruta.$nombreUno,95);
            }
            $data['fecha'] = str_replace('/','-',$data['fecha']);
            $data['fecha'] = date('Y-m-d',strtotime($data['fecha']));
            $data['usr_id'] = $user->id;
            try {
                $hoyHistoria = $this->hoyHistoriaService->save($data);
                if (empty($hoyHistoria)) {
                    Toastr::warning('No se pudo guardar hoy en la historia',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/hoyhistoria/');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar hoy en la historia',"");
                return back()->withInput();
            }
        }else{
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $data['usr_id'] = $user->id;
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'titulo.required' => 'El campo titulo es requerido',
                'acontecimiento.required' => 'El campo acontecimiento es requerido',
                'fecha.required' => 'El campo fecha es requerido',
            ];  
            $validator = Validator::make($data, [
                'titulo' => 'required',
                'acontecimiento' => 'required',
                'fecha' => 'required'
            ], $messages);  


            if ($request->hasFile('imagen')) {
                $messages = [ 'imagen.max' => 'El peso de la imagen no debe ser mayor a 4000 kilobytes'  ];
                $validator = Validator::make($data, ['imagen' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000' ], $messages);
                if ($validator->fails()){
                    Toastr::warning('No se pudo guardar ningun cambio verifique la imagen', "");
                    return back()->withErrors($validator)->withInput();
                }
                $file = $request->imagen;
                $extencionImagen = $file->extension();
                $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                $data['imagen'] = $nombreUno;
                $imagenUno =Image::make($file);
                $imagenUno->resize($x,$y);
                $imagenUno->save($ruta.$nombreUno,95);

            }

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            
            $data['fecha'] = str_replace('/','-',$data['fecha']);
            $data['fecha'] = date('Y-m-d',strtotime($data['fecha']));

            try {
                $hoyHistoria = $this->hoyHistoriaService->update($data);
                if (empty($hoyHistoria)) {
                    Toastr::warning('No se pudo editar hoy en la historia',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/hoyhistoria/');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar hoy en la historia',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $data = array();
            $data['hoh_id'] = $request->hoh_id;
            $data['estado'] = 'EL';
            $hoyHistoria = $this->hoyHistoriaService->delete($data);

            if (!empty($hoyHistoria)){
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
                'mensaje' => 'No se encontro la biografia'
            ]);
        }
    }

    public function _cambiarPublicar(Request $request)
    {
        try {
            $data = array();
            $data['hoh_id'] = $request->hoh_id;
            $data['publicar'] = $request->publicar;
            $hoyHistoria = $this->hoyHistoriaService->cambiarPublicar($data);

            if (!empty($hoyHistoria)){
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
