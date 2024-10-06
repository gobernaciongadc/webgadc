<?php


namespace App\Services;


use App\Repositories\UserRepository;
use App\User;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getById($id):?User
    {
        return $this->userRepository->getById($id);
    }

    public function getUserByEmail($email): ?User
    {
        return $this->userRepository->getUserByEmail($email);
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function getAllAc()
    {
        return $this->userRepository->getAllAc();
    }

    public function getTodosUsuariosPaginateBySearchAndSort($limit,$searchtype,$search,$sort)
    {
        return $this->userRepository->getTodosUsuariosPaginateBySearchAndSort($limit,$searchtype,$search,$sort);
    }

    public function save($data):?User
    {
        try {
            return $this->userRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function update($usr_id,$data):?User
    {
        try {
            return $this->userRepository->update($usr_id,$data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function actualizarContrasenia($id,$contrasenia):?User
    {
        try {
            return $this->userRepository->actualizarContrasenia($id,$contrasenia);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    public function actualizarDatosUsuario($id,$data):?User
    {
        try {
            return $this->userRepository->actualizarDatosUsuario($id,$data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    public function actualizarEstado($usr_id,$estado)
    {
        return $this->userRepository->actualizarEstado($usr_id,$estado);
    }

}
