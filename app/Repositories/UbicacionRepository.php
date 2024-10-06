<?php
namespace App\Repositories;

use App\Models\Ubicacion;
use Illuminate\Support\Facades\DB;

class UbicacionRepository
{
    protected $ubicacion;

    public function __construct(Ubicacion $ubicacion)
    {
        $this->ubicacion = $ubicacion;
    }

    public function getComboUbicacion()
    {
        return $this->listaUbicaciones = Ubicacion::select(
            DB::raw("CONCAT(ubi_ubicacion.unidad,' - ',ubi_ubicacion.lugar) AS nombre"), 'ubi_id')
            ->where([])->pluck("nombre", 'ubi_id', 'listaUbicaciones');
    }

    public function getAllPaginateBySearchAndSort($limit)
    {
        return $this->ubicacion->where([
            ['estado','=','AC']
        ])->paginate($limit);
    }

    public function save($data):?Ubicacion
    {
        $ubicacion = new $this->ubicacion;
        $ubicacion->unidad = $data['unidad'];
        $ubicacion->lugar = $data['lugar'];
        $ubicacion->direccion = $data['direccion'];
        $ubicacion->latitud = $data['latitud'];
        $ubicacion->longitud = $data['longitud'];
        $ubicacion->estado = 'AC';
        $ubicacion->usr_id = $data['usr_id'];
        $ubicacion->imagen = $data['imagen'];

        $ubicacion->save();
        return $ubicacion->fresh();
    }

    public function getById($ubi_id):?Ubicacion
    {
        $ubicacion = Ubicacion::find($ubi_id);
        return $ubicacion;
    }

    public function update($data)
    {
        $ubicacion = Ubicacion::find($data['ubi_id']);
        $ubicacion->unidad = $data['unidad'];
        $ubicacion->lugar = $data['lugar'];
        $ubicacion->direccion = $data['direccion'];
        $ubicacion->latitud = $data['latitud'];
        $ubicacion->longitud = $data['longitud'];
        $ubicacion->estado = 'AC';

        if(isset($data['usr_id'])){
            $ubicacion->usr_id = $data['usr_id'];
        }
        if(isset($data['imagen'])){
            $ubicacion->imagen = $data['imagen'];
        }

        $ubicacion->save();
        return $ubicacion->fresh();
    }

    public function delete($data)
    {
        $ubicacion = $this->ubicacion->find($data['ubi_id']);
        $ubicacion->estado = $data['estado'];
        $ubicacion->save();
        return $ubicacion->fresh();
    }

    public function getUbicacionesPublicarSiAndAcOfAllPaginado($limite,$orden,$search)
    {
        $ruta = asset('storage/uploads/');
        $campoOrden = 'unidad';
        $maneraOrden = 'asc';
        $whereRaw = ' true ';
        if (!empty($search)){
            $whereRaw = " UPPER(unidad) like '%".strtoupper($search)."%' ";
        }
        return $this->ubicacion->whereRaw($whereRaw)->where([
            ['estado','=','AC']
        ])->selectRaw("ubi_id as ubiid,unidad as nombreunidad")
            ->orderBy($campoOrden,$maneraOrden)
            ->paginate($limite);
    }

}
