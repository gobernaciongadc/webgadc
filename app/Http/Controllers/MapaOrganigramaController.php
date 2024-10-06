<?php

namespace App\Http\Controllers;

use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Toastr;

class MapaOrganigramaController extends Controller
{
    protected $unidadService;
    public function __construct(
        UnidadService $unidadService
    )
    {
        $this->unidadService = $unidadService;
        $this->middleware('auth');
    }

    public function create($und_id)
    {
        $user = Auth::user();
        $unidad = $this->unidadService->getById($und_id);
        $rutaAdicional = '';
        if ($unidad->tipoUnidad->tipo == 1){
            $rutaAdicional = 'unidadsecretaria';
        }elseif ($unidad->tipoUnidad->tipo == 2){
            $rutaAdicional = 'unidaddireccion';
        }elseif ($unidad->tipoUnidad->tipo == 3){
            $rutaAdicional = 'unidadunidad';
        }elseif ($unidad->tipoUnidad->tipo == 4){
            $rutaAdicional = 'unidadservicio';
        }
        $editar = false;
        $html_image = $unidad->mapa_organigrama;
        if (empty($html_image)){
            $ruta = asset('storage/uploads/'.$unidad->organigrama);
            $html_image = "<img src='$ruta' draggable='false'>";
        }else{
            $editar = true;
        }
        return view('mapaorganigrama.create',compact('user','unidad','editar','html_image','rutaAdicional'));
    }

    public function ver($und_id)
    {
        $unidad = $this->unidadService->getById($und_id);
        return view('mapaorganigrama.ver',compact('unidad'));
    }

    public function store(Request $request)
    {
        //dd($request->html_organigrama);
        try {
            $unidadRes = null;
            $unidad = $this->unidadService->getById($request->und_id);
            $rutaAdicional = '';
            if ($unidad->tipoUnidad->tipo == 1){
                $rutaAdicional = 'unidadsecretaria';
            }elseif ($unidad->tipoUnidad->tipo == 2){
                $rutaAdicional = 'unidaddireccion';
            }elseif ($unidad->tipoUnidad->tipo == 3){
                $rutaAdicional = 'unidadunidad';
            }elseif ($unidad->tipoUnidad->tipo == 4){
                $rutaAdicional = 'unidadservicio';
            }
            $data = array();
            $data['und_id'] = $request->und_id;
            $data['mapa_organigrama'] = $request->html_organigrama;
            $unidadRes = $this->unidadService->updateMapaOrganigrama($data);
            if (!empty($unidadRes)){
                Toastr::success('Operación completada','');
                return redirect('sisadmin/'.$rutaAdicional);
            }else{
                Toastr::error('No se pudo guardar lo datos','');
                return back()->withInput();
            }
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            Toastr::error('No se pudo guardar lo datos','');
            return back()->withInput();
        }
    }

}
