<?php


namespace App\Services;
use App\Repositories\ImagenUnidadGaleriaRepository;
use Illuminate\Support\Facades\Log;

class ImagenUnidadGaleriaService
{
    protected $imagenUnidadGaleriaRepository;
    public function __construct(ImagenUnidadGaleriaRepository $imagenUnidadGaleriaRepository)
    {
        $this->imagenUnidadGaleriaRepository = $imagenUnidadGaleriaRepository;
    }

    public function getAllPaginateImagenGaleriaByUnidad($limit,$und_id)
    {
        return $this->imagenUnidadGaleriaRepository->getAllPaginateImagenGaleriaByUnidad($limit,$und_id);
    }

    public function save($data)
    {
        $result = null;
        try {
            $result = $this->imagenUnidadGaleriaRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }
    public function getById($cat_id)
    {
        $result = null;
        try {
            $result = $this->imagenUnidadGaleriaRepository->getById($cat_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function update($data)
    {
        $result = null;
        try {
            $result = $this->imagenUnidadGaleriaRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        $result = null;
        try {
            $result = $this->imagenUnidadGaleriaRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }
    public function cambiarPublicar($data)
    {
        try {
            return $this->imagenUnidadGaleriaRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getImagenGaleriaAcAndPublicarSiOfDespacho($limit)
    {
        return $this->imagenUnidadGaleriaRepository->getImagenGaleriaAcAndPublicarSiOfDespacho($limit);
    }

    public function getImagenGaleriaAcAndPublicarSiOfUnidad($und_id,$limit)
    {
        return $this->imagenUnidadGaleriaRepository->getImagenGaleriaAcAndPublicarSiOfUnidad($und_id,$limit);
    }

    public function getGaleriaAcPublicarPaginate($limite,$orden,$und_id)
    {
        return $this->imagenUnidadGaleriaRepository->getGaleriaAcPublicarPaginate($limite,$orden,$und_id);
    }
}
