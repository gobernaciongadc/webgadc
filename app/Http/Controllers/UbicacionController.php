<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use App\Models\Unidad;
use App\Services\ParametricaService;
use App\Services\UbicacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

class UbicacionController extends Controller
{
    protected $biografiaService;
    protected $parametricaService;
    public function __construct(
        UbicacionService $ubicacionService,
        ParametricaService $parametricaService
    )
    {
        $this->ubicacionService = $ubicacionService;
        $this->parametricaService = $parametricaService;
        $this->middleware('auth');
    }
    public function index()
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $lista = $this->ubicacionService->getAllPaginateBySearchAndSort(10);

        return view('ubicacion.index', compact('lista','searchtype','search','sort'));
    }

    public function create()
    {
        $ubicacion = new Ubicacion();
        $ubicacion->ubi_id = 0;
        $ubicacion->estado = 'AC';
        $param = $this->parametricaService->getParametricaByTipoAndCodigo("ZOOM-PRODUCTOR-MAPA-1");
        $ubicacion->latitud = $param->valor2;
        $ubicacion->longitud = $param->valor3;
        return view('ubicacion.createedit', compact('ubicacion'));
    }

    public function edit($ubi_id)
    {
        $ubicacion = $this->ubicacionService->getById($ubi_id);
        return view('ubicacion.createedit', compact('ubicacion'));

    }

    public  function store(Request $request)
    {
        $user = Auth::user();
        $tamImagen = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-8");
        $xoganigra = $tamImagen->valor2;
        $yoganigra = $tamImagen->valor3;
        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');

        if($request->ubi_id == 0 ) {
            $data['usr_id'] = $user->id;
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'unidad.required' => 'El campo unidad es requerido',
                'lugar.required' => 'El campo lugar es requerido',
                'direccion.required' => 'El campo direccion es requerido',
                'imagen.max' => 'El peso de la imagen no debe ser mayor a 4000 kilobytes'
            ];
            $validator = Validator::make($data, [
                'unidad' => 'required',
                'lugar' => 'required',
                'direccion' => 'required',
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
                $imagenUno->resize($xoganigra,$yoganigra);
                $imagenUno->save($ruta.$nombreUno,95);
            }
            try {
                $ubicacion = $this->ubicacionService->save($data);
                if (empty($ubicacion)) {
                    Toastr::warning('No se pudo guardar la ubicacion',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/ubicacion/');

                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar la ubicacion',"");
                return back()->withInput();
            }
        }else{
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'unidad.required' => 'El campo unidad es requerido',
                'lugar.required' => 'El campo lugar es requerido',
                'direccion.required' => 'El campo direccion es requerido',
            ];
            $validator = Validator::make($data, [
                'unidad' => 'required',
                'lugar' => 'required',
                'direccion' => 'required',
            ], $messages);


            if ($request->hasFile('imagen')) {
                $messages = [ 'imagen.max' => 'El peso de la imagen no debe ser mayor a 4000 kilobytes'  ];
                $validator = Validator::make($data, ['imagen' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000' ], $messages);
                if ($validator->fails()){
                    Toastr::warning('No se pudo guardar ningun cambio verifique la imagene', "");
                    return back()->withErrors($validator)->withInput();
                }
                $file = $request->imagen;
                $extencionImagen = $file->extension();
                $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                $data['imagen'] = $nombreUno;
                $imagenUno =Image::make($file);
                $imagenUno->resize($xoganigra,$yoganigra);
                $imagenUno->save($ruta.$nombreUno,95);
            }

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            try {
                $ubicacion = $this->ubicacionService->update($data);
                if (empty($ubicacion)) {
                    Toastr::warning('No se pudo editar la ubicacion',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/ubicacion/');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la ubicacion',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $data = array();
            $data['ubi_id'] = $request->ubi_id;
            $data['estado'] = 'EL';
            $ubicacion = $this->ubicacionService->delete($data);

            if (!empty($ubicacion)){
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
                'mensaje' => 'No se encontro la ubicacion'
            ]);
        }
    }
}
