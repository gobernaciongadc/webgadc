<?php
namespace App\Http\Controllers;

use App\Models\Biografia;
use App\Services\ParametricaService;
use Illuminate\Http\Request;
use App\Services\BiografiaService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

class BiografiaController extends Controller
{
    protected $biografiaService;
    protected $parametricaService;
    public function __construct(
        BiografiaService $biografiaService,
        ParametricaService $parametricaService
    )
    {
        $this->biografiaService = $biografiaService;
        $this->parametricaService = $parametricaService;
        $this->middleware('auth');
    }

    public function index()
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $ruta = 'unidadservicio';
        $lista = $this->biografiaService->getAllPaginateBySearchAndSort(10);
        return view('biografia.index', compact('lista','searchtype','search','sort','ruta'));
    }

    public function create()
    {
   		$biografia = new Biografia();
   		$biografia->bio_id = 0;
   		$biografia->estado = 'AC';
		return view('biografia.createedit', compact('biografia'));
    }

    public function edit($bio_id)
    {
        $biografia = $this->biografiaService->getById($bio_id);
        return view('biografia.createedit', compact('biografia'));
    }

    public  function store(Request $request)
    {
        $tamImagenOrganigrama = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-8");
        $xoganigra = $tamImagenOrganigrama->valor2;
        $yoganigra = $tamImagenOrganigrama->valor3;
        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');

     if($request->bio_id == 0 ) {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombres.required' => 'El campo nombre es requerido',
                'apellidos.required' => 'El campo apellido es requerido',
                'profesion.required' => 'El campo profesion es requerido',
                'resenia.required' => 'El campo reseña es requerido',
                'imagen_foto.max' => 'El peso de la imagen_foto no debe ser mayor a 4000 kilobytes'
            ];
            $validator = Validator::make($data, [
                'nombres' => 'required',
                'apellidos' => 'required',
                'profesion' => 'required',
                'resenia' => 'required',
                'imagen_foto' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            if ($request->hasFile('imagen_foto')) {
                $file = $request->imagen_foto;
                $extencionImagen = $file->extension();
                $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                $data['imagen_foto'] = $nombreUno;
                $imagenUno =Image::make($file);
                $imagenUno->resize($xoganigra,$yoganigra);
                $imagenUno->save($ruta.$nombreUno,95);
            }
            try {
                $biografia = $this->biografiaService->save($data);
                if (empty($biografia)) {
                    Toastr::warning('No se pudo guardar la biografia',"");
                    return back()->withInput();
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/biografia/');
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar la biografia',"");
                return back()->withInput();
            }
        }else{
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombres.required' => 'El campo nombre es requerido',
                'apellidos.required' => 'El campo apellido es requerido',
                'profesion.required' => 'El campo profesion es requerido',
                'resenia.required' => 'El campo reseña es requerido'
            ];
            $validator = Validator::make($data, [
                'nombres' => 'required',
                'apellidos' => 'required',
                'profesion' => 'required',
                'resenia' => 'required'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('imagen_foto')) {
                $messages = [ 'imagen_foto.max' => 'El peso de la imagen foto no debe ser mayor a 4000 kilobytes'  ];
                $validator = Validator::make($data, ['imagen_foto' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000' ], $messages);
                if ($validator->fails()){
                    Toastr::warning('No se pudo guardar ningun cambio verifique la imagen', "");
                    return back()->withErrors($validator)->withInput();
                }
                $file = $request->imagen_foto;
                $extencionImagen = $file->extension();
                $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                $data['imagen_foto'] = $nombreUno;
                $imagenUno =Image::make($file);
                $imagenUno->resize($xoganigra,$yoganigra);
                $imagenUno->save($ruta.$nombreUno,95);
            }

            try {
                $biografia = $this->biografiaService->update($data);
                if (empty($biografia)) {
                    Toastr::warning('No se pudo editar la biografia',"");
                    return back()->withInput();
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/biografia/');
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la biografia',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $data = array();
            $data['bio_id'] = $request->bio_id;
            $data['estado'] = 'EL';
            $biografia = $this->biografiaService->delete($data);

            if (!empty($biografia)){
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

}
