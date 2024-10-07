<?php

namespace App\Services;

use App\Repositories\VideoSonidoRepository;
use Illuminate\Support\Facades\Log;

class VideoSonidoService
{
    protected $videoSonidoRepository;
    public function __construct(VideoSonidoRepository $videoSonidoRepository)
    {
        $this->videoSonidoRepository = $videoSonidoRepository;
    }

    public function getAllPaginateBySearchAndSort($limit, $und_id)
    {
        return $this->videoSonidoRepository->getAllPaginateBySearchAndSort($limit, $und_id);
    }

    public function save($data)
    {
        try {
            return $this->videoSonidoRepository->save($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function update($data)
    {
        try {
            return $this->videoSonidoRepository->update($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }
    public function getById($vis_id)
    {
        $result = null;
        try {
            $result = $this->videoSonidoRepository->getById($vis_id);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());
        }
        return $result;
    }

    public function delete($data)
    {
        try {
            return $this->videoSonidoRepository->delete($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function cambiarPublicar($data)
    {
        try {
            return $this->videoSonidoRepository->cambiarPublicar($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getVideosAndAudiosPublicarSiAndAcByLimitOfDespacho($limit)
    {
        return $this->videoSonidoRepository->getVideosAndAudiosPublicarSiAndAcByLimitOfDespacho($limit);
    }

    public function getAllAcPublicarSiAndPaginateAndSort($limite, $orden)
    {
        return $this->videoSonidoRepository->getAllAcPublicarSiAndPaginateAndSort($limite, $orden);
    }

    public function getVideosAndAudiosPublicarSiAndAcByLimitOfUnidad($und_id, $limit)
    {
        return $this->videoSonidoRepository->getVideosAndAudiosPublicarSiAndAcByLimitOfUnidad($und_id, $limit);
    }

    public function getAllAcPublicarSiAndPaginateAndSortByUnidad($und_id, $limite, $orden)
    {
        return $this->videoSonidoRepository->getAllAcPublicarSiAndPaginateAndSortByUnidad($und_id, $limite, $orden);
    }


    // Actualizaciones 2024
    public function getAllSemanariosPaginateAndSort($limite, $orden)
    {
        return $this->videoSonidoRepository->getAllSemanariosModeloPaginateAndSort($limite, $orden);
    }
}
