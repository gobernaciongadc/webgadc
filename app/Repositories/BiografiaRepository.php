<?php


namespace App\Repositories;
use App\Models\Biografia;
use App\Models\Unidad;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BiografiaRepository
{
    protected $biografia;

    public function __construct(Biografia $biografia)
    {
        $this->biografia = $biografia;
    }

    public function getComboBiografia()
    {
        return $this->listaBiografias = Biografia::select(
            DB::raw("CONCAT(bio_biografia.nombres,' - ',bio_biografia.apellidos) AS nombre"), 'bio_id')
            ->where([])->pluck("nombre", 'bio_id', 'listaBiografias');
    }

    public function getAllPaginateBySearchAndSort($limit)
    {
        return $this->biografia->where([
            ['estado','=','AC']
        ])->paginate($limit);
    }

    public function save($data):?Biografia
    {
        $biografia = new $this->biografia;
        $biografia->nombres = $data['nombres'];
        $biografia->apellidos = $data['apellidos'];
        $biografia->profesion = $data['profesion'];
        $biografia->resenia = $data['resenia']; 
        $biografia->estado = 'AC';
        if(isset($data['imagen_foto'])){
            $biografia->imagen_foto = $data['imagen_foto'];
        }
        $biografia->save();
        return $biografia->fresh();
    }

    public function getById($und_id):?Biografia
    {
        $biografia = Biografia::find($und_id);
        return $biografia;
    }

    public function update($data):?Biografia
    {
        $biografia = Biografia::find($data['bio_id']);
        $biografia->nombres = $data['nombres'];
        $biografia->apellidos = $data['apellidos'];
        $biografia->profesion = $data['profesion'];
        $biografia->resenia = $data['resenia']; 
        $biografia->estado = 'AC';
        if(isset($data['imagen_foto'])){
            $biografia->imagen_foto = $data['imagen_foto'];
        }
        $biografia->save();
        return $biografia->fresh();
    }

    public function delete($data)
    {
        $biografia = $this->biografia->find($data['bio_id']);
        $biografia->estado = $data['estado'];
        $biografia->save();
        return $biografia->fresh();
    }

    public function getBiografiaGobernador()
    {
        $despacho = Unidad::where([
            ['estado','=','AC']
        ])->whereHas('tipoUnidad', function ($query) {
            $query->where('tipo', '=', 0);
        })->first();
        if (!empty($despacho)){
            $biografia = $this->biografia->find($despacho->bio_id);
            if (!empty($biografia)){
                return $biografia;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }


}
