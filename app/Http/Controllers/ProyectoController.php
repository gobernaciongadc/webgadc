<?php
namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Services\ProyectoService;
use App\Services\ParametricaService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Image;
use Notification;
use Toastr;

class ProyectoController extends Controller
{
    protected $proyectoService;
    protected $parametricaService;
    public function __construct(
        ProyectoService $proyectoService,
        UnidadService $unidadService,
        ParametricaService $parametricaService)
    {
        $this->proyectoService = $proyectoService;
        $this->parametricaService = $parametricaService;
        $this->unidadService = $unidadService;
        $this->middleware('auth');
    }

    public function index($und_id,Request $request)
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $publicar = [0=>'NO',1=>'SI'];
        $unidad = $this->unidadService->getById($und_id);
        $lista = $this->proyectoService->getAllPaginateBySearchAndSort(10,$und_id);
        return view('proyecto.index', compact('lista','searchtype','search','sort','publicar','und_id','unidad'));
    }

    public function create($und_id)
    {
        $proyecto = new Proyecto();
        $proyecto->pro_id = 0;
        $proyecto->estado = 'AC';
        return view('proyecto.createedit', compact('proyecto','und_id'));
    }

    public function edit($pro_id,$und_id)
    {
        $proyecto = $this->proyectoService->getById($pro_id);
        return view('proyecto.createedit', compact('proyecto','und_id'));
    }

    public  function store(Request $request)
    {
        $tamImagen = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-8");
        $x = $tamImagen->valor2;
        $y = $tamImagen->valor3;
        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        $user = Auth::user();
        if($request->pro_id == 0 ) {
            $data['fecha_registro'] = date('Y-m-d H:i:s');
            $data['publicar'] = 1;
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido',
                'descripcion.required' => 'El campo descripcion es requerido',
                'inversion.required' => 'El campo inversion es requerido',
                'imagenes.required' => 'Las Imagens son requeridas',
                'imagenes.*.max' => 'El peso de cada imagen no debe ser mayor a 4 Mb.',
            ];
            $validator = Validator::make($data, [
                'nombre' => 'required',
                'descripcion' => 'required',
                'inversion' => 'required',
                'imagenes'=>'required',
                'imagenes.*' => 'mimes:jpeg,jpg,JPEG,JPG|max:4000'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('imagenes')) {
                $files = $request->file('imagenes');
                $datoIma = array();
                foreach($files as $key2=>$file) {
                    $extencionImagen = $file->extension();
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    $imagenUno =Image::make($file);
                    $imagenUno->resize(600,600);
                    $imagenUno->save($ruta.$nombreUno,95);
                    $datoIma2 = array();
                    $datoIma2['titulo'] = 'a'.$key2;
                    $datoIma2['descripcion'] = 'b'.$key2;
                    $datoIma2['imagen'] = $nombreUno;
                    $datoIma2['publicar'] = 1;
                    $datoIma2['estado'] = 'AC';
                    $datoIma2['tipo_imagen'] = 8;
                    $datoIma2['ancho'] = 600;
                    $datoIma2['alto'] = 600;
                    array_push($datoIma,$datoIma2);
                }
                $data['imagenes'] = $datoIma;
            }

            $data['usr_id'] = $user->id;
            try {
                $proyecto = $this->proyectoService->save($data);
                if (empty($proyecto)) {
                    Toastr::warning('No se pudo guardar el proyecto',"");
                    return back()->withInput();
                }else{
                    Toastr::success('Operación completada',"");
                     return redirect('sisadmin/proyecto/'.$data['und_id'].'/lista');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar el proyecto',"");
                return back()->withInput();
            }
        }else{
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $data['usr_id'] = $user->id;
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido',
                'descripcion.required' => 'El campo descripcion es requerido',
                'inversion.required' => 'El campo inversion es requerido',

            ];
            $validator = Validator::make($data, [
                'nombre' => 'required',
                'descripcion' => 'required',
                'inversion' => 'required'
            ], $messages);


            if ($request->hasFile('imagenes')) {

                $messages = [ 'imagenes.*.max' => 'El peso de cada imagen no debe ser mayor a 4 Mb.',  ];
                $validator = Validator::make($data, ['imagenes.*' => 'mimes:jpeg,jpg,JPEG,JPG|max:4000' ], $messages);
                if ($validator->fails()){
                    Toastr::warning('No se pudo guardar ningun cambio verifique las imagenes', "");
                    return back()->withErrors($validator)->withInput();
                }
                $files = $request->file('imagenes');
                $datoIma = array();
                foreach($files as $key2=>$file) {
                    $extencionImagen = $file->extension();
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    $imagenUno =Image::make($file);
                    $imagenUno->resize(600,600);
                    $imagenUno->save($ruta.$nombreUno,95);
                    $datoIma2 = array();
                    $datoIma2['titulo'] = 'a'.$key2;
                    $datoIma2['descripcion'] = 'b'.$key2;
                    $datoIma2['imagen'] = $nombreUno;
                    $datoIma2['publicar'] = 1;
                    $datoIma2['estado'] = 'AC';
                    $datoIma2['tipo_imagen'] = 8;
                    $datoIma2['ancho'] = 600;
                    $datoIma2['alto'] = 600;
                    array_push($datoIma,$datoIma2);
                }
                $data['imagenes'] = $datoIma;
            }

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            try {
                $proyecto = $this->proyectoService->update($data);
                if (empty($proyecto)) {
                    Toastr::warning('No se pudo editar el proyecto',"");
                    return back()->withInput();
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/proyecto/'.$data['und_id'].'/lista');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar el proyecto',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $data = array();
            $data['pro_id'] = $request->pro_id;
            $data['estado'] = 'EL';
            $proyecto = $this->proyectoService->delete($data);

            if (!empty($proyecto)){
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
                'mensaje' => 'No se encontro el proyectos'
            ]);
        }
    }

    public function _cambiarPublicar(Request $request)
    {
        try {
            $data = array();
            $data['pro_id'] = $request->pro_id;
            $data['publicar'] = $request->publicar;
            $proyecto = $this->proyectoService->cambiarPublicar($data);

            if (!empty($proyecto)){
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

    public function _quitarImagen(Request $request)
    {
        try {
            $data = array();
            $data['poi_id'] = $request->poi_id;
            $data['estado'] = 'EL';
            $programa = $this->proyectoService->eliminarProyectoImagen($data);
            if (!empty($programa)){
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
                'res' => false,
                'mensaje' => 'No se pudo modificar el dato'
            ]);
        }
    }

}
