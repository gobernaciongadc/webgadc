<?php
namespace App\Http\Controllers;


use App\Models\Producto;
use App\Services\ParametricaService;
use App\Services\ProductoService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str as Str;
use Image;
use Notification;
use Toastr;

class ProductoController extends Controller
{
    protected $productoService;
    protected $unidadService;
    protected $parametricaService;
    public function __construct(
        ParametricaService $parametricaService,
        UnidadService $unidadService,
        ProductoService $productoService )
    {
        $this->productoService = $productoService;
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
        $user = Auth::user();
        $unidad = $this->unidadService->getById($und_id);
        $lista = $this->productoService->getAllPaginateBySearchAndSort(10,$und_id);
        return view('producto.index', compact('lista','und_id','publicar','searchtype', 'search','sort','unidad'));
    }

    public function create($und_id)
    {
        $producto = new Producto();
        $producto->pro_id = 0;
        $producto->estado = 'AC';
        return view('producto.createedit', compact('producto','und_id'));
    }

    public function edit($pro_id,$und_id)
    {
        $producto = $this->productoService->getById($pro_id);
        return view('producto.createedit', compact('producto','und_id','pro_id'));
    }


    public  function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->except('_token');
        $data['usr_id'] = $user->id;
        $tamImagen = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-8");
        $x = $tamImagen->valor2;
        $y = $tamImagen->valor3;
        $ruta = storage_path('app/public/uploads/');
        if($request->pro_id == 0 ) {
            $data['publicar'] = 1;
            $data['fecha_registro'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido.',
                'descripcion.required' => 'El campo descripcion es requerido',
                'imagenes.required' => 'Las Imagens son requeridas',
                'imagenes.*.max' => 'El peso de cada imagen no debe ser mayor a 4 Mb.',
            ];
            $validator = Validator::make($data, [
                'nombre' => 'required',
                'descripcion' => 'required',
                'imagenes'=>'required',
                'imagenes.*' => 'mimes:jpeg,jpg,JPEG,JPG|max:4000'
            ], $messages);

            $data['slug'] = Str::slug($data['nombre']);
            $existe = $this->productoService->existeSlug($data['slug']);
            if ($existe){
                $validator->errors()->add('nombre', 'El nombre del producto ya existe, ingrese uno nuevo por favor');
                return back()->withErrors($validator)->withInput();
            }

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

            try {
                $producto = $this->productoService->save($data);
                if (empty($producto)) {
                    Toastr::warning('No se pudo guardar el producto',"");
                    return back()->withInput();
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/producto/'.$data['und_id'].'/lista');

                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar el producto',"");
                return back()->withInput();
            }
        }else{
            $data['fecha_modificacion'] = date('Y-m-d H:i:s');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido.',
                'descripcion.required' => 'El campo descripcion es requerido'
            ];
            $validator = Validator::make($data, [
                'nombre' => 'required',
                'descripcion' => 'required'
            ], $messages);

            //control SLUG
            $data['slug'] = Str::slug($data['nombre']);
            $existe = $this->productoService->existeSlugById($data['pro_id'],$data['slug']);
            if ($existe){
                $validator->errors()->add('nombre', 'El nombre del producto ya existe, ingrese uno nuevo por favor');
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
                $programa = $this->productoService->update($data);
                if (empty($programa)) {
                    Toastr::warning('No se pudo editar el producto',"");
                    return back()->withInput();
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/producto/'.$data['und_id'].'/lista');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar el producto',"");
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
            $producto = $this->productoService->delete($data);

            if (!empty($producto)){
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
            $data['pro_id'] = $request->pro_id;
            $data['publicar'] = $request->publicar;
            $producto = $this->productoService->cambiarPublicar($data);

            if (!empty($producto)){
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
            $data['pri_id'] = $request->pri_id;
            $data['estado'] = 'EL';
            $programa = $this->productoService->eliminarProductoImagen($data);
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
