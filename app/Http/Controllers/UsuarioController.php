<?php

namespace App\Http\Controllers;

use App\Models\ModelsDto\ComunDto;
use App\Services\RolService;
use App\Services\UnidadService;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Toastr;

class UsuarioController extends Controller
{
    protected $unidadService;
    protected $userService;
    protected $rolService;
    public function __construct(
        UnidadService $unidadService,
        UserService $userService,
        RolService $rolService
    )
    {
        $this->unidadService = $unidadService;
        $this->userService = $userService;
        $this->rolService = $rolService;
        $this->middleware('auth');
    }

    public function miperfil(){
        $user = Auth::user();
        $unidades = $this->unidadService->getAllAcUnidadesParaComboSelectOrdenadosByTipo();
        return view('usuario.miperfil',compact('user','unidades'));
    }

    public function updatemiperfil(Request $request)
    {
        try {
            $data = $request->except('_token');
            $user = Auth::user();

            $messages = [
                'name.required' => 'El campo nombre es requerido',
            ];
            $validator = Validator::make($data, [
                'id' => 'required',
                'name' => 'required'
            ], $messages);

            if ($request->has('password')){
                if (!empty($request->password)){
                    $messages = [
                        'name.required' => 'El campo nombre es requerido',
                        'password.required' => 'La contraseña es requerido',
                        'password.confirmed' => 'Las contraseñas no coinciden, intente nuevamente.',
                        'password.min' => 'La contraseña debe contener al menos 8 caracteres.',
                    ];
                    $validator = Validator::make($data, [
                        'name' => 'required',
                        'id' => 'required',
                        'password' => 'required|confirmed|min:8',
                    ], $messages);
                }
            }

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $usuario = $this->userService->actualizarDatosUsuario($request->id,$data);
            if ($request->has('password')){
                if (!empty($request->password)){
                    $usuario = $this->userService->actualizarContrasenia($request->id,$data['password']);
                }
            }
            if (!empty($usuario)){
                Toastr::success('Operación completada','');
                return redirect('sisadmin/home');
            }else{
                Toastr::error('No se pudo guardar lo datos','');
                return back()->withInput();
            }
        }catch (\Exception $e){
            Toastr::error('No se pudo guardar lo datos','');
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return back()->withInput();
        }
    }

    public function usuarios(Request $request)
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $user = Auth::user();
        if ($request->has('searchtype')){
            $searchtype = $request->searchtype;
        }
        if ($request->has('search')){
            $search = $request->search;
        }
        if ($request->has('sort')){
            $sort = $request->sort;
        }
        $usuarios = $this->userService->getTodosUsuariosPaginateBySearchAndSort(10,$searchtype,$search,$sort);
        return view('usuario.usuarios',compact(
            'user',
            'usuarios',
            'searchtype',
            'search',
            'sort'
        ));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $usuario = new User();
        $usuario->id = 0;
        $usuario->estado = 'AC';
        $unidades = $this->unidadService->getAllAcUnidadesParaComboSelectOrdenadosByTipo();
        return view('usuario.create',compact('user','usuario','unidades'));
    }

    public function edit($usr_id)
    {
        $user = Auth::user();
        $usuario = $this->userService->getById($usr_id);
        $unidades = $this->unidadService->getAllAcUnidadesParaComboSelectOrdenadosByTipo();
        return view('usuario.create',compact('user','usuario','unidades'));
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $data = $request->except('_token');
            $usuario = null;
            if ($request->id == 0){
                $messages = [
                    'und_id.required' => 'Debe seleccionar una unidad',
                    'name.required' => 'El nombre completo es requerido',
                    'email.email' => 'Debe ingresar un correo electrónico valido',
                    'email.unique' => 'El correo electrónico ya está en uso, por favor ingrese otro.',
                    'password.required' => 'La contraseña es requerido',
                    'password.confirmed' => 'Las contraseñas no coinciden, intente nuevamente.',
                    'password.min' => 'La contraseña debe contener al menos 8 caracteres.',
                ];
                $validator = Validator::make($data, [
                    'name' => 'required',
                    'und_id' => 'required',
                    'email' => 'required|email|unique:users|max:255',
                    'password' => 'required|confirmed|min:8'
                ], $messages);

                if($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $usuario = $this->userService->save($data);
            }else{
                $messages = [
                    'und_id.required' => 'Debe seleccionar una unidad',
                    'name.required' => 'El nombre completo es requerido',
                    'email.email' => 'Debe ingresar un correo electrónico valido',
                    'email.unique' => 'El correo electrónico ya está en uso, por favor ingrese otro.'
                ];
                $validator = Validator::make($data, [
                    'name' => 'required',
                    'und_id' => 'required',
                    'email' => 'required|email|unique:users,email,'.$data['id'].'|max:255'
                ], $messages);

                if($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $usuario = $this->userService->update($request->id,$data);
            }

            if (!empty($usuario)){
                Toastr::success('Operación completada','');
                return redirect('sisadmin/usuario/usuarios');
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

    public function editContrasenia($usr_id)
    {
        $user = Auth::user();
        $usuario = $this->userService->getById($usr_id);
        return view('usuario.editcontrasenia',compact('user','usuario'));
    }

    public function storeContrasenia(Request $request)
    {
        try {
            $user = Auth::user();
            $data = $request->except('_token');
            $usuario = null;
            $messages = [
                'password.required' => 'La contraseña es requerido',
                'password.confirmed' => 'Las contraseñas no coinciden, intente nuevamente.',
                'password.min' => 'La contraseña debe contener al menos 8 caracteres.',
            ];
            $validator = Validator::make($data, [
                'id' => 'required',
                'password' => 'required|confirmed|min:8'
            ], $messages);

            if($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $usuario = $this->userService->actualizarContrasenia($request->id,$request->password);

            if (!empty($usuario)){
                Toastr::success('Operación completada','');
                return redirect('sisadmin/usuario/usuarios');
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

    public function _cambiarEstado(Request $request)
    {
        try {
            $user = Auth::user();
            $usuario = $this->userService->actualizarEstado($request->id,$request->estado);
            if (!empty($usuario)){
                return response()->json([
                    'res'=>true,
                    'mensaje'=>'Usuario modificado'
                ]);
            }else{
                return response()->json([
                    'res'=>false,
                    'mensaje'=>'No se pudo modificar el usuario'
                ]);
            }
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
               'res'=>false,
               'mensaje'=>'No se pudo modificar el usuario'
            ]);
        }
    }

    public function rolesUsuario($usr_id)
    {
        $user = Auth::user();
        $usuario = $this->userService->getById($usr_id);
        $unidades = $this->unidadService->getAllAcUnidadesParaComboSelectOrdenadosByTipo();
        $roles = $this->armarSelect($usuario->id);
        return view('usuario.roles',compact('user','usuario','unidades','roles'));
    }

    private function armarSelect($usr_id)
    {
        $rolesLista = new Collection();
        $idRolesThisUsuario = $this->rolService->getAllRolesIdByUsrId($usr_id);
        $roles = $this->rolService->getAllAc();
        foreach ($roles as $k=>$rol){
            $n1 = new ComunDto();
            $n1->id = $rol->rol_id;
            $n1->idSelect = 'N1-'.$rol->rol_id;
            $n1->text = $rol->descripcion;
            $n1->flagUrl = null;
            $n1->checked = $idRolesThisUsuario->contains('rol_id',$rol->rol_id);
            $n1->children = new Collection();
            $rolesLista->push($n1);
        }
        return $rolesLista;
    }

    public function storeRoles(Request $request)
    {
        try {
            $user = Auth::user();
            //$data = $request->except('_token');
            $idsRoles = array();
            if (isset($request->idsRoles)){
                $idsRoles = explode('-',$request->idsRoles);
            }
            $res = $this->rolService->saveAndUpdateUsuarioRolMasivoUsuario($request->usr_id,$idsRoles);
            if ($res){
                Toastr::success('Operación completada','');
                return redirect('sisadmin/usuario/usuarios');
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
