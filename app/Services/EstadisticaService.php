<?php


namespace App\Services;


use App\Repositories\EstadisticaRepository;
use Illuminate\Support\Facades\Log;

class EstadisticaService
{
    protected $estadisticaRepository;
    public function __construct(EstadisticaRepository $estadisticaRepository)
    {
        $this->estadisticaRepository = $estadisticaRepository;
    }

    public function getById($est_id)
    {
        return $this->estadisticaRepository->getById($est_id);
    }

    public function getAllAc()
    {
        return $this->estadisticaRepository->getAllAc();
    }

    public function getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,$limit)
    {
        return $this->estadisticaRepository->getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,$limit);
    }

    public function save($data)
    {
        try {
            return $this->estadisticaRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function update($data)
    {
        try {
            return $this->estadisticaRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->estadisticaRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function delete($data)
    {
        try {
            return $this->estadisticaRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function existeSlug($slug)
    {
        $existe = $this->estadisticaRepository->existeSlug($slug);
        return empty($existe)?false:true;
    }

    public function existeSlugById($est_id,$slug)
    {
        $existe = $this->estadisticaRepository->existeSlugById($est_id,$slug);
        return empty($existe)?false:true;
    }

    public function getEstadisticasPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search)
    {
        return $this->estadisticaRepository->getEstadisticasPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search);
    }

    public function getBySlug($slug)
    {
        return $this->estadisticaRepository->getBySlug($slug);
    }

    public function tieneDatosThisUnidad($und_id)
    {
        return $this->estadisticaRepository->tieneDatosThisUnidad($und_id);
    }

}
