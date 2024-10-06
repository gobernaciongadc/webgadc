<?php
namespace App\Http\Controllers;

use App\Models\ServicioPublico;
use App\Services\ParametricaService;
use App\Services\ServicioPublicoService;
use App\Services\UbicacionService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str as Str;
use Image;
use Notification;
use Toastr;

class ServicioPublicoController extends Controller
{
    protected $tipoDocumentoService;
    protected $unidadService;
    protected $documentoService;
    public function __construct(
        UbicacionService $ubicacionService,
        ParametricaService $parametricaService,
        UnidadService $unidadService,
        ServicioPublicoService $servicioPublicoService )
    {
        $this->ubicacionService = $ubicacionService;
        $this->parametricaService = $parametricaService;
        $this->unidadService = $unidadService;
        $this->servicioPublicoService = $servicioPublicoService;
        $this->middleware('auth');
    }

    public function index($und_id,Request $request)
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $publicar = [0=>'NO',1=>'SI'];
        $user = Auth::user();
        $unidad = $this->unidadService->getById($und_id);
        $lista = $this->servicioPublicoService->getAllPaginateBySearchAndSort(10,$und_id);
        return view('serviciopublico.index', compact('lista','und_id','publicar','searchtype', 'search','sort','unidad'));
    }

    public function create($und_id)
    {
        $servicioPublico = new ServicioPublico();
        $servicioPublico->sep_id = 0;
        $servicioPublico->estado = 'AC';
        $listaUbicaciones = $this->ubicacionService->getComboUbicacion();

        return view('serviciopublico.createedit',compact('servicioPublico','listaUbicaciones','und_id'));
    }

    public function edit($sep_id,$und_id)
    {
        $servicioPublico = $this->servicioPublicoService->getById($sep_id);
        $listaUbicaciones = $this->ubicacionService->getComboUbicacion();
        return view('serviciopublico.createedit',compact('servicioPublico','listaUbicaciones','und_id','sep_id'));
    }

    public  function store(Request $request)
    {
        $user = Auth::user();
        $tamImagenOrganigrama = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-22");
        $xoganigra = $tamImagenOrganigrama->valor2;
        $yoganigra = $tamImagenOrganigrama->valor3;
        $data = $request->except('_token');
        $data['usr_id'] = $user->id;
        $ruta = storage_path('app/public/uploads/');
        if($request->sep_id == 0 ) {
            $data['publicar'] = 1;
            $data['fecha_registro'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido',
                'descripcion.required' => 'El campo descripcion es requerido',
                'horario_atencion.required' => 'El campo horario atencion es requerido',
                'costo_base.required' => 'El campo costo base es requerido',
                'imagenes.required' => 'Las Imagens son requeridas',
                'imagenes.*.max' => 'El peso de cada imagen no debe ser mayor a 4 Mb.',
            ];
            $validator = Validator::make($data, [
                'nombre' => 'required',
                'descripcion' => 'required',
                'horario_atencion' => 'required',
                'costo_base' => 'required',
                'imagenes'=>'required',
                'imagenes.*' => 'mimes:jpeg,jpg,JPEG,JPG|max:4000'
            ], $messages);

            //control SLUG
            $data['slug'] = Str::slug($data['nombre']);
            $existe = $this->servicioPublicoService->existeSlug($data['slug']);
            if ($existe){
                $validator->errors()->add('nombre', 'El nombre del servicio publico ya existe, ingrese uno nuevo por favor');
                return back()->withErrors($validator)->withInput();
            }

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            /*if ($request->hasFile('imagen')) {
                $file = $request->imagen;
                $extencionImagen = $file->extension();
                $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                $data['imagen'] = $nombreUno;
                $imagenUno =Image::make($file);
                $imagenUno->resize($xoganigra,$yoganigra);
                $imagenUno->save($ruta.$nombreUno,95);
            }*/

            $fecha_aprobacion = str_replace('/','-',$request->fecha_aprobacion);
            $data['fecha_aprobacion'] = date('Y-m-d', strtotime($fecha_aprobacion));

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

            try {
                $servicioPublico = $this->servicioPublicoService->save($data);
                if (empty($servicioPublico)) {
                    Toastr::warning('No se pudo guardar el servicio publico ',"");
                    return back()->withInput();
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/serviciopublico/'.$data['und_id'].'/lista');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar el servicio publico',"");
                return back()->withInput();
            }
        }else{
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido',
                'descripcion.required' => 'El campo descripcion es requerido',
                'horario_atencion.required' => 'El campo horario atencion es requerido',
                'costo_base.required' => 'El campo costo base es requerido'
            ];
            $validator = Validator::make($data, [
                'nombre' => 'required',
                'descripcion' => 'required',
                'horario_atencion' => 'required',
                'costo_base' => 'required'
            ], $messages);

            //control SLUG
            $data['slug'] = Str::slug($data['nombre']);
            $existe = $this->servicioPublicoService->existeSlugById($data['sep_id'],$data['slug']);
            if ($existe){
                $validator->errors()->add('nombre', 'El nombre del servicio publico ya existe, ingrese uno nuevo por favor');
                return back()->withErrors($validator)->withInput();
            }

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

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

            try {
                $servicioPublico = $this->servicioPublicoService->update($data);
                if (empty($servicioPublico)) {
                    Toastr::warning('No se pudo editar el servicio publico ',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/serviciopublico/'.$data['und_id'].'/lista');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar el servicio publico',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $data = array();
            $data['sep_id'] = $request->sep_id;
            $data['estado'] = 'EL';
            $servioPublico = $this->servicioPublicoService->delete($data);

            if (!empty($servioPublico)){
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
                'mensaje' => 'No se encontro el servicio publico'
            ]);
        }
    }

    public function _cambiarPublicar(Request $request)
    {
        try {
            $data = array();
            $data['sep_id'] = $request->sep_id;
            $data['publicar'] = $request->publicar;
            $servioPublico = $this->servicioPublicoService->cambiarPublicar($data);

            if (!empty($servioPublico)){
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
            $data['sei_id'] = $request->sei_id;
            $data['estado'] = 'EL';
            $programa = $this->servicioPublicoService->eliminarServicioImagen($data);
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
