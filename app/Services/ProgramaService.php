<?php


namespace App\Services;

use App\Repositories\ProgramaRepository;
use Illuminate\Support\Facades\Log;

class ProgramaService
{
    protected $programaRepository;
    public function __construct(ProgramaRepository $programaRepository)
    {
        $this->programaRepository = $programaRepository;
    }
    public function getAllPaginateBySearchAndSort($limit,$und_id)
    {
        return $this->programaRepository->getAllPaginateBySearchAndSort($limit,$und_id);
    }

    public function save($data)
    {
        try {
            return $this->programaRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function update($data)
    {
        try {
            return $this->programaRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function getById($prg_id)
    {
        $result = null;
        try {
            $result = $this->programaRepository->getById($prg_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        try {
            return $this->programaRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->programaRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getProgramasPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search)
    {
        return $this->programaRepository->getProgramasPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search);
    }

    public function tieneDatosThisUnidad($und_id)
    {
        return $this->programaRepository->tieneDatosThisUnidad($und_id);
    }

}
