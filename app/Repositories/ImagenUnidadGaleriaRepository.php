<?php


namespace App\Repositories;


use App\Models\ImagenUnidadGaleria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ImagenUnidadGaleriaRepository
{
    protected $imagenUnidadGaleria;
    public function __construct(ImagenUnidadGaleria $imagenUnidadGaleria)
    {
        $this->imagenUnidadGaleria = $imagenUnidadGaleria;
    }

    public function getAllPaginateImagenGaleriaByUnidad($limit, $und_id)
    {
        return $this->imagenUnidadGaleria->where([
            ['und_id', '=', $und_id],
            ['estado', 'not like', 'EL']
        ])->orderBy('fecha', 'asc')->paginate($limit);
    }

    public function save($data): ?ImagenUnidadGaleria
    {
        $imagenUnidadGaleria = new $this->imagenUnidadGaleria;
        if (isset($data['imagen'])) {
            $imagenUnidadGaleria->imagen = $data['imagen'];
        }
        if (isset($data['publicar'])) {
            $imagenUnidadGaleria->publicar = $data['publicar'];
        }
        $imagenUnidadGaleria->alto = $data['alto'];
        $imagenUnidadGaleria->ancho = $data['ancho'];
        $imagenUnidadGaleria->tipo = $data['tipo'];
        $imagenUnidadGaleria->estado = 'AC';
        $imagenUnidadGaleria->titulo = $data['titulo'];
        $imagenUnidadGaleria->descripcion = $data['descripcion'];
        $imagenUnidadGaleria->fecha = $data['fecha'];
        $imagenUnidadGaleria->und_id = $data['und_id'];
        $imagenUnidadGaleria->save();
        return $imagenUnidadGaleria->fresh();
    }

    public function getById($und_id): ?ImagenUnidadGaleria
    {
        $imagenUnidadGaleria = ImagenUnidadGaleria::find($und_id);
        return $imagenUnidadGaleria;
    }

    public function update($data)
    {
        $imagenUnidadGaleria = ImagenUnidadGaleria::find($data['iug_id']);
        if (isset($data['imagen'])) {
            $imagenUnidadGaleria->imagen = $data['imagen'];
        }
        if (isset($data['publicar'])) {
            $imagenUnidadGaleria->publicar = $data['publicar'];
        }
        if (isset($data['alto'])) {
            $imagenUnidadGaleria->alto = $data['alto'];
        }
        if (isset($data['ancho'])) {
            $imagenUnidadGaleria->ancho = $data['ancho'];
        }
        if (isset($data['tipo'])) {
            $imagenUnidadGaleria->tipo = $data['tipo'];
        }
        $imagenUnidadGaleria->estado = 'AC';
        $imagenUnidadGaleria->titulo = $data['titulo'];
        $imagenUnidadGaleria->descripcion = $data['descripcion'];
        if (isset($data['fecha'])) {
            $imagenUnidadGaleria->fecha = $data['fecha'];
        }
        $imagenUnidadGaleria->und_id = $data['und_id'];
        $imagenUnidadGaleria->save();
        return $imagenUnidadGaleria->fresh();
    }

    public function delete($data)
    {
        $imagenUnidadGaleria = ImagenUnidadGaleria::find($data['iug_id']);
        $imagenUnidadGaleria->estado = 'EL';
        $imagenUnidadGaleria->save();
        return $imagenUnidadGaleria->fresh();
    }


    public function cambiarPublicar($data)
    {
        $imagenUnidadGaleria = $this->imagenUnidadGaleria->find($data['iug_id']);
        $imagenUnidadGaleria->publicar = $data['publicar'];
        $imagenUnidadGaleria->save();
        return $imagenUnidadGaleria->fresh();
    }

    public function getImagenGaleriaAcAndPublicarSiOfDespacho($limit)
    {
        return $this->imagenUnidadGaleria->where([
            ['publicar', '=', 1],
            ['estado', '=', 'AC']
        ])->whereHas('unidad', function ($query) {
            $query->where('estado', '=', 'AC');
            $query->whereHas('tipoUnidad', function ($query2) {
                $query2->where('tipo', '=', 0);
            });
        })->orderBy('fecha', 'desc')->limit($limit)->get();
    }

    public function getImagenGaleriaAcAndPublicarSiOfUnidad($und_id, $limit)
    {
        return $this->imagenUnidadGaleria->where([
            ['publicar', '=', 1],
            ['estado', '=', 'AC'],
            ['und_id', '=', $und_id]
        ])->orderBy('fecha', 'desc')->limit($limit)->get();
    }

    public function getGaleriaAcPublicarPaginate($limite, $orden, $und_id)
    {
        $ruta = asset('storage/uploads/');
        $campoOrden = 'fecha';
        $maneraOrden = 'desc';
        $whereRaw = ' true ';
        return $this->imagenUnidadGaleria->where([
            ['publicar', '=', 1],
            ['estado', '=', 'AC'],
            ['und_id', '=', $und_id]
        ])->orderBy($campoOrden, $maneraOrden)
            ->selectRaw("iug_id,titulo,descripcion,fecha,CONCAT('$ruta','/',COALESCE(imagen,'')) as imagen")
            ->paginate($limite);
    }
}
