<?php
namespace App\Services;
use App\Repositories\ImagenUnidadRepository;
use App\Repositories\UnidadRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UnidadService
{
    protected $unidadRepository;
    protected $imagenUnidadRepository;
    public function __construct(UnidadRepository $unidadRepository,ImagenUnidadRepository $imagenUnidadRepository)
    {
        $this->unidadRepository = $unidadRepository;
        $this->imagenUnidadRepository = $imagenUnidadRepository;
    }

    public function getUnidadDespacho()
    {
        return $this->unidadRepository->getUnidadDespacho();
    }

    public function getAllAcUnidadesParaComboSelectOrdenadosByTipo()
    {
        return $this->unidadRepository->getAllAcUnidadesParaComboSelectOrdenadosByTipo();
    }

    public function getAllAcUnidadesParaComboSelectOrdenadosByArrayTipoUnidad($array)
    {
        return $this->unidadRepository->getAllAcUnidadesParaComboSelectOrdenadosByArrayTipoUnidad($array);
    }

    public function update($data)
    {
        DB::beginTransaction();
        $result = null;
        try {
            $unidaddespacho = $this->unidadRepository->update($data);
            $result = $this->imagenUnidadRepository->update($unidaddespacho,$data);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getAllUnidadPaginateBySearchAndSort($tipoUnidad)
    {
        return $this->unidadRepository->getAllUnidadPaginateBySearchAndSort($tipoUnidad);
    }

    public function getById($rub_id)
    {
        $result = null;
        try {
            $result = $this->unidadRepository->getById($rub_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data,$texto)
    {
        $result = null;
        try {
            $result = $this->unidadRepository->delete($data,$texto);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getAllUnidadPaginateBySearchAndSortACAndEl($limit,$tipoUnidad)
    {
        return $this->unidadRepository->getAllUnidadPaginateBySearchAndSortACAndEl($limit,$tipoUnidad);
    }

    /// UNIDADES

    public function saveUnidad($data)
    {
        DB::beginTransaction();
        $result = null;
        try {
            $unidad = $this->unidadRepository->saveUnidad($data);
            $result = $this->imagenUnidadRepository->saveUnidad($unidad,$data);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function updateUnidad($data)
    {
        DB::beginTransaction();
        $result = null;
        try {
            $unidad = $this->unidadRepository->updateUnidad($data);
            $result = $this->imagenUnidadRepository->saveUnidad($unidad,$data);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getListaSecretariasAc()
    {
        return $this->unidadRepository->getListaSecretariasAc();
    }

    public function getListaServiciosDepartamentalesAc()
    {
        return $this->unidadRepository->getListaServiciosDepartamentalesAc();
    }

    public function updateMapaOrganigrama($data)
    {
        $result = null;
        try {
            return $this->unidadRepository->updateMapaOrganigrama($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getUnidadesDependientes($und_id)
    {
        return $this->unidadRepository->getUnidadesDependientes($und_id);
    }

    public function getAllIdsUnidadesDependientes($und_id)
    {
        return $this->unidadRepository->getAllIdsUnidadesDependientes($und_id);
    }

    public function getAllUnidadPaginateBySearchAndSortACAndEl2($limit,$tipoUnidad,$unidadesdependientes)
    {
        return $this->unidadRepository->getAllUnidadPaginateBySearchAndSortACAndEl2($limit,$tipoUnidad,$unidadesdependientes);
    }

}
