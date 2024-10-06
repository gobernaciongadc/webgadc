<?php

namespace App\Http\Controllers;

use App\Models\ModelsDto\ComunDto;
use App\Models\Rol;
use App\Services\ParametricaService;
use App\Services\RolService;
use App\Services\UnidadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Toastr;

class RolController extends Controller
{
    protected $rolService;
    protected $parametricaService;
    protected $unidadService;
    public function __construct(
        RolService $rolService,
        ParametricaService $parametricaService,
        UnidadService $unidadService
    )
    {
        $this->rolService = $rolService;
        $this->parametricaService = $parametricaService;
        $this->unidadService = $unidadService;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $unidad = $this->unidadService->getById($user->und_id);

        $lista = $this->rolService->getAllAcAndPaginateAndSearchAndSort($searchtype,$search,$sort,10);
        return view('rol.index',compact(
            'user',
            'unidad',
            'searchtype',
            'search',
            'sort',
            'lista'
        ));
    }

    public function create()
    {
        $user = Auth::user();
        $rol = new Rol();
        $rol->rol_id = 0;
        $rol->estado = 'AC';
        $accesos = $this->armarSelect($rol->rol_id);
        return view('rol.create',compact('user','rol','accesos'));
    }

    public function edit($rol_id)
    {
        $user = Auth::user();
        $rol = $this->rolService->getById($rol_id);
        $accesos = $this->armarSelect($rol->rol_id);
        return view('rol.create',compact('user','rol','accesos'));
    }

    private function armarSelect($rol_id)
    {
        $accesosLista = new Collection();
        $idAccesosThisRol = $this->rolService->getAllAccesosIdOfRol($rol_id);
        $sistemas = $this->rolService->getAllSistemas();
        foreach ($sistemas as $k1=>$sistema){
            $n1 = new ComunDto();
            $n1->id = $sistema->sis_id;
            $n1->idSelect = 'N1-'.$sistema->sis_id;
            $n1->text = $sistema->descripcion;
            $n1->flagUrl = null;
            $n1->checked = false;
            $n1->children = new Collection();
            $modulos = $this->rolService->getAllModulosBySisId($sistema->sis_id);
            foreach ($modulos as $k2=>$modulo){
                $n2 = new ComunDto();
                $n2->id = $modulo->mod_id;
                $n2->idSelect = 'N2-'.$modulo->mod_id;
                $n2->text = $modulo->descripcion;
                $n2->flagUrl = null;
                $n2->checked = false;
                /*if($n2->checked == false)
                {
                    $n1->checked = false;
                }*/
                $n2->children = new Collection();
                $accesos = $this->rolService->getAllAccesosByModId($modulo->mod_id);
                foreach ($accesos as $k3=>$acceso){
                    $n3 = new ComunDto();
                    $n3->id = $acceso->acc_id;
                    $n3->idSelect = 'N3-'.$acceso->acc_id;
                    $n3->text = $acceso->descripcion;
                    $n3->flagUrl = null;
                    $n3->checked = $idAccesosThisRol->contains('acc_id',$acceso->acc_id);
                    /*if ($n3->checked == false) {
                        $n2->checked = false;
                        $n1->checked = false;
                    }*/
                    $n3->children = new Collection();
                    $n2->children->push($n3);
                }
                $n1->children->push($n2);
            }
            $accesosLista->push($n1);
        }
        return $accesosLista;
    }

    public function store(Request $request)
    {
        $idsAccesos = array();
        if (isset($request->idsAccesos)){
            $idsAccesos = explode('-',$request->idsAccesos);
        }
        //dd($request,$idsAccesos);
        try {
            $user = Auth::user();
            $data = $request->except(['_token','idsAccesos']);
            $rol = null;
            if ($request->rol_id == 0){
                $rol = $this->rolService->saveRolAndAccesosMasivo($data,$idsAccesos);
            }else{
                $rol = $this->rolService->updateRolAndAccesosMasivo($data,$idsAccesos);
            }
            if (empty($rol)){
                Toastr::error('No se pudo guardar lo datos','');
                return back()->withInput();
            }else{
                Toastr::success('Operación completada','');
                return redirect('sisadmin/roles');
            }
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            Toastr::error('No se pudo guardar lo datos','');
            return back()->withInput();
        }
    }

    public function _modificarEstado(Request $request)
    {
        try {
            $user = Auth::user();
            $data = array();
            $data['rol_id'] = $request->id;
            $data['estado'] = $request->estado;
            $cambiar = $this->rolService->delete($data);
            if (!empty($cambiar)){
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
