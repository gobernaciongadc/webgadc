<?php
namespace App\Services;


use App\Repositories\ProyectoRepository;
use Illuminate\Support\Facades\Log;

class ProyectoService
{
    protected $proyectoRepository;
    public function __construct(ProyectoRepository $proyectoRepository)
    {
        $this->proyectoRepository = $proyectoRepository;
    }

    public function getAllPaginateBySearchAndSort($limit,$und_id)
    {
        return $this->proyectoRepository->getAllPaginateBySearchAndSort($limit,$und_id);
    }

    public function save($data)
    {
        try {
            return $this->proyectoRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function update($data)
    {
        try {
            return $this->proyectoRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function getById($pro_id)
    {
        $result = null;
        try {
            $result = $this->proyectoRepository->getById($pro_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        try {
            return $this->proyectoRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->proyectoRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getProyectosPublicarSiAndAcOfAllPaginadoOfUnidad($und_id,$limite,$orden,$search)
    {
        return $this->proyectoRepository->getProyectosPublicarSiAndAcOfAllPaginadoOfUnidad($und_id,$limite,$orden,$search);
    }

    public function tieneDatosThisUnidad($und_id)
    {
        return $this->proyectoRepository->tieneDatosThisUnidad($und_id);
    }

    public function eliminarProyectoImagen($data)
    {
        try {
            return $this->proyectoRepository->eliminarProyectoImagen($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

}
