<?php


namespace App\Services;


use App\Repositories\ImagenUnidadRepository;

class ImagenUnidadService
{
    protected $imagenUnidadRepository;
    public function __construct(ImagenUnidadRepository $imagenUnidadRepository)
    {
        $this->imagenUnidadRepository = $imagenUnidadRepository;
    }
						 
    public function getImagenUnidadBannerByUnidadAndTipo($und_id,$tipo)
    {
        return $this->imagenUnidadRepository->getImagenUnidadBannerByUnidadAndTipo($und_id,$tipo);
    }

    public function getById($imu_id)
    {
        $result = null;
        try {
            $result = $this->imagenUnidadRepository->getById($imu_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

}
