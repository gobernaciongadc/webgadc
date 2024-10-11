<?php

namespace App\Repositories;

use App\Models\ConSemanario;
use App\Models\VideoSonido;

class VideoSonidoRepository
{
    protected $videoSonido;
    public function __construct(VideoSonido $videoSonido)
    {
        $this->videoSonido = $videoSonido;
    }

    public function getAllPaginateBySearchAndSort($limit, $und_id)
    {
        return $this->videoSonido->where([
            ['estado', '=', 'AC'],
            ['und_id', '=', $und_id]
        ])->orderBy('fecha', 'desc')->paginate($limit);
    }

    public function save($data): ?VideoSonido
    {
        $videoSonido = new $this->videoSonido;
        $videoSonido->titulo = $data['titulo'];
        $videoSonido->descripcion = $data['descripcion'];
        $videoSonido->link_descarga = $data['link_descarga'];
        $videoSonido->fecha = $data['fecha'];
        $videoSonido->publicar = $data['publicar'];
        $videoSonido->und_id = $data['und_id'];
        $videoSonido->estado = 'AC';
        $videoSonido->save();
        return $videoSonido->fresh();
    }

    public function getById($vis_id): ?VideoSonido
    {
        $videoSonido = VideoSonido::find($vis_id);
        return $videoSonido;
    }

    public function update($data): ?VideoSonido
    {
        $videoSonido = VideoSonido::find($data['vis_id']);
        $videoSonido->titulo = $data['titulo'];
        $videoSonido->descripcion = $data['descripcion'];
        $videoSonido->link_descarga = $data['link_descarga'];
        $videoSonido->fecha = $data['fecha'];

        if (isset($data['publicar'])) {
            $videoSonido->publicar = $data['publicar'];
        }
        $videoSonido->und_id = $data['und_id'];
        $videoSonido->estado = 'AC';
        $videoSonido->save();
        return $videoSonido->fresh();
    }

    public function cambiarPublicar($data)
    {
        $videoSonido = $this->videoSonido->find($data['vis_id']);
        $videoSonido->publicar = $data['publicar'];
        $videoSonido->save();
        return $videoSonido->fresh();
    }

    public function delete($data)
    {
        $videoSonido = $this->videoSonido->find($data['vis_id']);
        $videoSonido->estado = $data['estado'];
        $videoSonido->save();
        return $videoSonido->fresh();
    }

    public function getVideosAndAudiosPublicarSiAndAcByLimitOfDespacho($limit)
    {
        return $this->videoSonido->where([
            ['publicar', '=', 1],
            ['estado', '=', 'AC']
        ])->whereHas('unidad', function ($query) {
            $query->where([
                ['estado', '=', 'AC']
            ])->whereHas('tipoUnidad', function ($query2) {
                $query2->where('tipo', '=', 0);
            });
        })->orderBy('fecha', 'desc')->limit($limit)->get();
    }

    /**
     * devuelve una lista paginada de videos y audios mesclados, de todas las unidades
     * ordenados por fecha desc
     * @param $limite
     * @param $orden
     * @return mixed
     */
    public function getAllAcPublicarSiAndPaginateAndSort($limite, $orden)
    {
        $campoOrden = 'fecha';
        $maneraOrden = 'desc';
        $whereRaw = ' true ';
        return $this->videoSonido->where([
            ['publicar', '=', 1],
            ['estado', '=', 'AC']
        ])->orderBy($campoOrden, $maneraOrden)
            ->select('titulo', 'descripcion', 'link_descarga as linkDescarga', 'fecha')
            ->paginate($limite);
    }


    public function getVideosAndAudiosPublicarSiAndAcByLimitOfUnidad($und_id, $limit)
    {
        return $this->videoSonido->where([
            ['publicar', '=', 1],
            ['estado', '=', 'AC'],
            ['und_id', '=', $und_id]
        ])->orderBy('fecha', 'desc')->limit($limit)->get();
    }

    public function getAllAcPublicarSiAndPaginateAndSortByUnidad($und_id, $limite, $orden)
    {
        $campoOrden = 'fecha';
        $maneraOrden = 'desc';
        $whereRaw = ' true ';
        return $this->videoSonido->where([
            ['publicar', '=', 1],
            ['estado', '=', 'AC'],
            ['und_id', '=', $und_id]
        ])->orderBy($campoOrden, $maneraOrden)
            ->select('titulo', 'descripcion', 'link_descarga as linkDescarga', 'fecha')
            ->paginate($limite);
    }


    // Modificaciones 2024
    public function getAllSemanariosModeloPaginateAndSort($limite, $orden)
    {
        $campoOrden = 'created_at';
        $maneraOrden = 'desc';

        // Recuperar seminarios junto con sus imágenes, paginados y ordenados
        return ConSemanario::with('img_semanarios') // Usar el nuevo nombre de la relación
            ->orderBy($campoOrden, $maneraOrden)
            ->select(
                'id',
                'edicion',
                'fecha_publicacion'
            ) // Seleccionar solo los campos necesarios
            ->paginate($limite);
    }
}
