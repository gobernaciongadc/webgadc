<?php
namespace App\Services;

use App\Repositories\SistemaApoyoRepository;
use Illuminate\Support\Facades\Log;

class SistemaApoyoService
{
    protected $sistemaApoyoRepository;
    public function __construct(SistemaApoyoRepository $sistemaApoyoRepository)
    {
        $this->sistemaApoyoRepository = $sistemaApoyoRepository;
    }

    public function getAllPaginate($limit)
    {
        return $this->sistemaApoyoRepository->getAllPaginate($limit);
    }

    public function save($data)
    {
        try {
            return $this->sistemaApoyoRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function update($data)
    {
        try {
            return $this->sistemaApoyoRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function getById($sia_id)
    {
        $result = null;
        try {
            $result = $this->sistemaApoyoRepository->getById($sia_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        try {
            return $this->sistemaApoyoRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->sistemaApoyoRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getAllSistemasAcAndPublicarSi()
    {
        return $this->sistemaApoyoRepository->getAllSistemasAcAndPublicarSi();
    }

}
