<?php
namespace App\Repositories;

use App\Models\Producto;
use App\Models\ProductoImagen;

class ProductoRepository
{
    protected $producto;
    public function __construct(Producto $producto)
    {
        $this->producto = $producto;
    }
    public function getAllPaginateBySearchAndSort($limit,$und_id)
    {
        return $this->producto->where([
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->orderBy('fecha_registro','desc')->paginate($limit);
    }

    public function save($data):?Producto
    {
        $producto = new $this->producto;
        $producto->nombre = $data['nombre'];
        $producto->descripcion = $data['descripcion'];
        $producto->fecha_modificacion = $data['fecha_registro'];
        $producto->fecha_registro = $data['fecha_registro'];
        $producto->publicar = $data['publicar'];
        $producto->slug = $data['slug'];
        $producto->und_id = $data['und_id'];
        $producto->usr_id = $data['usr_id'];
        $producto->estado = 'AC';
        $producto->save();
        $producto->fresh();
        if(isset($data['imagenes'])){
            $imagenes = $data['imagenes'];
            if(count($imagenes) > 0){
                foreach ($imagenes as $imagen){
                    $ima = new ProductoImagen();
                    $ima->titulo = $imagen['titulo'];
                    $ima->descripcion = $imagen['descripcion'];
                    $ima->imagen = $imagen['imagen'];
                    $ima->publicar = $imagen['publicar'];
                    $ima->estado = $imagen['estado'];
                    $ima->tipo_imagen = $imagen['tipo_imagen'];
                    $ima->ancho = $imagen['ancho'];
                    $ima->alto = $imagen['alto'];
                    $ima->pro_id = $producto->pro_id;
                    $ima->save();
                }
            }
        }
        return $producto;
    }

    public function getById($pro_id):?Producto
    {
        $producto = Producto::find($pro_id);
        return $producto;
    }

    public function update($data):?Producto
    {
        $producto = Producto::find($data['pro_id']);
        $producto->nombre = $data['nombre'];
        $producto->descripcion = $data['descripcion'];
        $producto->fecha_modificacion = $data['fecha_modificacion'];
        $producto->slug = $data['slug'];
        $producto->und_id = $data['und_id'];
        $producto->usr_id = $data['usr_id'];
        $producto->estado = 'AC';
        $producto->save();
        $producto->fresh();
        if(isset($data['imagenes'])){
            $imagenes = $data['imagenes'];
            if(count($imagenes) > 0){
                foreach ($imagenes as $imagen){
                    $ima = new ProductoImagen();
                    $ima->titulo = $imagen['titulo'];
                    $ima->descripcion = $imagen['descripcion'];
                    $ima->imagen = $imagen['imagen'];
                    $ima->publicar = $imagen['publicar'];
                    $ima->estado = $imagen['estado'];
                    $ima->tipo_imagen = $imagen['tipo_imagen'];
                    $ima->ancho = $imagen['ancho'];
                    $ima->alto = $imagen['alto'];
                    $ima->pro_id = $producto->pro_id;
                    $ima->save();
                }
            }
        }
        return $producto;
    }

    public function cambiarPublicar($data)
    {
        $producto = $this->producto->find($data['pro_id']);
        $producto->publicar = $data['publicar'];
        $producto->save();
        return $producto->fresh();
    }

    public function delete($data)
    {
        $producto = $this->producto->find($data['pro_id']);
        $producto->estado = $data['estado'];
        $producto->save();
        return $producto->fresh();
    }
    public function existeSlug($slug)
    {
        return $existe = $this->producto->where([
            ['slug','=',$slug]
        ])->first();
    }

    public function existeSlugById($pro_id,$slug)
    {
        return $existe = $this->producto->where([
            ['slug','=',$slug],
            ['pro_id','<>',$pro_id]
        ])->first();
    }

    public function getProductosPublicarSiAndAcOfUnidadPaginado($und_id,$limite,$orden,$search)
    {
        $ruta = asset('storage/uploads/');
        $campoOrden = 'nombre';
        $maneraOrden = 'asc';
        $whereRaw = ' true ';
        if (!empty($search)){
            $whereRaw = " UPPER(nombre) like '%".strtoupper($search)."%' ";
        }
        return $this->producto->whereRaw($whereRaw)->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])
            //->selectRaw("slug,nombre,CONCAT('$ruta','/',COALESCE(imagen,'')) as imagen")
            ->selectRaw("slug,nombre,(select CONCAT('$ruta','/',COALESCE(ima.imagen,'')) from pri_producto_imagen as ima where ima.pro_id = pro_producto.pro_id and ima.estado = 'AC' limit 1) as imagen")
            ->orderBy($campoOrden,$maneraOrden)
            ->paginate($limite);
    }

    public function getBySlug($slug)
    {
        return $this->producto->where([
            ['slug','=',$slug]
        ])->first();
    }

    public function tieneDatosThisUnidad($und_id)
    {
        $cantidad = $this->producto->where([
            ['publicar','=',1],
            ['estado','=','AC'],
            ['und_id','=',$und_id]
        ])->count();
        return ($cantidad > 0);
    }

    public function eliminarProductoImagen($data)
    {
        $imagen = ProductoImagen::find($data['pri_id']);
        $imagen->estado = $data['estado'];
        $imagen->save();
        return $imagen->fresh();
    }

}
