<?php


namespace App\Repositories;


use App\Models\ImagenNoticia;
use App\Models\Noticia;
use Illuminate\Support\Facades\DB;

class NoticiaRepository
{
    protected $noticia;
    public function __construct(Noticia $noticia)
    {
        $this->noticia = $noticia;
    }

    public function getById($not_id)
    {
        return $this->noticia->find($not_id);
    }

    public function getAllAc()
    {
        return $this->noticia->where([
            ['estado','=','AC']
        ])->with('imagenesNoticia')->get();
    }

    public function getAllAcByUnidadAndPaginateAndSearchAndSort($und_id,$searchtype,$search,$sort,$limit)
    {
        return $this->noticia->where([
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->orderBy('fecha','desc')
            ->with('imagenesNoticia')->paginate($limit);
    }

    public function save($data)
    {
        $noticia = new $this->noticia();
        $noticia->slug = $data['slug'];
        $noticia->und_id = $data['und_id'];
        $noticia->usr_id = $data['usr_id'];
        $noticia->antetitulo = $data['antetitulo'];
        $noticia->titulo = $data['titulo'];
        $noticia->resumen = $data['resumen'];
        $noticia->contenido = $data['contenido'];
        $noticia->imagen = $data['imagen'];
        $noticia->link_video = $data['link_video'];
        $noticia->categorias = $data['categorias'];
        $noticia->palabras_clave = $data['palabras_clave'];
        $noticia->publicar = $data['publicar'];
        $noticia->fecha = $data['fecha'];
        $noticia->fuente = $data['fuente'];
        $noticia->prioridad = $data['prioridad'];
        $noticia->fecha_registro = $data['fecha_registro'];
        $noticia->fecha_modificacion = $data['fecha_modificacion'];
        $noticia->estado = $data['estado'];
        $noticia->save();
        return $noticia->fresh();
    }

    public function update($data)
    {
        $noticia = $this->noticia->find($data['not_id']);
        $noticia->slug = $data['slug'];
        $noticia->usr_id = $data['usr_id'];
        $noticia->antetitulo = $data['antetitulo'];
        $noticia->titulo = $data['titulo'];
        $noticia->resumen = $data['resumen'];
        $noticia->contenido = $data['contenido'];
        if (isset($data['imagen'])){
            $noticia->imagen = $data['imagen'];
        }
        $noticia->link_video = $data['link_video'];
        $noticia->categorias = $data['categorias'];
        $noticia->palabras_clave = $data['palabras_clave'];
        $noticia->publicar = $data['publicar'];
        $noticia->fecha = $data['fecha'];
        $noticia->fuente = $data['fuente'];
        $noticia->prioridad = $data['prioridad'];
        $noticia->fecha_modificacion = $data['fecha_modificacion'];
        $noticia->save();
        return $noticia->fresh();
    }

    public function cambiarPublicar($data)
    {
        $noticia = $this->noticia->find($data['not_id']);
        $noticia->publicar = $data['publicar'];
        $noticia->usr_id = $data['usr_id'];
        $noticia->fecha_modificacion = $data['fecha_modificacion'];
        $noticia->save();
        return $noticia->fresh();
    }

    public function delete($data)
    {
        $noticia = $this->noticia->find($data['not_id']);
        $noticia->estado = $data['estado'];
        $noticia->usr_id = $data['usr_id'];
        $noticia->fecha_modificacion = $data['fecha_modificacion'];
        $noticia->save();
        return $noticia->fresh();
    }

    public function getImagenesNoticiaAcByNoticia($not_id)
    {
        return ImagenNoticia::where([
            ['estado','=','AC'],
            ['not_id','=',$not_id]
        ])->orderBy('titulo','asc')->get();
    }

    public function getImagenesNoticiaAcPaginateByNoticia($not_id,$limit)
    {
        return ImagenNoticia::where([
            ['estado','=','AC'],
            ['not_id','=',$not_id]
        ])->orderBy('titulo','asc')->paginate($limit);
    }

    public function saveImagenNoticia($data)
    {
        $imagen = new ImagenNoticia();
        $imagen->not_id = $data['not_id'];
        $imagen->titulo = $data['titulo'];
        $imagen->descripcion = $data['descripcion'];
        $imagen->fecha = $data['fecha'];
        $imagen->imagen = $data['imagen'];
        $imagen->publicar = $data['publicar'];
        $imagen->estado = $data['estado'];
        $imagen->tipo_imagen = $data['tipo_imagen'];
        $imagen->ancho = $data['ancho'];
        $imagen->alto = $data['alto'];
        $imagen->save();
        return $imagen->fresh();
    }

    public function updateImagenNoticia($data)
    {
        $imagen = ImagenNoticia::find($data['imn_id']);
        $imagen->titulo = $data['titulo'];
        $imagen->descripcion = $data['descripcion'];
        $imagen->fecha = $data['fecha'];
        if (isset($data['imagen'])){
            $imagen->imagen = $data['imagen'];
            $imagen->tipo_imagen = $data['tipo_imagen'];
            $imagen->ancho = $data['ancho'];
            $imagen->alto = $data['alto'];
        }
        $imagen->save();
        return $imagen->fresh();
    }

    public function cambiarPublicarImagenNoticia($data)
    {
        $imagen = ImagenNoticia::find($data['imn_id']);
        $imagen->publicar = $data['publicar'];
        $imagen->save();
        return $imagen->fresh();
    }

    public function deleteImagenNoticia($imn_id)
    {
        $imagen = ImagenNoticia::find($imn_id);
        $imagen->estado = 'EL';
        $imagen->save();
        return $imagen->fresh();
    }

    public function getImagenNoticiaById($imn_id)
    {
        return ImagenNoticia::find($imn_id);
    }

    public function existeSlugByNoticiaId($not_id,$slug)
    {
        return $noticia = $this->noticia->where([
            ['slug','=',$slug],
            ['not_id','<>',$not_id]
        ])->first();
    }

    public function existeSlugNoticia($slug)
    {
        return $noticia = $this->noticia->where([
            ['slug','=',$slug]
        ])->first();
    }

    public function getNoticiaBySlug($slug)
    {
        return $this->noticia->where([
            ['slug','=',$slug]
        ])->first();
    }

    public function getAllCategoriasNoticias()
    {
        $sql = "select DISTINCT(m1.claves)
                from
                (
                    select unnest(regexp_split_to_array(lower(categorias),',')) as claves
                    from
                    not_noticia where
                    publicar = 1
                    and estado = 'AC'
                ) as m1
                order by m1.claves asc ";
        return DB::select($sql);
    }

    public function getAllPalabrasClavesNoticias()
    {
        $sql = "select DISTINCT(m1.claves)
                from
                (
                    select unnest(regexp_split_to_array(lower(palabras_clave),',')) as claves
                    from
                    not_noticia where
                    publicar = 1
                    and estado = 'AC'
                ) as m1
                order by m1.claves asc ";
        return DB::select($sql);
    }

    public function getAllNoticiasAcAndPublicarSiByPalabraClave($palabraClave)
    {
        $whereSearch = " true ";
        if (!empty($palabraClave)){
            $whereSearch = "UPPER(nombre_producto) like '%".strtoupper($palabraClave)."%'";
        }
        return $this->noticia->where([
            ['publicar','=',1],
            ['estado','=','AC']
        ])->whereRaw($whereSearch)->orderBy('fecha','desc')->get();
    }

    public function getAllNoticiasPublicarSiAndAcBySearch($search)
    {
        $whereSearch = " true ";
        if (!empty($palabraClave)){
            $whereSearch = " UPPER(nombre_producto) like '%".strtoupper($search)."%'
             OR UPPER(titulo) like '%".strtoupper($search)."%'
             OR UPPER(resumen) like '%".strtoupper($search)."%'
             OR UPPER(contenido) like '%".strtoupper($search)."%'
             ";
        }
        return $this->noticia->where([
            ['publicar','=',1],
            ['estado','=','AC']
        ])->whereRaw($whereSearch)->orderBy('fecha','desc')->get();
    }

    public function getNoticiasPublicarSiAndAcByLimitAndPrioridadOfDespacho($limit,$prioridad)
    {
        return $this->noticia->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['prioridad','=',$prioridad]
        ])->whereHas('unidad', function ($query) {
            $query->where([
                ['estado','=','AC']
            ])->whereHas('tipoUnidad', function ($query2) {
                $query2->where('tipo', '=', 0);
            });
        })->orderBy('fecha','desc')->limit($limit)->get();
    }

    public function getNoticiasPublicarSiAndAcByLimitAndPrioridadOfNotIsDespacho($limit,$prioridad)
    {
        return $this->noticia->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['prioridad','=',$prioridad]
        ])->whereHas('unidad', function ($query) {
            $query->where([
                ['estado','=','AC']
            ])->whereHas('tipoUnidad', function ($query2) {
                $query2->where('tipo', '<>', 0);
            });
        })->orderBy('fecha','desc')->limit($limit)->get();
    }

    public function getNoticiasPublicarSiAndAcByLimitAndUnidad($und_id,$limit)
    {
        return $this->noticia->where([
            ['publicar','=',1],
            ['estado','=','AC']
        ])->whereHas('unidad', function ($query) use($und_id){
            $query->where([
                ['estado','=','AC'],
                ['und_id','=',$und_id]
            ]);
        })->orderBy('fecha','desc')->orderBy('prioridad','asc')->limit($limit)->get();
    }

    public function getAllAcPublicarSiAndPaginateAndSearchAndSort($limite,$search,$orden,$palabra,$categoria)
    {
        $campoOrden = 'fecha';
        $maneraOrden = 'desc';
        $whereRaw = ' true ';
        if (!empty($search)){
            $whereRaw = " UPPER(titulo) like '%".strtoupper($search)."%' ";
        }
        if (!empty($categoria)){
            $whereRaw .= " and UPPER(categorias) like '%".strtoupper($categoria)."%' ";
        }
        if (!empty($palabra)){
            $whereRaw .= " and UPPER(palabras_clave) like '%".strtoupper($palabra)."%' ";
        }
        $ruta = asset('storage/uploads/');
        return $this->noticia->where([
            ['estado','=','AC'],
            ['publicar','=',1]
        ])->whereRaw($whereRaw)
            ->orderBy($campoOrden,$maneraOrden)
            ->orderBy('prioridad','asc')
            //->with('imagenesNoticia')
            ->selectRaw("slug,antetitulo,titulo,CONCAT('$ruta','/',COALESCE(imagen,'')) as imagen,resumen,contenido,fecha,link_video as video,categorias,palabras_clave as palabrasClave")
            ->paginate($limite);
    }

    public function getAllByUnidadAcPublicarSiAndPaginateAndSearchAndSort($und_id,$limite,$search,$orden,$palabra,$categoria)
    {
        $campoOrden = 'fecha';
        $maneraOrden = 'desc';
        $whereRaw = ' true ';
        if (!empty($search)){
            $whereRaw = " UPPER(titulo) like '%".strtoupper($search)."%' ";
        }
        if (!empty($categoria)){
            $whereRaw .= " and UPPER(categorias) like '%".strtoupper($categoria)."%' ";
        }
        if (!empty($palabra)){
            $whereRaw .= " and UPPER(palabras_clave) like '%".strtoupper($palabra)."%' ";
        }
        $ruta = asset('storage/uploads/');
        return $this->noticia->where([
            ['estado','=','AC'],
            ['publicar','=',1],
            ['und_id','=',$und_id]
        ])->whereRaw($whereRaw)
            ->orderBy($campoOrden,$maneraOrden)
            ->orderBy('prioridad','asc')
            //->with('imagenesNoticia')
            ->selectRaw("slug,antetitulo,titulo,CONCAT('$ruta','/',COALESCE(imagen,'')) as imagen,resumen,contenido,fecha,link_video as video,categorias,palabras_clave as palabrasClave")
            ->paginate($limite);
    }

    public function getAllCategoriasNoticiasByUnidad($und_id)
    {
        $sql = "select DISTINCT(m1.claves)
                from
                (
                    select unnest(regexp_split_to_array(lower(categorias),',')) as claves
                    from
                    not_noticia where
                    publicar = 1
                    and estado = 'AC'
                    and und_id = $und_id
                ) as m1
                order by m1.claves asc ";
        return DB::select($sql);
    }

    public function getAllPalabrasClavesNoticiasByUnidad($und_id)
    {
        $sql = "select DISTINCT(m1.claves)
                from
                (
                    select unnest(regexp_split_to_array(lower(palabras_clave),',')) as claves
                    from
                    not_noticia where
                    publicar = 1
                    and estado = 'AC'
                    and und_id = $und_id
                ) as m1
                order by m1.claves asc ";
        return DB::select($sql);
    }

}
