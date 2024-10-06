<?php


namespace App\Services;


use App\Repositories\PublicidadRepository;
use Illuminate\Support\Facades\Log;

class PublicidadService
{

    protected $publicidadRepository;
    public function __construct(PublicidadRepository $publicidadRepository)
    {
        $this->publicidadRepository = $publicidadRepository;
    }

    public function getAllPaginate($limit)
    {
        return $this->publicidadRepository->getAllPaginate($limit);
    }

    public function save($data)
    {
        $result = null;
        try {
            $result = $this->publicidadRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }
    public function getById($pub_id)
    {
        $result = null;
        try {
            $result = $this->publicidadRepository->getById($pub_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function update($data)
    {
        $result = null;
        try {
            $result = $this->publicidadRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data,$texto)
    {
        $result = null;
        try {
            $result = $this->publicidadRepository->delete($data,$texto);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->publicidadRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getAllPublicidadAcAndPublicarSiActivas()
    {
        return $this->publicidadRepository->getAllPublicidadAcAndPublicarSiActivas();
    }

}
