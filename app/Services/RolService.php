<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;
use App\Repositories\RolRepository;
use Illuminate\Support\Facades\Log;

class RolService
{
    protected $rolRepository;
    public function __construct(
        RolRepository $rolRepository
    )
    {
        $this->rolRepository = $rolRepository;
    }

    public function getById($rol_id)
    {
        return $this->rolRepository->getById($rol_id);
    }

    public function getAllAc()
    {
        return $this->rolRepository->getAllAc();
    }

    public function getAllAcAndPaginateAndSearchAndSort($searchtype,$search,$sort,$limit)
    {
        return $this->rolRepository->getAllAcAndPaginateAndSearchAndSort($searchtype,$search,$sort,$limit);
    }

    public function save($data)
    {
        try {
            return $this->rolRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function update($data)
    {
        try {
            return $this->rolRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function delete($data)
    {
        try {
            return $this->rolRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getAllSistemas()
    {
        return $this->rolRepository->getAllSistemas();
    }

    public function getAllModulosBySisId($sis_id)
    {
        return $this->rolRepository->getAllModulosBySisId($sis_id);
    }

    public function getAllAccesosByModId($mod_id)
    {
        return $this->rolRepository->getAllAccesosByModId($mod_id);
    }

    public function getAllAccesosIdOfRol($rol_id)
    {
        return $this->rolRepository->getAllAccesosIdOfRol($rol_id);
    }

    public function saveRolAndAccesosMasivo($data,$accesosIds)
    {
        DB::beginTransaction();
        $result = null;
        try {
            $result = $this->rolRepository->save($data);
            if (count($accesosIds)>0){
                $this->rolRepository->saveRolAccesosMasivo($result->rol_id,$accesosIds);
            }
            DB::commit();
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            DB::rollBack();
            $result = null;
        }
        return $result;
    }

    public function updateRolAndAccesosMasivo($data,$accesosIds)
    {
        DB::beginTransaction();
        $result = null;
        try {
            $result = $this->rolRepository->update($data);
            $this->rolRepository->deleteAllRolAccesosByRolId($data['rol_id']);
            if (count($accesosIds)>0){
                $this->rolRepository->saveRolAccesosMasivo($result->rol_id,$accesosIds);
            }
            DB::commit();
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            DB::rollBack();
            $result = null;
        }
        return $result;
    }

    public function deleteAllRolAccesosByRolId($rol_id)
    {
        try {
            $this->rolRepository->deleteAllRolAccesosByRolId($rol_id);
            return true;
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            DB::rollBack();
            return false;
        }
    }

    public function getAllRolesIdByUsrId($usr_id)
    {
        return $this->rolRepository->getAllRolesIdByUsrId($usr_id);
    }

    public function saveAndUpdateUsuarioRolMasivoUsuario($usr_id,$rolesIds)
    {
        DB::beginTransaction();
        $result = true;
        try {
            $this->rolRepository->deleteAllUsuarioRolByUsrId($usr_id);
            if (count($rolesIds)>0){
                $this->rolRepository->saveUsuarioRolMasivoUsuario($usr_id,$rolesIds);
            }
            DB::commit();
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            DB::rollBack();
            $result = false;
        }
        return $result;
    }

    public function getAllAccesosByUsuarioId($usr_id)
    {
        return $this->rolRepository->getAllAccesosByUsuarioId($usr_id);
    }

}
