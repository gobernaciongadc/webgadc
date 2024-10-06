<?php


namespace App\Repositories;


use App\User;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\This;

class UserRepository
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getById($id):?User
    {
        return $this->user->find($id);
    }

    public function getUserByEmail($email): ?User
    {
        return $this->user->where([
            ['email','=',$email]
        ])->first();
    }

    public function getAll()
    {
        return $this->user->all();
    }

    public function getAllAc()
    {
        return $this->user->where('estado','=','AC')->get();
    }

    public function getTodosUsuariosPaginateBySearchAndSort($limit,$searchtype,$search,$sort)
    {
        $campoSearch = $searchtype==1?'name':'email';
        $sortCampo = $sort==1?'name':($sort==2?'email':'rol');
        return $this->user->whereRaw(
            "UPPER($campoSearch) like '%".strtoupper($search)."%'"
        )->orderBy($sortCampo,'asc')->paginate($limit);
    }

    public function save($data):?User
    {
        $nuevo = new $this->user;
        $nuevo->name = $data['name'];
        $nuevo->email = $data['email'];
        $nuevo->password = Hash::make($data['password']);
        $nuevo->estado = $data['estado'];
        $nuevo->created_at = date('Y-m-d H:i:s');
        $nuevo->updated_at = date('Y-m-d H:i:s');
        $nuevo->und_id = $data['und_id'];
        $nuevo->save();
        return $nuevo->fresh();
    }

    public function update($usr_id,$data):?User
    {
        $nuevo = $this->user::find($usr_id);
        $nuevo->name = $data['name'];
        $nuevo->email = $data['email'];
        $nuevo->estado = $data['estado'];
        $nuevo->updated_at = date('Y-m-d H:i:s');
        $nuevo->und_id = $data['und_id'];
        $nuevo->save();
        return $nuevo->fresh();
    }

    public function actualizarContrasenia($id,$contrasenia):?User
    {
        $user = $this->user->find($id);
        $user->password = Hash::make($contrasenia);
        $user->save();
        return $user->fresh();
    }

    public function actualizarDatosUsuario($id,$data):?User
    {
        $user = $this->user->find($id);
        $user->name = $data['name'];
        $user->estado = $data['estado'];
        $user->updated_at = date('Y-m-d H:i:s');
        $user->save();
        return $user->fresh();
    }

    public function actualizarEstado($usr_id,$estado)
    {
        $user = $this->user->find($usr_id);
        $user->estado = $estado;
        $user->updated_at = date('Y-m-d H:i:s');
        $user->save();
        return $user->fresh();
    }

}
