<?php
namespace App\Services;

use App\Repositories\ServicioPublicoRepository;
use Illuminate\Support\Facades\Log;

class ServicioPublicoService
{
    protected $servicioPublicoRepository;
    public function __construct(ServicioPublicoRepository $servicioPublicoRepository)
    {
        $this->servicioPublicoRepository = $servicioPublicoRepository;
    }
    public function getAllPaginateBySearchAndSort($limit,$und_id)
    {
        return $this->servicioPublicoRepository->getAllPaginateBySearchAndSort($limit,$und_id);
    }

    public function save($data)
    {
        try {
            return $this->servicioPublicoRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function update($data)
    {
        try {
            return $this->servicioPublicoRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function getById($sep_id)
    {
        $result = null;
        try {
            $result = $this->servicioPublicoRepository->getById($sep_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        try {
            return $this->servicioPublicoRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->servicioPublicoRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function existeSlug($slug)
    {
        $existe = $this->servicioPublicoRepository->existeSlug($slug);
        return empty($existe)?false:true;
    }

    public function existeSlugById($sep_id,$slug)
    {
        $existe = $this->servicioPublicoRepository->existeSlugById($sep_id,$slug);
        return empty($existe)?false:true;
    }

    public function getServiciosPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search)
    {
        return $this->servicioPublicoRepository->getServiciosPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search);
    }

    public function getBySlug($slug)
    {
        return $this->servicioPublicoRepository->getBySlug($slug);
    }

    public function tieneDatosThisUnidad($und_id)
    {
        return $this->servicioPublicoRepository->tieneDatosThisUnidad($und_id);
    }

    public function eliminarServicioImagen($data)
    {
        try {
            return $this->servicioPublicoRepository->eliminarServicioImagen($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

}
