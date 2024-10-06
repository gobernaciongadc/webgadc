<?php


namespace App\Services;


use App\Repositories\ProductoRepository;
use Illuminate\Support\Facades\Log;

class ProductoService
{
    protected $productoRepository;
    public function __construct(ProductoRepository $productoRepository)
    {
        $this->productoRepository = $productoRepository;
    }
    public function getAllPaginateBySearchAndSort($limit,$und_id)
    {
        return $this->productoRepository->getAllPaginateBySearchAndSort($limit,$und_id);
    }

    public function save($data)
    {
        try {
            return $this->productoRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function update($data)
    {
        try {
            return $this->productoRepository->update($data);
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
            $result = $this->productoRepository->getById($pro_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        try {
            return $this->productoRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->productoRepository->cambiarPublicar($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function existeSlug($slug)
    {
        $existe = $this->productoRepository->existeSlug($slug);
        return empty($existe)?false:true;
    }

    public function existeSlugById($pro_id,$slug)
    {
        $existe = $this->productoRepository->existeSlugById($pro_id,$slug);
        return empty($existe)?false:true;
    }

    public function getProductosPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search)
    {
        return $this->productoRepository->getProductosPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search);
    }

    public function getBySlug($slug)
    {
        return $this->productoRepository->getBySlug($slug);
    }

    public function tieneDatosThisUnidad($und_id)
    {
        return $this->productoRepository->tieneDatosThisUnidad($und_id);
    }

    public function eliminarProductoImagen($data)
    {
        try {
            return $this->productoRepository->eliminarProductoImagen($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

}
