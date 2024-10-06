<?php
namespace App\Services;

use App\Repositories\PlanRepository;
use Illuminate\Support\Facades\Log;

class PlanService
{

    protected $planRepository;
    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function getAllPaginate($limit)
    {
        return $this->planRepository->getAllPaginate($limit);
    }

    public function save($data)
    {
        $result = null;
        try {
            $result = $this->planRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }
    public function getById($pla_id)
    {
        $result = null;
        try {
            $result = $this->planRepository->getById($pla_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function update($data)
    {
        $result = null;
        try {
            $result = $this->planRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data,$texto)
    {
        $result = null;
        try {
            $result = $this->planRepository->delete($data,$texto);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->planRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getAllPlanesAcPublicarSi()
    {
        return $this->planRepository->getAllPlanesAcPublicarSi();
    }

}
