<?php
namespace App\Services;

use App\Repositories\ConvocatoriaRepository;
use Illuminate\Support\Facades\Log;

class ConvocatoriaService
{
    protected $convocatoriaRepository;
    public function __construct(ConvocatoriaRepository $convocatoriaRepository)
    {
        $this->convocatoriaRepository = $convocatoriaRepository;
    }

    public function getAllPaginateBySearchAndSort($limit,$und_id)
    {
        return $this->convocatoriaRepository->getAllPaginateBySearchAndSort($limit,$und_id);
    }

    public function save($data)
    {
        try {
            return $this->convocatoriaRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function update($data)
    {
        try {
            return $this->convocatoriaRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function getById($vis_id)
    {
        $result = null;
        try {
            $result = $this->convocatoriaRepository->getById($vis_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        try {
            return $this->convocatoriaRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->convocatoriaRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getConvocatoriasPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search)
    {
        return $this->convocatoriaRepository->getConvocatoriasPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search);
    }

}
