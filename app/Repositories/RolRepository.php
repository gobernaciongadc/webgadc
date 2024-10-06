<?php


namespace App\Repositories;


use App\Models\Acceso;
use App\Models\Modulo;
use App\Models\Rol;
use App\Models\RolAcceso;
use App\Models\Sistema;
use App\Models\UsuarioRol;

class RolRepository
{
    protected $rol;
    public function __construct(Rol $rol)
    {
        $this->rol = $rol;
    }

    public function getById($rol_id)
    {
        return $this->rol->find($rol_id);
    }

    public function getAllAc()
    {
        return $this->rol->where([
            ['estado','=','AC']
        ])->with('usuarioRoles','rolesAcceso')->get();
    }

    public function getAllAcAndPaginateAndSearchAndSort($searchtype,$search,$sort,$limit)
    {
        return $this->rol->where([
            ['estado','=','AC']
        ])->orderBy('descripcion','asc')->paginate($limit);
    }

    public function save($data)
    {
        $nuevo = new $this->rol();
        $nuevo->descripcion = $data['descripcion'];
        $nuevo->estado = $data['estado'];
        $nuevo->save();
        return $nuevo->fresh();
    }

    public function update($data)
    {
        $editar = $this->rol->find($data['rol_id']);
        $editar->descripcion = $data['descripcion'];
        $editar->estado = $data['estado'];
        $editar->save();
        return $editar->fresh();
    }

    public function delete($data)
    {
        $editar = $this->rol->find($data['rol_id']);
        $editar->estado = $data['estado'];
        $editar->save();
        return $editar->fresh();
    }

    //otros de roles
    public function getAllSistemas()
    {
        return Sistema::where('estado','=','AC')->orderBy('orden','asc')->get();
    }

    public function getAllModulosBySisId($sis_id)
    {
        return Modulo::where([
            ['estado','=','AC'],
            ['sis_id','=',$sis_id]
        ])->orderBy('orden','asc')->get();
    }

    public function getAllAccesosByModId($mod_id)
    {
        return Acceso::where([
            ['estado','=','AC'],
            ['mod_id','=',$mod_id]
        ])->orderBy('orden','asc')->get();
    }

    public function getAllAccesosIdOfRol($rol_id)
    {
        return RolAcceso::where([
            ['estado','=','AC'],
            ['rol_id','=',$rol_id]
        ])->select('acc_id')->orderBy('acc_id','asc')->get();
    }

    public function saveRolAccesosMasivo($rol_id,$accesosIds)
    {
        $datos = array();
        foreach ($accesosIds as $k=>$id){
            $data = array(
                'estado'=>'AC',
                'acc_id'=>$id,
                'rol_id'=>$rol_id
            );
            array_push($datos,$data);
        }
        RolAcceso::insert($datos);
    }

    public function deleteAllRolAccesosByRolId($rol_id)
    {
        RolAcceso::where([
            ['rol_id','=',$rol_id],
            ['estado','=','AC']
        ])->update(['estado'=>'EL']);
    }

    public function getAllRolesIdByUsrId($usr_id)
    {
        return UsuarioRol::where([
            ['estado','=','AC'],
            ['usr_id','=',$usr_id]
        ])->select('rol_id')->orderBy('rol_id','asc')->get();
    }

    public function deleteAllUsuarioRolByUsrId($usr_id)
    {
        UsuarioRol::where([
            ['usr_id','=',$usr_id],
            ['estado','=','AC']
        ])->update(['estado'=>'EL']);
    }

    public function saveUsuarioRolMasivoUsuario($usr_id,$rolesIds)
    {
        $datos = array();
        foreach ($rolesIds as $k=>$id){
            $data = array(
                'estado'=>'AC',
                'fecha'=>date('Y-m-d'),
                'usr_id'=>$usr_id,
                'rol_id'=>$id
            );
            array_push($datos,$data);
        }
        UsuarioRol::insert($datos);
    }

    public function getAllAccesosByUsuarioId($usr_id)
    {
        return Acceso::where([
            ['estado','=','AC']
        ])->whereIn('acc_id',function ($query1) use($usr_id){
            $query1->select('acc_id')->from('rac_rol_acceso')->where([
                ['estado','=','AC']
            ])->whereIn('rol_id',function ($query2) use ($usr_id){
                $query2->select('rol_id')->from('url_usuario_rol')->where([
                    ['estado','=','AC'],
                    ['usr_id','=',$usr_id]
                ]);
            });
        })->get();
    }

}
