<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;

use App\Models\ImagenUnidad;
use App\Services\ParametricaService;
use Illuminate\Http\Request;
use App\Models\Unidad;
use App\Services\BiografiaService;
use App\Services\ImagenUnidadService;
use App\Services\UnidadService;
use Brian2694\Toastr\Toastr as ToastrToastr;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Notification;
use Intervention\Image\Facades\Image;


class UnidadDespachoController extends Controller
{
    private $unidadService;
    private $biografiaService;
    private $imagenUnidadService;
    private $parametricaService;
    public function __construct(
        UnidadService $unidadService,
        BiografiaService $biografiaService,
        ImagenUnidadService $imagenUnidadService,
        ParametricaService $parametricaService
    ) {
        $this->unidadService = $unidadService;
        $this->biografiaService = $biografiaService;
        $this->imagenUnidadService = $imagenUnidadService;
        $this->parametricaService = $parametricaService;
        $this->middleware('auth');
    }

    public function index()
    {
        $lista = $this->unidadService->getUnidadDespacho();
        $ruta = 'unidaddespacho';
        return view('unidaddespacho.index', compact('lista', 'ruta'));
    }

    public function create()
    {
        $unidadDespacho = new Unidad();
        $unidadDespacho->und_id = 0;
        $unidadDespacho->estado = 'AC';
        $listaBiografias = $this->biografiaService->getComboBiografia();
        $param = $this->parametricaService->getParametricaByTipoAndCodigo("ZOOM-PRODUCTOR-MAPA-1");
        $unidadDespacho->latitud = $param->valor2;
        $unidadDespacho->longitud = $param->valor3;
        return view('unidaddespacho.createedit', compact('unidadDespacho', 'listaBiografias'));
    }

    public function edit($und_id)
    {
        $tipo = 23;
        $listaBiografias = $this->biografiaService->getComboBiografia();
        $unidadDespacho = $this->unidadService->getUnidadDespacho();
        $imagenesBanners = $this->imagenUnidadService->getImagenUnidadBannerByUnidadAndTipo($unidadDespacho->und_id, $tipo);
        $cantidadimageneshay = count($imagenesBanners);
        return view('unidaddespacho.createedit', compact('unidadDespacho', 'listaBiografias', 'imagenesBanners', 'cantidadimageneshay'));
    }

    public function store(Request $request)
    {
        $tamImagenBanner = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-23");
        $tamImagenicono = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-12");
        $tamImagendireccion = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-8");
        $tamImagenOrganigrama = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-22");
        $xbanner = $tamImagenBanner->valor2;
        $ybanner = $tamImagenBanner->valor3;
        $tipobanner = $tamImagenBanner->valor1;
        $xIcono = $tamImagenicono->valor2;
        $yIcono = $tamImagenicono->valor3;
        $xdireccion = $tamImagendireccion->valor2;
        $ydireccion = $tamImagendireccion->valor3;
        $xoganigra = $tamImagenOrganigrama->valor2;
        $yoganigra = $tamImagenOrganigrama->valor3;

        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        if ($request->und_id == 0) {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido',
                'mision.required' => 'El campo mision es requerido',
                'vision.required' => 'El campo vision es requerido',
                'objetivo.required' => 'El campo objetivo es requerido',
                'historia.required' => 'El campo historia es requerido',
                'organigrama.required' => 'El campo organigrama es requerido',
                'imagen_icono.required' => 'El campo imagen icono es requerido',
                'imagen_banner.*.max' => 'El peso de la imagen banner no debe ser mayor a 2000 kilobytes',
            ];
            $validator = Validator::make($data, [
                'nombre' => 'required',
                'mision' => 'required',
                'vision' => 'required',
                'objetivo' => 'required',
                'historia' => 'required',
                'organigrama' => 'required',
                'imagen_icono' => 'mimes:jpeg,jpg,JPEG,JPG|max:4000',
                'imagen_banner.*' => 'mimes:jpeg,jpg,JPEG,JPG|max:4000'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun cambio verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            if ($request->hasFile('imagen_banner')) {
                $files = $request->file('imagen_banner');
                $listaNomImagenes = null;
                $i = 0;
                foreach ($files as $file) {
                    $extencionImagen = $file->extension();
                    $nombreUno = time() . '' . uniqid() . '.' . $extencionImagen;
                    if ($i == 0) {
                        $listaNomImagenes = $nombreUno;
                    } else {
                        $listaNomImagenes = $listaNomImagenes . ',' . $nombreUno;
                    }
                    $i++;
                    $imagenUno = Image::make($file);
                    $imagenUno->resize($xbanner, $ybanner);
                    $imagenUno->save($ruta . $nombreUno, 95);
                }
                $data['imagen_banner'] = $listaNomImagenes;
                $data['ancho_banner'] = $xbanner;
                $data['alto_banner']  = $ybanner;
                $data['tipo_banner']  = $tipobanner;
            }
            if ($request->hasFile('imagen_icono')) {
                $file2 = $request->imagen_icono;
                $extencionImagen2 = $file2->extension();
                $nombreIcono = time() . '' . uniqid() . '.' . $extencionImagen2;
                $data['imagen_icono'] = $nombreIcono;
                $imagenIcono = Image::make($file2);
                $imagenIcono->resize($xIcono, $yIcono);
                $imagenIcono->save($ruta . $nombreIcono, 95);
            }
            if ($request->hasFile('imagen_direccion')) {
                $file3 = $request->imagen_direccion;
                $extencionImagen3 = $file3->extension();
                $nombreDireccion = time() . '' . uniqid() . '.' . $extencionImagen3;
                $data['imagen_direccion'] = $nombreDireccion;
                $imagenIcono = Image::make($file3);
                $imagenIcono->resize($xoganigra, $yoganigra);
                $imagenIcono->save($ruta . $nombreDireccion, 95);
            }
            if ($request->hasFile('organigrama')) {
                $extension = $request->organigrama->extension();
                $nombreAlterno = time() . '' . uniqid();
                $path = $request->organigrama->storeAs('public/uploads/', $nombreAlterno . '.' . $extension);
                $data['organigrama'] = $nombreAlterno . '.' . $extension;
            }
            try {
                $unidadDespacho = $this->unidadService->saveUnidad($data);
                if (empty($unidadDespacho)) {
                    Toastr::warning('No se pudo guardar la unidad Despacho', "");
                    return back()->withInput();
                } else {
                    Toastr::success('Operación completada ', "");
                    return redirect('sisadmin/unidaddespacho');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar la unidad Despacho', "");
                return back()->withInput();
            }
        } else {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido',
                'mision.required' => 'El campo mision es requerido',
                'vision.required' => 'El campo vision es requerido',
                'objetivo.required' => 'El campo objetivo es requerido',
                'historia.required' => 'El campo historia es requerido'
            ];
            $validator = Validator::make($data, [
                'nombre' => 'required',
                'mision' => 'required',
                'vision' => 'required',
                'objetivo' => 'required',
                'historia' => 'required'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun cambio verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('imagen_banner')) {
                $messages = ['imagen_banner.*.max' => 'El peso de la imagen banner no debe ser mayor a 4000 kilobytes'];
                $validator = Validator::make($data, ['imagen_banner.*' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'], $messages);
                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique las imagenes banner', "");
                    return back()->withErrors($validator)->withInput();
                }

                $files = $request->file('imagen_banner');
                $listaNomImagenes = null;
                $i = 0;
                foreach ($files as $file) {
                    $extencionImagen = $file->extension();
                    $nombreUno = time() . '' . uniqid() . '.' . $extencionImagen;
                    if ($i == 0) {
                        $listaNomImagenes = $nombreUno;
                    } else {
                        $listaNomImagenes = $listaNomImagenes . ',' . $nombreUno;
                    }
                    $i++;
                    $imagenUno = Image::make($file);
                    $imagenUno->resize($xbanner, $ybanner);
                    $imagenUno->save($ruta . $nombreUno, 95);
                }
                $data['imagen_banner'] = $listaNomImagenes;
                $data['ancho_banner'] = $xbanner;
                $data['alto_banner']  = $ybanner;
                $data['tipo_banner']  = $tipobanner;
            }
            if ($request->hasFile('imagen_icono')) {
                $messages = ['imagen_icono.max' => 'El peso de la imagen icono no debe ser mayor a 4000 kilobytes'];
                $validator = Validator::make($data, ['imagen_icono' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'], $messages);
                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique las imagenes icono', "");
                    return back()->withErrors($validator)->withInput();
                }

                $file2 = $request->imagen_icono;
                $extencionImagen2 = $file2->extension();
                $nombreIcono = time() . '' . uniqid() . '.' . $extencionImagen2;
                $data['imagen_icono'] = $nombreIcono;
                $imagenIcono = Image::make($file2);
                $imagenIcono->resize($xIcono, $yIcono);
                $imagenIcono->save($ruta . $nombreIcono, 95);
            }
            if ($request->hasFile('imagen_direccion')) {
                $messages = ['imagen_direccion.max' => 'El peso de la imagen direccion no debe ser mayor a 4000 kilobytes'];
                $validator = Validator::make($data, ['imagen_direccion' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'], $messages);
                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique las imagenes icono', "");
                    return back()->withErrors($validator)->withInput();
                }

                $file3 = $request->imagen_direccion;
                $extencionImagen3 = $file3->extension();
                $nombreDireccion = time() . '' . uniqid() . '.' . $extencionImagen3;
                $data['imagen_direccion'] = $nombreDireccion;
                $imagenIcono = Image::make($file3);
                $imagenIcono->resize($xdireccion, $ydireccion);
                $imagenIcono->save($ruta . $nombreDireccion, 95);
            }
            if ($request->hasFile('organigrama')) {
                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                ];
                $validator = Validator::make($data, [
                    'organigrama' => 'required|mimes:pdf,PDF,doc,docx,xls,xlsx|max:4000'
                ], $messages);
                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $extension = $request->organigrama->extension();
                $nombreAlterno = time() . '' . uniqid();
                $path = $request->organigrama->storeAs('public/uploads/', $nombreAlterno . '.' . $extension);
                $data['organigrama'] = $nombreAlterno . '.' . $extension;
            }

            try {
                $unidadDespacho = $this->unidadService->update($data);
                if (empty($unidadDespacho)) {
                    Toastr::warning('No se pudo editar la unidad Despacho', "");
                    return back()->withInput();
                } else {
                    Toastr::success('Operación completada ', "");
                    return redirect('sisadmin/unidaddespacho/edit/' . $request->und_id);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la unidad Despacho', "");
                return back()->withInput();
            }
        }
    }

    public function _eliminarimagen_despacho(Request $request)
    {
        $imagenUnidad = $this->imagenUnidadService->getById($request->imu_id);
        $imagenUnidad->estado = 'EL';
        $imagenUnidad->save();
        $tipo = 23;
        $imagenesBanners = $this->imagenUnidadService->getImagenUnidadBannerByUnidadAndTipo($request->und_id, $tipo);
        $cantidadimageneshay = count($imagenesBanners);
        return view('unidaddespacho._tablaimagenunidaddespacho', compact('imagenesBanners', 'cantidadimageneshay'));
    }

    // INGRESO POR OTRO LADO A UNIDAD DESPACHO----------------
    public function editar($und_id)
    {
        $tipo = 23;
        $listaBiografias = $this->biografiaService->getComboBiografia();
        $unidadDespacho = $this->unidadService->getUnidadDespacho();
        $imagenesBanners = $this->imagenUnidadService->getImagenUnidadBannerByUnidadAndTipo($unidadDespacho->und_id, $tipo);
        $cantidadimageneshay = count($imagenesBanners);
        return view('unidaddespacho.createeditar', compact('unidadDespacho', 'listaBiografias', 'imagenesBanners', 'cantidadimageneshay'));
    }

    public function storeeditar(Request $request)
    {
        $tamImagenBanner = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-23");
        $tamImagenicono = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-12");
        $tamImagendireccion = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-8");
        $tamImagenOrganigrama = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-22");
        $xbanner = $tamImagenBanner->valor2;
        $ybanner = $tamImagenBanner->valor3;
        $tipobanner = $tamImagenBanner->valor1;
        $xIcono = $tamImagenicono->valor2;
        $yIcono = $tamImagenicono->valor3;
        $xdireccion = $tamImagendireccion->valor2;
        $ydireccion = $tamImagendireccion->valor3;
        $xoganigra = $tamImagenOrganigrama->valor2;
        $yoganigra = $tamImagenOrganigrama->valor3;
        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        if ($request->und_id == 0) {
        } else {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido',
                'mision.required' => 'El campo mision es requerido',
                'vision.required' => 'El campo vision es requerido',
                'objetivo.required' => 'El campo objetivo es requerido',
                'historia.required' => 'El campo historia es requerido',
                'imagen_banner.*.max' => 'El peso de la imagen banner no debe ser mayor a 4000 kilobytes'
            ];
            $validator = Validator::make($data, [
                'nombre' => 'required',
                'mision' => 'required',
                'vision' => 'required',
                'objetivo' => 'required',
                'historia' => 'required',
                'imagen_banner.*' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun cambio verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('imagen_banner')) {
                $messages = ['imagen_banner.*.max' => 'El peso de la imagen banner no debe ser mayor a 4000 kilobytes'];
                $validator = Validator::make($data, ['imagen_banner.*' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'], $messages);
                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique las imagenes banner', "");
                    return back()->withErrors($validator)->withInput();
                }
                $files = $request->file('imagen_banner');
                $listaNomImagenes = null;
                $i = 0;
                foreach ($files as $file) {
                    $extencionImagen = $file->extension();
                    $nombreUno = time() . '' . uniqid() . '.' . $extencionImagen;
                    if ($i == 0) {
                        $listaNomImagenes = $nombreUno;
                    } else {
                        $listaNomImagenes = $listaNomImagenes . ',' . $nombreUno;
                    }
                    $i++;
                    $imagenUno = Image::make($file);
                    $imagenUno->resize($xbanner, $ybanner);
                    $imagenUno->save($ruta . $nombreUno, 95);
                }
                $data['imagen_banner'] = $listaNomImagenes;
                $data['ancho_banner'] = $xbanner;
                $data['alto_banner']  = $ybanner;
                $data['tipo_banner']  = $tipobanner;
            }
            if ($request->hasFile('imagen_icono')) {
                $messages = ['imagen_icono.max' => 'El peso de la imagen icono no debe ser mayor a 4000 kilobytes'];
                $validator = Validator::make($data, ['imagen_icono' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'], $messages);
                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique las imagenes icono', "");
                    return back()->withErrors($validator)->withInput();
                }
                $file2 = $request->imagen_icono;
                $extencionImagen2 = $file2->extension();
                $nombreIcono = time() . '' . uniqid() . '.' . $extencionImagen2;
                $data['imagen_icono'] = $nombreIcono;
                $imagenIcono = Image::make($file2);
                $imagenIcono->resize($xIcono, $yIcono);
                $imagenIcono->save($ruta . $nombreIcono, 95);
            }
            if ($request->hasFile('imagen_direccion')) {
                $messages = ['imagen_direccion.max' => 'El peso de la imagen direccion no debe ser mayor a 4000 kilobytes'];
                $validator = Validator::make($data, ['imagen_direccion' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:4000'], $messages);
                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique las imagenes icono', "");
                    return back()->withErrors($validator)->withInput();
                }
                $file3 = $request->imagen_direccion;
                $extencionImagen3 = $file3->extension();
                $nombreDireccion = time() . '' . uniqid() . '.' . $extencionImagen3;
                $data['imagen_direccion'] = $nombreDireccion;
                $imagenIcono = Image::make($file3);
                $imagenIcono->resize($xdireccion, $ydireccion);
                $imagenIcono->save($ruta . $nombreDireccion, 95);
            }
            if ($request->hasFile('organigrama')) {
                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                ];
                $validator = Validator::make($data, [
                    'organigrama' => 'required|mimes:pdf,PDF,doc,docx,xls,xlsx|max:4000'
                ], $messages);
                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $extension = $request->organigrama->extension();
                $nombreAlterno = time() . '' . uniqid();
                $path = $request->organigrama->storeAs('public/uploads/', $nombreAlterno . '.' . $extension);
                $data['organigrama'] = $nombreAlterno . '.' . $extension;
            }

            try {
                $unidadDespacho = $this->unidadService->update($data);
                if (empty($unidadDespacho)) {
                    Toastr::warning('No se pudo editar la unidad Despacho', "");
                    return back()->withInput();
                } else {
                    Toastr::success('Operación completada ', "");
                    return redirect('sisadmin/unidaddespacho/editar/' . $request->und_id);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la unidad Despacho', "");
                return back()->withInput();
            }
        }
    }
}
