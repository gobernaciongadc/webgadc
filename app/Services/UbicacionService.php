<?php

namespace App\Services;

use App\Repositories\UbicacionRepository;
use Illuminate\Support\Facades\Log;

class UbicacionService
{
    protected $ubicacionRepository;
    public function __construct(UbicacionRepository $ubicacionRepository)
    {
        $this->ubicacionRepository = $ubicacionRepository;
    }

    public function getComboUbicacion()
    {
        return $this->ubicacionRepository->getComboUbicacion();
    }

    public function getAllPaginateBySearchAndSort($limit)
    {
        return $this->ubicacionRepository->getAllPaginateBySearchAndSort($limit);
    }

    public function save($data)
    {
        try {
            return $this->ubicacionRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function update($data)
    {
        $result = null;
        try {
            return $this->ubicacionRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function getById($ubi_id)
    {
        $result = null;
        try {
            $result = $this->ubicacionRepository->getById($ubi_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        try {
            return $this->ubicacionRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getUbicacionesPublicarSiAndAcOfAllPaginado($limite,$orden,$search)
    {
        return $this->ubicacionRepository->getUbicacionesPublicarSiAndAcOfAllPaginado($limite,$orden,$search);
    }

}
