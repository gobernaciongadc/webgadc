<?php
namespace App\Services;


use App\Repositories\BiografiaRepository;
use Illuminate\Support\Facades\Log;

class BiografiaService
{
    protected $biografiaRepository;
    public function __construct(BiografiaRepository $biografiaRepository)
    {
        $this->biografiaRepository = $biografiaRepository;
    }

    public function getComboBiografia()
    {
        return $this->biografiaRepository->getComboBiografia();
    }

    public function getAllPaginateBySearchAndSort($limit)
    {
        return $this->biografiaRepository->getAllPaginateBySearchAndSort($limit);
    }

    public function save($data)
    {
        try {
            return $this->biografiaRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function update($data)
    {
        try {
            return $this->biografiaRepository->update($data);
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
            $result = $this->biografiaRepository->getById($vis_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        try {
            return $this->biografiaRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getBiografiaGobernador()
    {
        return $this->biografiaRepository->getBiografiaGobernador();
    }

}
