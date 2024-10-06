<?php
namespace App\Services;

use App\Repositories\RendicionCuentasRepository;
use Illuminate\Support\Facades\Log;

class RendicionCuentasService
{
    protected $rendicionCuentasRepository;
    public function __construct(RendicionCuentasRepository $rendicionCuentasRepository)
    {
        $this->rendicionCuentasRepository = $rendicionCuentasRepository;
    }

    public function getAllPaginateBySearchAndSort($limit,$und_id)
    {
        return $this->rendicionCuentasRepository->getAllPaginateBySearchAndSort($limit,$und_id);
    }

    public function save($data)
    {
        try {
            return $this->rendicionCuentasRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function update($data)
    {
        try {
            return $this->rendicionCuentasRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function getById($rec_id)
    {
        $result = null;
        try {
            $result = $this->rendicionCuentasRepository->getById($rec_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        try {
            return $this->rendicionCuentasRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->rendicionCuentasRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getRendicionesPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search)
    {
        return $this->rendicionCuentasRepository->getRendicionesPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search);
    }

}
