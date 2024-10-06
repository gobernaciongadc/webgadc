<?php


namespace App\Services;


use App\Repositories\EventoRepository;
use Illuminate\Support\Facades\Log;

class EventoService
{
    protected $eventoRepository;
    public function __construct(EventoRepository $eventoRepository)
    {
        $this->eventoRepository = $eventoRepository;
    }

    public function getById($eve_id)
    {
        return $this->eventoRepository->getById($eve_id);
    }

    public function getAllAc()
    {
        return $this->eventoRepository->getAllAc();
    }

    public function getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,$limit)
    {
        return $this->eventoRepository->getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,$limit);
    }

    public function save($data)
    {
        try {
            return $this->eventoRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function update($data)
    {
        try {
            return $this->eventoRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->eventoRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function delete($data)
    {
        try {
            return $this->eventoRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function existeSlug($slug)
    {
        $existe = $this->eventoRepository->existeSlug($slug);
        return empty($existe)?false:true;
    }

    public function existeSlugById($est_id,$slug)
    {
        $existe = $this->eventoRepository->existeSlugById($est_id,$slug);
        return empty($existe)?false:true;
    }

    public function getEventosPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search)
    {
        return $this->eventoRepository->getEventosPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search);
    }

    public function getBySlug($slug)
    {
        return $this->eventoRepository->getBySlug($slug);
    }

    public function tieneDatosThisUnidad($und_id)
    {
        return $this->eventoRepository->tieneDatosThisUnidad($und_id);
    }

}
